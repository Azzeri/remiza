<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FireBrigadeUnit extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        // 'marshal'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // public function marshal(){
    //     return $this->belongsTo(User::class);
    // }
}
