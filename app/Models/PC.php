<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Device|null $device
 * @method static \Database\Factories\PCFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PC newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PC newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PC query()
 * @method static \Illuminate\Database\Eloquent\Builder|PC whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PC whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PC whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PC extends Model
{
    use HasFactory;

    protected $table = 'pcs';

    public function device(): MorphOne
    {
        return $this->morphOne(Device::class, 'deviceable');
    }

    public function getLabel(): string
    {
        return trans('messages.device.type.PC');
    }
}
