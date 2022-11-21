<?php

use App\Http\Controllers\ThermostatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyEmailController;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('register', 'AuthController@register');
    }
);

// Verify email
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// JsonApi
JsonApiRoute::server('v1')->prefix('v1')->resources(
    function ($server) {
        $server->resource('thermostats', ThermostatController::class)
            ->only('index', 'show', 'update')
            ->relationships(function ($relations) {
                $relations->hasOne('current-program');
                $relations->hasMany('programs');
            })
            ->actions('-actions', function ($actions) {
                $actions->withId()->post('sync');
                $actions->withId()->post('increase-temperature');
                $actions->withId()->post('decrease-temperature');
                $actions->withId()->post('reset');
            });

        $server->resource('programs', JsonApiController::class)
            ->only('index', 'show', 'update', 'create', 'delete')
            ->relationships(function ($relations) {
                $relations->hasOne('thermostat');
            });
    }
);
