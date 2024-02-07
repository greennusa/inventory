<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerialCampLama extends Model
{
    protected $guarded = [];
	
	public function camp_lama(){
    	return $this->belongsTo(CampLama::class);
    }
}
