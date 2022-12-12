<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stayallive\Laravel\Eloquent\UUID\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;
    use UsesUUID;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'target_temperature',
        'days',
        'is_active',
        'thermostat_id',
    ];

    protected $casts = [
        'days' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function thermostat(): BelongsTo
    {
        return $this->belongsTo(Thermostat::class, 'thermostat_id');
    }
}
