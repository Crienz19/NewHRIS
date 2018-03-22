<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'employee_no',
        'first_name',
        'middle_name',
        'last_name',
        'full_name',
        'birthdate',
        'date_hired',
        'position_id',
        'department_id',
        'branch_id',
        'civil_status',
        'contact_1',
        'contact_2',
        'present_address',
        'permanent_address',
        'skype',
        'tin',
        'sss',
        'hdmf',
        'phic',
        'profile_picture'
    ];
}
