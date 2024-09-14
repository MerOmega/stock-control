<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property int $id
 * @property int $has_vga
 * @property int $has_dp
 * @property int $has_hdmi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Device|null $device
 * @method static \Database\Factories\MonitorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereHasDp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereHasHdmi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereHasVga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Monitor extends Model
{
    use HasFactory;

    protected $table    = 'monitors';
    protected $fillable = ['has_vga', 'has_dp', 'has_hdmi'];

    public function device(): MorphOne
    {
        return $this->morphOne(Device::class, 'deviceable');
    }

    public function getLabel(): string
    {
        return trans('messages.device.type.Monitor');
    }
}
