<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterConsumption extends Model
{
    use HasFactory;

    protected $table = 'water_consumption';

    protected $fillable = ['units_consumed', 'status'];
}
