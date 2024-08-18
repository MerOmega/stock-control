<?php

namespace App\Models;

use App\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 *
 * @property int $id
 * @property string $sku
 * @property string $entry_year
 * @property State $state
 * @property int|null $sector_id
 * @property int|null $brand_id
 * @property string $deviceable_type
 * @property int $deviceable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Brand|null $brand
 * @property-read Model|\Eloquent $deviceable
 * @property-read \App\Models\Sector|null $sector
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supply> $supplies
 * @property-read int|null $supplies_count
 * @method static \Database\Factories\DeviceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereEntryYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereSectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        return $this->belongsToMany(Supply::class, 'device_supply')
            ->withPivot('quantity');
    }
}
