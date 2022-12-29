<?php

namespace App\Services;

enum ThermostatMode: string
{
    case Default = 'default';
    case Program = 'program';
    case Manual = 'manual';
    case Off = 'off';
}
