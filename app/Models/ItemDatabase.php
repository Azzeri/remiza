<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDatabase extends Model
{
    use HasFactory;

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
}
