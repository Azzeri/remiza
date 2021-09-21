<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Item extends Model
{
    use HasFactory,SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['services','usages'];

    protected $fillable = [
        'construction_number',
        'inventory_number',
        'identification_number',
        'name',
        'date_expiry',
        'date_legalisation',
        'date_legalisation_due',
        'date_production',
        'item_database_id',
        'fire_brigade_unit_id',
        'manufacturer_id',
        'vehicle_id',
        'activated'
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function usages()
    {
        return $this->hasMany(Usage::class);
    }

    public function cathegory()
    {
        return $this->databaseItems()->with('cathegory');
    }

    public function databaseItems()
    {
        return $this->belongsTo(ItemDatabase::class, 'item_database_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function fireBrigadeUnit()
    {
        return $this->belongsTo(FireBrigadeUnit::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class)->withTrashed();
    }

    public function sets()
    {
        return $this->belongsToMany(Set::class);
    }

}
