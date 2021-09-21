<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Cathegory extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['itemsdb', 'subcathegories'];

    protected $fillable = [
        'name',
        'photo_path',
        'fillable',
        'cathegory_id'
    ];

    public function subcathegories()
    {
        return $this->hasMany(Cathegory::class);
    }

    public function parent()
    {
        return $this->belongsTo(Cathegory::class);
    }

    public function itemsdb()
    {
        return $this->hasMany(ItemDatabase::class);
    }

    public function items()
    {
        return $this->itemsdb()->with('items');
    }

    public function servicesdb()
    {
        return $this->hasMany(ServiceDatabase::class);
    }

    public function services()
    {
        return $this->servicesdb()->with('services');
    }

    public function fills()
    {
        return $this->hasMany(Fill::class);
    }
}
