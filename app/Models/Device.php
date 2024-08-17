<?php

namespace App\Models;

use App\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['sku', 'entry_year', 'state', 'brand_id', 'sector_id'];

    protected $casts = [
        'state' => State::class,
    ];

    public function deviceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }


    public function supplies(): BelongsToMany
    {
        return $this->belongsToMany(Supply::class, 'device_supply');
    }
}
