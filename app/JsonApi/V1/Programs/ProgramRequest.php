<?php

namespace App\JsonApi\V1\Programs;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

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
        ];
    }
}
