<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    public function grup(){
        return $this->belongsToMany('App\Group','akses');
    }
}
