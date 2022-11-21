<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use App\Models\Thermostat as ModelsThermostat;

class ThermostatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thermostat = ModelsThermostat::create([
            'name' => 'Surinamelaan 62b',
            'email' => 'post@thomasvanderwesten.nl',
            'password' => 'Thomas88!1',
        ]);

        Program::create([
            'thermostat_id' => $thermostat->id,
            'name' => 'Werk',
            'start_time' => '07:00',
            'end_time' => '17:00',
            'target_temperature' => 1950,
            'days' => json_encode([1, 2, 3, 4, 5]),
            'is_active' => true,
        ]);

        Program::create([
            'thermostat_id' => $thermostat->id,
            'name' => 'Weekend',
            'start_time' => '07:00',
            'end_time' => '17:00',
            'target_temperature' => 1650,
            'days' => json_encode([6, 7]),
            'is_active' => true,
        ]);
    }
}
