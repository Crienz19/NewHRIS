<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'value', 'supervisor'];

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }
}
