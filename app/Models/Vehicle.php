<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'fire_brigade_unit_id'
    ];

    public function unit() 
    {
        return $this->belongsTo(FireBrigadeUnit::class, 'fire_brigade_unit_id');
    }
}
