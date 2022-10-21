<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function jabatan(){
        return $this->belongsTo('App\Jabatan');
    }
    public function group(){
        return $this->belongsTo('App\Group');
    }
    public function lokasi(){
        return $this->belongsTo('App\Lokasi');
    }



    public function cek_akses($nama,$aksi,$id){
        return $this->where('id',$id)->whereHas('group.modul',function ($q) use($nama,$aksi){
            $q->where('nama',$nama)->where('aksi',$aksi);
        })->count();
    }

    
}
