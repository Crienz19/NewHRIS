<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'user_id',
        'date_from',
        'date_to',
        'time_in',
        'time_out',
        'destination_from',
        'destination_to',
        'purpose',
        'status',
        'remarks'
    ];
}
