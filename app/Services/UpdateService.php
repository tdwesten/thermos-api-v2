<?php

namespace App\Services;

use App\Models\Program;
use App\Models\Thermostat;
use Illuminate\Support\Carbon;
use App\Services\ThermostatMode;

/**
 * UpdateService
 *
 * @category Service
 * @package  App\Services
 * @author   Thomas van der Westen <post@thomasvanderwesten.nl>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class UpdateService
{
    /**
     * Process the update
     *
     * @param Thermostat $thermostat         The thermostat object.
     * @param integer    $currentTemperature The current temperature.
     *
     * @return Thermostat
     */
    public function processUpdate(Thermostat $thermostat, int $currentTemperature): Thermostat
    {
        $programService = new ProgramService();
        $program = $programService->getCurrentProgram($thermostat);

        if ($thermostat->is_active === false || $thermostat->is_active === null) {
            return $this->useOffMode($thermostat, $currentTemperature);
        }

        $thermostat->current_temperature = $currentTemperature;
        $timezone = new \DateTimeZone('Europe/Amsterdam');
        // Manual mode
        if ($thermostat->last_manual_change && Carbon::parse($thermostat->last_manual_change, $timezone)->diffInMinutes(now($timezone)) < 15) {
            return $this->useManualMode($thermostat, $currentTemperature);
        }

        // Program mode
        if ($program) {
            return $this->useProgramMode($thermostat, $program, $currentTemperature);
        }

        // Default mode
        return $this->useFallbackMode($thermostat, $currentTemperature);
    }
    /**
     * Apply the default mode
     *
     * @param Thermostat $thermostat         The thermostat object.
     * @param integer    $currentTemperature The current temperature.
     *
     * @return Thermostat
     */
    public function useFallbackMode(Thermostat $thermostat, int $currentTemperature): Thermostat
    {
        $thermostat->mode = ThermostatMode::Default;
        $thermostat->is_heating = $this->maybeTurnHeatingOn($currentTemperature, $thermostat->min_temperature);
        $thermostat->current_temperature = $currentTemperature;
        $thermostat->currentProgram()->disassociate();

        $thermostat->save();

        return $thermostat;
    }

    /**
     * Apply the "off" mode
     *
     * @param Thermostat $thermostat The thermostat object.
     *
     * @return Thermostat
     */
    public function useOffMode(Thermostat $thermostat, int $currentTemperature): Thermostat
    {
        $thermostat->mode = ThermostatMode::Off;
        $thermostat->is_heating = false;
        $thermostat->current_temperature = $currentTemperature;
        $thermostat->currentProgram()->disassociate();

        $thermostat->save();

        return $thermostat;
    }

    /**
     * Set program mode and update the thermostat based on the program
     *
     * @param Thermostat $thermostat         The thermostat object.
     * @param Program    $program            The program that the thermostat is currently in.
     * @param int        $currentTemperature The current temperature of the thermostat
     *
     * @return Thermostat A thermostat object
     */
    public function useProgramMode(Thermostat $thermostat, Program $program, int $currentTemperature): Thermostat
    {
        $thermostat->mode = ThermostatMode::Program;
        $thermostat->is_heating = $this->maybeTurnHeatingOn($currentTemperature, $program->target_temperature);
        $thermostat->currentProgram()->associate($program);

        $thermostat->target_temperature = $program->target_temperature;

        $thermostat->save();

        return $thermostat;
    }

    /**
     * If the thermostat is heating, and the current temperature is greater than or equal to the target
     * temperature, then stop heating. If the thermostat is not heating, and the current temperature is
     * less than or equal to the target temperature, then start heating
     *
     * @param Thermostat thermostat The thermostat object
     * @param bool isHeating true if the thermostat is currently heating, false if it's cooling
     * @param int currentTemperature The current temperature of the room
     *
     * @return Thermostat The thermostat object.
     */
    public function useManualMode(Thermostat $thermostat, int $currentTemperature): Thermostat
    {
        $thermostat->mode = ThermostatMode::Manual;
        $thermostat->is_heating = $this->maybeTurnHeatingOn($currentTemperature, $thermostat->target_temperature);
        $thermostat->currentProgram()->disassociate();

        $thermostat->save();

        return $thermostat;
    }

    /**
     * If the current temperature is higher than the target temperature, return false, otherwise
     * return true.
     *
     * @param int currentTemperature The current temperature of the room
     * @param int targetTemperature the temperature we want to reach
     *
     * @return bool A boolean value.
     */
    public function maybeTurnHeatingOn(int $currentTemperature, int $targetTemperature): bool
    {
        if ($currentTemperature > $targetTemperature) {
            return false;
        }

        return true;
    }

    /**
     * Increase manualy the target temperature by 50
     *
     * @param Thermostat $thermostat
     * @return Thermostat
     */
    public function increaseTargetTemperature(Thermostat $thermostat): Thermostat
    {
        $thermostat->target_temperature = $thermostat->target_temperature + 50;
        $thermostat->last_manual_change = now();
        $thermostat->save();

        $thermostat = $this->processUpdate($thermostat, $thermostat->current_temperature);

        return $thermostat;
    }

    /**
     * Decrease manualy the target temperature by 50
     *
     * @param Thermostat $thermostat
     * @return Thermostat
     */
    public function decreaseTargetTemperature(Thermostat $thermostat): Thermostat
    {
        $thermostat->target_temperature = $thermostat->target_temperature - 50;
        $thermostat->last_manual_change = now();

        $thermostat->save();

        $thermostat = $this->processUpdate($thermostat, $thermostat->current_temperature);

        return $thermostat;
    }

    public function reset(Thermostat $thermostat): Thermostat
    {
        $thermostat->target_temperature = $thermostat->min_temperature;
        $thermostat->last_manual_change = null;

        $thermostat->save();

        $thermostat = $this->processUpdate($thermostat, $thermostat->current_temperature);

        return $thermostat;
    }
}
