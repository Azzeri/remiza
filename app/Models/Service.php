<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'perform_date',
        'is_performed',
        'user_id',
        'item_id',
        'service_database_id'
    ];

    public function serviceDatabase()
    {
        return $this->belongsTo(ServiceDatabase::class, 'service_database_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}           