<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public const IS_GLOBAL_ADMIN = 1;
    public const IS_LOWLY_UNIT_ADMIN = 2;
    public const IS_COORDINATOR = 3;
    public const IS_SUPERIOR_UNIT_ADMIN = 4;

}
