<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturBarangCamp extends Model
{
    protected $guarded = [];

    public function detail(){
    	return $this->hasMany(DetailReturBarangCamp::class);
    }

    public function detail_lama(){
        return $this->hasMany(DetailReturBarangCampLama::class);
    }

    public function getDetailSemuaAttribute(){
        $data1 = $this->detail;
        $data2 = $this->detail_lama;
        $tables = $data1->toBase()->merge($data2);
        return $tables;
    }

    public function delete(){
    	$this->detail()->delete();
    	parent::delete();
    }

    public function dikirim(){
		return $this->belongsTo(User::class,'dikirim_id');
	}
	public function diterima(){
			return $this->belongsTo(User::class,'diterima_id');
	}
	public function dibawa(){
			return $this->belongsTo(User::class,'dibawa_id');
	}
}
