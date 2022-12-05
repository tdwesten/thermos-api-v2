<?php

namespace App\Policies;

use App\Models\Thermostat;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThermostatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Thermostat  $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Thermostat $thermostat)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Thermostat  $currentThermostat
     * @param  \App\Models\Thermostat  $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Thermostat $currentThermostat, Thermostat $thermostat)
    {
        return $currentThermostat->id === $thermostat->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Thermostat  $currentThermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Thermostat $currentThermostat)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Thermostat  $currentThermostat
     * @param  \App\Models\Thermostat  $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Thermostat $currentThermostat, Thermostat $thermostat)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Thermostat  $currentThermostat
     * @param  \App\Models\Thermostat  $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Thermostat $currentThermostat, Thermostat $thermostat)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Thermostat  $currentThermostat
     * @param  \App\Models\Thermostat  $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Thermostat $currentThermostat, Thermostat $thermostat)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Thermostat  $currentThermostat
     * @param  \App\Models\Thermostat  $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function sync(Thermostat $thermostat)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Thermostat  $currentThermostat
     * @param  \App\Models\Thermostat  $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Thermostat $currentThermostat, Thermostat $thermostat)
    {
        //
    }

    /**
     * Authorize a user to view a post's author.
     *
     * @param Thermostat $currentThermostat
     * @param  \App\Models\Thermostat  $thermostat
     * @return bool
     */
    public function viewPrograms(Thermostat $currentThermostat, Thermostat $thermostat): bool
    {
        return $currentThermostat->id === $thermostat->id;
    }
}
