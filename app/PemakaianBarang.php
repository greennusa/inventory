<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemakaianBarang extends Model
{
    protected $guarded = [];

    public function operator(){
		return $this->belongsTo(User::class,'user_id');
	}

	public function unit(){
    	return $this->belongsTo('App\Unit','unit_id');
    }
 	public function detail(){
		return $this->hasMany(DetailPemakaianBarang::class);
	}

    public function detail_lama(){
        return $this->hasMany(DetailPemakaianBarangLama::class);
    }

    public function getDetailSemuaAttribute(){
        $data1 = $this->detail;
        $data2 = $this->detail_lama;
        $tables = $data1->merge($data2);
        return $tables;
    }

    public function getStatusAttribute()
    {
        return $this->detail()->where('status',1)->count();
    }

    public function diketahui(){
        return $this->belongsTo(User::class,'diketahui_id');
    }
    // public function diterima(){
    //         return $this->belongsTo(User::class,'diterima_id');
    // }
    public function dibuat(){
            return $this->belongsTo(User::class,'dibuat_id');
    }

	public function delete(){
    	$this->detail()->delete();
        $this->detail_lama()->delete();
    	parent::delete();
    }

    public function gabungan(){
        $data1 = $this->detail;
        $data2 = $this->detail_lama;
        $tables = $data1->merge($data2);
        return $tables;
    }
}
