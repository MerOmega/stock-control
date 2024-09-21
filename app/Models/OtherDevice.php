<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class OtherDevice extends Model
{
    use HasFactory;

    protected $table    = 'other_devices';

    public function device(): MorphOne
    {
        return $this->morphOne(Device::class, 'deviceable');
    }

    public function getLabel(): string
    {
        return trans('messages.device.type.Other');
    }
}
