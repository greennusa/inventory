<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerialGudang extends Model
{
    protected $guarded = [];

    public function gudang() {
    	return $this->belongsTo(Gudang::class);
    }
}
