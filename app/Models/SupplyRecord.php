<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyRecord extends Model
{
    protected $table = 'supply_records';
    protected $fillable = ['data', 'date'];

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
}
