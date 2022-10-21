<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AktivitasUser extends Model
{
    protected $guarded = [];
    public $timestamps = true;
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
