<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AktivitasUser;
use Auth;
class AktivitasUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }

        $tables = AktivitasUser::where('aktivitas','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        $tables->appends($request->all());
        return view('aktivitas_user.index',compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {   
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = AktivitasUser::where('aktivitas','like',"%$q%")->where('user_id',$id)->orderBy('created_at','DESC')->paginate(10);
        $tables->appends($request->all());
        return view('aktivitas_user.index',compact('tables'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
