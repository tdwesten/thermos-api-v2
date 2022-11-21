<?php

namespace App\Policies;

use App\Models\Heartbeat;
use App\Models\Thermostat;
use Illuminate\Auth\Access\HandlesAuthorization;

class HeartbeatPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Thermostat $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Thermostat $thermostat)
    {
        return $thermostat;
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Thermostat $thermostat
     * @param  \App\Models\Heartbeat $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Thermostat $thermostat, Heartbeat $model)
    {
        return $thermostat->getThermostat()->getId() === $model->getThermostat();
    }

        /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Thermostat $thermostat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Thermostat $thermostat)
    {
        return $thermostat;
    }
}
