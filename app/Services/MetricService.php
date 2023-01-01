<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Metric;
use App\Models\Program;
use App\Models\Thermostat;
use App\Enums\MetricInterval;
use Illuminate\Support\Facades\Log;

/**
 * MetricService
 *
 * @category Service
 * @package  App\Services
 * @author   Thomas van der Westen <post@thomasvanderwesten.nl>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class MetricService
{
    /**
     * Create metric
     *
     * @param Thermostat $thermostat The thermostat object.
     *
     * @return array
     */
    public function create(
        Thermostat $thermostat,
    ): void {
        $metric = new Metric();
        $metric->thermostat()->associate($thermostat);
        $metric->temperature = $thermostat->current_temperature;
        $metric->target_temperature = $thermostat->target_temperature;
        $metric->is_heating = $thermostat->is_heating;
        $metric->interval = MetricInterval::Minute->value;

        if ($thermostat->currentProgram()) {
            $metric->program()->associate($thermostat->currentProgram()->getResults());
        }
        $metric->save();

        Log::info('Created metric for thermostat ' . $thermostat->id);

        // $this->summerizeMetricsByHour(1, $thermostat);
    }

    /**
     * Summerize metrics
     *
     * @param string     $interval   The interval to summerize.
     * @param Thermostat $thermostat The thermostat object.
     *
     * @return void
     */
    public function summerizeMetricsByHour($interval, $thermostat):void
    {
        $metrics = Metric::where('thermostat_id', $thermostat->id)
            ->where('interval', MetricInterval::Minute->value)
            ->where('created_at', '>=', now()->subDays(1))
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('h');
            })
            ->get();

        $summerizedMetric = new Metric();
        $summerizedMetric->thermostat()->associate($thermostat);
        $summerizedMetric->temperature = $metrics->avg('temperature');
        $summerizedMetric->target_temperature = $metrics->avg('target_temperature');
        $summerizedMetric->is_heating = $metrics->avg('is_heating');
        $summerizedMetric->created_at = $metrics->max('created_at');
        $summerizedMetric->updated_at = $metrics->max('created_at');
        $summerizedMetric->interval = MetricInterval::Hourly->value;


        $summerizedMetric->save();

        Log::info('Summerized metric for thermostat ' . $summerizedMetric->id);

    }
}
