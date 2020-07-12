<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function duties(){

        return $this->hasMany(\App\Duty::class);
    }

    public function leaves(){
        
        return $this->hasMany(\App\Leave::class);
    }

    public function records(){
        
        return $this->hasMany(\App\Record::class);
    }

    public function position(){

        return $this->belongsTo(\App\Position::class);
    }

    public function office(){

        return $this->belongsTo(\App\Office::class);
    }

}
