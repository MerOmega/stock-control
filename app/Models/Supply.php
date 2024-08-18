<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 
 *
 * @property int $id
 * @property int|null $category_id
 * @property int $quantity
 * @property string $description
 * @property string $observations
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Device> $devices
 * @property-read int|null $devices_count
 * @method static \Database\Factories\SupplyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Supply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supply query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supply whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supply whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supply whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supply whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supply whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Supply extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity', 'category_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(Device::class, 'device_supply')
            ->withPivot('quantity');
    }
}
