<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceRecord extends Model
{
    protected $table = 'device_records';
    protected $fillable = ['data', 'date'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
