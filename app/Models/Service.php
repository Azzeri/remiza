<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'perform_date',
        'days_to_next',
        'is_performed',
        'cathegory_id',
        'user_id'
    ];
}