<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    public function modul(){
        return $this->belongsToMany('App\Modul','akses');
    }

    
}
