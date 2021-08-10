<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcathegory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function cathegory()
    {
        return $this->belongsTo(Cathegory::class);
    }
}
