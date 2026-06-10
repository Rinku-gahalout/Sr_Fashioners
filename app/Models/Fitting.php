<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fitting extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
        'sort_order',
    ];
}
