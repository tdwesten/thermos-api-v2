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
            'start-time' => [ 'required', 'date_format:H:i'],
            'end-time' => [ 'required', 'date_format:H:i'],
            'is-active' => ['required', 'boolean'],
            'days' => ['required', 'array'],
            'thermostat' => JsonApiRule::toOne(),
        ];
    }
}
