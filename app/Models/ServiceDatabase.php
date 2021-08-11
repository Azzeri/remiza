<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDatabase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'days_to_next',
        'cathegory_id',
    ];
}