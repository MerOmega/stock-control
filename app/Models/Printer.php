<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Printer extends Model
{
    use HasFactory;

    protected $table = 'printers';
    protected $fillable = ['toner', 'toner_code'];

    public function device(): MorphOne
    {
        return $this->morphOne(Device::class, 'deviceable');
    }
}
