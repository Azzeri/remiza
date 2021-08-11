<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cathegory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cathegory_id'
    ];

    public function subcathegories(){
        return $this->hasMany(Cathegory::class);
    }
}
