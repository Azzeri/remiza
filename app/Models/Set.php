<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'fire_brigade_unit_id',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function itemsdb()
    {
        return $this->items()->with('databaseItems');
    }
}
