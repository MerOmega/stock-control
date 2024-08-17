<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PC extends Model
{
    use HasFactory;

    protected $table = 'pcs';

    public function device(): MorphOne
    {
        return $this->morphOne(Device::class, 'deviceable');
    }
}
