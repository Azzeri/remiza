<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemDatabase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'cathegory_id',
        'manufacturer_id'
    ];

    public function cathegory()
    {
        return $this->belongsTo(Cathegory::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
