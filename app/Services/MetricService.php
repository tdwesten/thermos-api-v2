<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\Program;
use App\Models\Thermostat;

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
        if ($thermostat->program) {
            $metric->program()->associate($thermostat->program);
        }
        $metric->save();
    }
}
