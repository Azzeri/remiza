<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'usage_date',
        'usage_minutes',
        'user_id',
        'item_id'
    ];
}