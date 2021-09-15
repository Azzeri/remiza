<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class ItemDatabase extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['items'];

    protected $fillable = [
        'construction_number',
        'inventory_number',
        'identification_number',
        'date_expiry',
        'date_legalisation',
        'date_legalisation_due',
        'date_production',
        'name',
        'manufacturer',
        'vehicle'
    ];

    public function cathegory()
    {
        return $this->belongsTo(Cathegory::class);
    }

    // public function manufacturer()
    // {
    //     return $this->belongsTo(Manufacturer::class);
    // }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
