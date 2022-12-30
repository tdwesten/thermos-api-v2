<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\Program;

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
     * @param int     $temperature       Current temperature
     * @param int     $targetTemperature Target temperature
     * @param bool    $isHeating         Is heating
     * @param Program $program           Current Program
     *
     * @return array
     */
    public function create(
        int $temperature,
        int $targetTemperature,
        bool $isHeating,
        Program $program = null
    ): void {
        $metric = new Metric();
        $metric->temperature = $temperature;
        $metric->target_temperature = $targetTemperature;
        $metric->is_heating = $isHeating;
        $metric->program()->associate($program);
        $metric->save();
    }
}
