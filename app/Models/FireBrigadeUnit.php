<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class FireBrigadeUnit extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['users', 'items'];

    protected $fillable = [
        'name',
        'address',
        'superior_unit_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function superiorUnit()
    {
        return $this->belongsTo(FireBrigadeUnit::class);
    }
}
