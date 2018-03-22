<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'user_id',
        'VL',
        'SL',
        'OT',
        'OB',
        'PTO',
        'unused_VL',
        'unused_SL',
        'total_PTO',
        'total_VL',
        'total_SL'
    ];
}
