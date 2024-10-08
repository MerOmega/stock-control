<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $low_stock_alert
 * @property int $default_per_page
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereDefaultPerPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereLowStockAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Configuration extends Model
{
    use HasFactory;

    protected $table    = 'configurations';
    protected $fillable = ['low_stock_alert', 'default_per_page'];

    public static function getSingleton()
    {
        // Use first() to ensure there's only one record and create if not exists
        return self::firstOrCreate([], [
            'low_stock_alert' => 10,
            'default_per_page' => 10,
        ]);
    }
}
