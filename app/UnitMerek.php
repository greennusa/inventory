<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitMerek extends Model
{
    protected $guarded = [];

	public function merek(){
    	return $this->belongsTo(Merek::class,'merek_id');
    }



    public function unit(){
    	return $this->belongsTo(Unit::class,'unit_id');
    }
}
