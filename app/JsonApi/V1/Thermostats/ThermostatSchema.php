<?php

namespace App\JsonApi\V1\Thermostats;

use App\Models\Program;
use App\Models\Thermostat;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;

class ThermostatSchema extends Schema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Thermostat::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make()->uuid(),
            DateTime::make('created-at')->sortable()->readOnly(),
            DateTime::make('updated-at')->sortable()->readOnly(),
            DateTime::make('last-manual-change')->sortable()->readOnly(),
            Str::make('name'),
            Str::make('email'),
            Str::make('token'),
            Number::make('current-temperature'),
            Number::make('target-temperature'),
            Number::make('min-temperature'),
            Boolean::make('is-heating'),
            Str::make('mode')->readOnly(),
            BelongsTo::make('current-program')->type('programs'),
            HasMany::make('programs'),
        ];
    }


    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make();
    }
}
