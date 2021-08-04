<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireBrigadeUnit extends Model
{
    use HasFactory;

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
