<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
   protected $fillable = [
        'route_number',
        'start_point',
        'end_point',
        'distance',
        'duration',
    ];
}
