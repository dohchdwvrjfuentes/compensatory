<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $guarded = [];

    public function employees(){

        return $this->hasMany(\App\Employee::class);
    }
}
