<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'expiry_date',
        'item_database_id',
        'fire_brigade_unit_id',
        'activated'
    ];

    public function cathegory()
    {
        return $this->databaseItems()->with('cathegory');
    }

    public function databaseItems()
    {
        return $this->belongsTo(ItemDatabase::class, 'item_database_id');
    }

    public function fireBrigadeUnit()
    {
        return $this->belongsTo(FireBrigadeUnit::class);
    }

    public function manufacturer()
    {
        return $this->databaseItems()->with('manufacturer');
    }

}
