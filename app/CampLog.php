<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CampLog extends Model
{
	use SoftDeletes;
    protected $guarded = [];
    public function barang()
	{
		return $this->belongsTo('App\Barang','barang_id','id');
	}

}
