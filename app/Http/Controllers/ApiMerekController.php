<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merek;
class ApiMerekController extends Controller
{
    public function get_data(){
    	return Merek::all();
    }
 	
}
