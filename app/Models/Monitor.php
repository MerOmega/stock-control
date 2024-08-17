<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Monitor extends Model
{
    use HasFactory;

    protected $table    = 'monitors';
    protected $fillable = ['has_vga', 'has_dp', 'has_hdmi'];

    public function device(): MorphOne
    {
        return $this->morphOne(Device::class, 'deviceable');
    }
}
