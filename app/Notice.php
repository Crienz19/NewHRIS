<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'user_id',
        'nature',
        'date',
        'time_in',
        'time_out',
        'explanation',
        'remarks',
        'status'
    ];
}
