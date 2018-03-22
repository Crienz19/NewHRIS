<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'reason',
        'recommending_approval',
        'final_approval',
        'pay_type',
        'to',
        'from',
        'time_from',
        'time_to',
        'count',
        'remarks'
    ];
}
