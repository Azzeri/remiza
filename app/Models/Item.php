<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'expiry_date',
        'item_database_id',
        'fire_brigade_unit_id'
    ];

    public function databaseItems()
    {
        return $this->belongsTo(ItemDatabase::class, 'item_database_id');
    }

    public function fireBrigadeUnit()
    {
        return $this->belongsTo(FireBrigadeUnit::class);
    }

    public function subcathegory()
    {
        return $this->databaseItems()->with('subcathegory');
    }

    public function cathegory()
    {
        return $this->subcathegory()->with('cathegory');
    }

    public function manufacturer()
    {
        return $this->databaseItems()->with('manufacturer');
    }

}
