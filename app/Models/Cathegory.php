<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cathegory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'cathegory_id'
    ];

    public function subcathegories(){
        return $this->hasMany(Cathegory::class);
    }
}
