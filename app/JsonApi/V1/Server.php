<?php

namespace App\JsonApi\V1;

use App\JsonApi\V1\Programs\ProgramSchema;
use Illuminate\Support\Facades\Auth;
use App\JsonApi\V1\Thermostats\ThermostatSchema;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        Auth::shouldUse('api');
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            ThermostatSchema::class,
            ProgramSchema::class
        ];
    }
}
