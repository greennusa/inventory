<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CampLama extends Model
{
	use SoftDeletes;
    protected $guarded = [];
    public function barang()
	{
		return $this->belongsTo('App\Barang','barang_id','id');
	}

	public function satuan(){
    	return $this->belongsTo('App\Satuan','satuan_id');
    }

    public function serial(){
		return $this->hasMany(SerialCampLama::class);
	}

	public function delete(){
    	$this->serial()->delete();
    	parent::delete();
    }

    public function camp(){
        return $this->belongsTo(Dapur::class,'dapur','id');
    }
}
