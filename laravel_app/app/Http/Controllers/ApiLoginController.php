<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ApiLoginController extends Controller
{
    
    public function cek_login(Request $request){
    	

		$data = User::where('username',$request->username)->first();
		$cekpas = password_verify($request->password,$data->password);
		if($cekpas){
			\App\AktivitasUser::create(['user_id'=>$data->id,'aktivitas'=>'login ke sistem']);
			header("HTTP/1.1 200 OK");
		}
		else {
			header("HTTP/1.0 400 Bad Request");
		}
		return http_response_code();
    }
}
