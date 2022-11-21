<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\Thermostat;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy
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
        return $thermostat;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Thermostat  $thermostat
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Thermostat $thermostat, Program $program)
    {
        return $thermostat->id === $program->thermostat_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Thermostat  $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Thermostat $thermostat)
    {
        return $thermostat;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Thermostat  $thermostat
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Thermostat $thermostat, Program $program)
    {
        return $thermostat->id === $program->thermostat_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Thermostat  $thermostat
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Thermostat $thermostat, Program $program)
    {
        return $thermostat->id === $program->thermostat_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Thermostat  $thermostat
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Thermostat $thermostat, Program $program)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Thermostat  $thermostat
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Thermostat $thermostat, Program $program)
    {
        //
    }
}
