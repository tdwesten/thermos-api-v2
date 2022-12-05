<?php

namespace App\Http\Controllers;

use App\Models\Thermostat;
use Illuminate\Http\Request;
use App\Services\UpdateService;
use LaravelJsonApi\Core\Document\Error;
use Illuminate\Support\Facades\Validator;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
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
            'auth:api',
            ['except' => ['sync']]
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function sync(Request $request): DataResponse | ErrorResponse
    {

        $token = $request->header('token');

        $validator = Validator::make(['token' => $token ], [
            'token' => 'exists:App\Models\Thermostat,token',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();

            return ErrorResponse::error([
                'title' => 'Invalid token',
                'detail' => $error,
                'status' => '400',
            ]);
        }

        $thermostat = Thermostat::where('token', $token)->get()->first();

        $validator = Validator::make($request->all(), [
            'current_temperature' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return ErrorResponse::error([
                'title' => 'Invalid param',
                'detail' => $validator->errors()->first(),
                'status' => '400',
            ]);
        }

        $current_temperature = $request->input('current_temperature', 0) * 100;

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
