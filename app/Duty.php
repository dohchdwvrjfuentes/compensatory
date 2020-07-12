<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
    protected $guarded = [];

    public function employee(){

        return $this->belongsTo(\App\Employee::class);
    }
}
