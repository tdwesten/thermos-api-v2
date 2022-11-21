<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UpdateService;
use Illuminate\Support\Facades\Validator;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

class ThermostatController extends JsonApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(
            'auth:api'
        )->except(
            [
                'v1.thermostats.thermostats.sync',
            ]
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function sync(Request $request): DataResponse
    {
        $validator = Validator::make($request->all(), [
            'current_temperature' => 'required|numeric',
            'is_heating' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $thermostat = $request->user();
        $current_temperature = $request->input('current_temperature', 0);

        $updateService = new UpdateService();
        $thermostat = $updateService->processUpdate($thermostat, $current_temperature);


        return new DataResponse(
            $thermostat
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function increaseTemperature(Request $request): DataResponse
    {
        $thermostat = $request->user();

        $updateService = new UpdateService();
        $thermostat = $updateService->increaseTargetTemperature($thermostat);

        return new DataResponse(
            $thermostat
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function decreaseTemperature(Request $request): DataResponse
    {
        $thermostat = $request->user();

        $updateService = new UpdateService();
        $thermostat = $updateService->decreaseTargetTemperature($thermostat);

        return new DataResponse(
            $thermostat
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function reset(Request $request): DataResponse
    {
        $thermostat = $request->user();

        $updateService = new UpdateService();
        $thermostat = $updateService->reset($thermostat);

        return new DataResponse(
            $thermostat
        );
    }
}
