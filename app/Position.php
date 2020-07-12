<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = [];

    public function employees(){

        return $this->hasMany(\App\Employee::class);
    }
}
