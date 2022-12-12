<?php

namespace App\JsonApi\V1\Programs;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class ProgramRequest extends ResourceRequest
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
            'start-time' => [ 'required'],
            'end-time' => [ 'required'],
            'is-active' => ['required', 'boolean'],
            'days' => ['required', 'array'],
            'target-temperature' => ['required', 'numeric'],
            'thermostat' => JsonApiRule::toOne(),
        ];
    }
}
