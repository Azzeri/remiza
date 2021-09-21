<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fill extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_start',
        'date_finish',
        'time_start',
        'time_finish',
        'item_id',
        'user_id'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
