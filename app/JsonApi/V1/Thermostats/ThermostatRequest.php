<?php

namespace App\JsonApi\V1\Thermostats;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class ThermostatRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'is-active' => [ 'boolean'],
        ];
    }
}
