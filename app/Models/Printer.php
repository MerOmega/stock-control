<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property int $id
 * @property int|null $supply_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Device|null $device
 * @method static \Database\Factories\PrinterFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Printer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Printer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Printer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Printer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Printer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Printer whereSupplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Printer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Printer extends Model
{
    use HasFactory;

    protected $table = 'printers';
    protected $fillable = ['toner', 'toner_code'];

    public function device(): MorphOne
    {
        return $this->morphOne(Device::class, 'deviceable');
    }

    public function getLabel(): string
    {
        return trans('messages.device.type.Printer');
    }
}
