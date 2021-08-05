<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDatabase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'days_to_next',
        'cathegory_id',
    ];
}