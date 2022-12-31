<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\Program;
use App\Models\Thermostat;
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
        $metric->temperature = $thermostat->current_temperature;
        $metric->target_temperature = $thermostat->target_temperature;
        $metric->is_heating = $thermostat->is_heating;
        if ($thermostat->currentProgram()) {
            $metric->program()->associate($thermostat->currentProgram()->getResults());
        }
        $metric->save();

        Log::info('Created metric for thermostat ' . $thermostat->id);
    }
}