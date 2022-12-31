<?php

namespace App\Services;

use App\Models\Program;
use App\Models\Thermostat;

/**
 * ProgramService
 *
 * @category Service
 * @package  App\Services
 * @author   Thomas van der Westen <post@thomasvanderwesten.nl>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class ProgramService
{
    /**
     * "Get the program that is currently active for the given thermostat."
     *
     * @param Thermostat $thermostat The thermostat object.
     *
     * @return Program|null A Program object or null
     */
    public function getCurrentProgram(Thermostat $thermostat): Program|null
    {
        $timezone = new \DateTimeZone($thermostat->timezone);

        $currentDayNumber = now($timezone)->dayOfWeek + 1;
        $currentTime = now($timezone)->format('H:i:s'); // 00:00:00 - 23:59:59

        $program = Program::where('thermostat_id', $thermostat->id)
            ->where('days', 'like', "%{$currentDayNumber}%")
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->where('is_active', true)
            ->first();

        return $program;
    }
}
