<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDatabase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subcathegory_id',
        'manufacturer_id'
    ];

    public function subcathegory()
    {
        return $this->belongsTo(Subcathegory::class);
    }

    public function cathegory()
    {
        return $this->subcathegory()->with('cathegory');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
