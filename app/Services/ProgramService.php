<?php

namespace App\Services;

use App\Models\Program;
use App\Models\Thermostat;

class ProgramService
{
    /**
     * "Get the program that is currently active for the given thermostat."
     *
     * @param Thermostat thermostat The thermostat object that you want to get the current program for.
     *
     * @return Program|null A Program object or null
     */
    public function getCurrentProgram(Thermostat $thermostat): Program|null
    {
        $currentDayNumber = now()->dayOfWeek + 1; // 1 = Sunday, 7 = Saturday
        $currentTime = now()->format('H:i:s'); // 00:00:00 - 23:59:59

        $program = Program::where('thermostat_id', $thermostat->id)
            ->where('days', 'like', "%{$currentDayNumber}%")
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->where('is_active', true)
            ->first();

        return $program;
    }
}
