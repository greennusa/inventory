<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Lokasi;
use App\Group;
use App\Jabatan;
use Auth;
use Session;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {   
        if(Auth::user()->cek_akses('User','View',Auth::user()->id) != 1){
            return view('error.denied');
        }
        if(isset($request->q)){
            $q = $request->q;
        }
        else {
            $q = '';
        }
        $tables = User::where('nama','like',"%$q%")->orderBy('created_at','DESC')->paginate(20);
        return view('user.index',compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->cek_akses('User','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $lokasi = Lokasi::all();
        $grup = Group::all();
        $jabatan = Jabatan::all();
        return view('user.create',compact('lokasi','grup','jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->cek_akses('User','Add',Auth::user()->id) != 1){
            return view('error.denied');
        }

        $this->validate($request,[
            'username'=>'required|unique:users|min:4',
            'password'=>'required|min:6',
            'nama'=>'required',
            'lokasi_id'=>'required',
            'jabatan_id'=>'required',
            'group_id'=>'required',
            'lokasi_id'=>'required',
            
        ]);
        $input = $request->all();
        unset($input['_token']);
        $input['password'] = bcrypt($input['password']);
        $gambar  = '';
        if ($request->hasFile('userfile')) {
            $this->validate($request,[
                'userfile'=>'mimes:png',
               
            ]);
            $gambar = 'gambar-ttd-'.str_replace(" ", "-",$request->nama).'.png';
            $request->file('userfile')->storeAs('images/ttd',$gambar,'public_img');
        }
        unset($input['userfile']);
        $input['ttd']=$gambar;
        $data = User::create($input);
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menambah data user dengan nama '.$data->nama]);
        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if(Auth::user()->cek_akses('User','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $r = User::findOrFail($id);
        $lokasi = Lokasi::all();
        $grup = Group::all();
        $jabatan = Jabatan::all();
        return view('user.edit',compact('lokasi','grup','jabatan','r'));
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
        if(Auth::user()->cek_akses('User','Edit',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $this->validate($request,[
            'username'=>'required|min:4',
            'nama'=>'required',
            'lokasi_id'=>'required',
            'jabatan_id'=>'required',
            'group_id'=>'required',
            'lokasi_id'=>'required',
            
        ]);
        $data = User::findOrFail($id);
        if($request->username != $data->username){
            $this->validate($request,[
                'username'=>'required|unique:users|min:4',
                
            ]);
        }
        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);
        unset($input['userfile']);
        unset($input['page']);
        
        $gambar  = $data->ttd;
        if ($request->hasFile('userfile')) {
            $gambar = 'gambar-ttd-'.str_replace(" ", "-",$data->nama).'.png';
            $request->file('userfile')->storeAs('images/ttd',$gambar,'public_img');
        }
        \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Edit data user dengan nama '.$data->nama]);
        $input['ttd']=$gambar;
        $data->update($input);
        return redirect('user?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->cek_akses('User','Delete',Auth::user()->id) != 1){
            return view('error.denied');
        }
        $data = User::findOrFail($id);
        $nama = $data->nama;
        try {
            
            try {
            
                $data->delete();
               
            } catch (\Illuminate\Database\QueryException $e) {
                if($e->errorInfo[1] == 1451){
                    Session::flash(
                        "flash_notif",[
                            "level"   => "dismissible alert-danger",
                            "massage" => "Data Tidak Bisa Dihapus. Data Masih Digunakan"
                    ]);   
                    return redirect()->back();
                }
                
                
            }
            \App\AktivitasUser::create(['user_id'=>Auth::user()->id,'aktivitas'=>'Menghapus data user dengan nama '.$data->nama]);
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-success",
                    "massage" => "Data <strong>$nama</strong> Berhasil Di Hapus"
            ]);

            
        } catch (Exception $e) {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Data <strong>$data->nama</strong> Gagal Di Hapus"
            ]);
        }
        
        
        
        return back();
    }

    public function ubah_password($id,Request $request){
        $data = User::findOrFail($id);
        $cekpas = password_verify($request->password_lama,$data->password);
        if($cekpas){
            $data->update(['password'=>bcrypt($request->password_baru)]);
            Auth::logout();
            return back();
        } else {
            Session::flash(
                "flash_notif",[
                    "level"   => "dismissible alert-danger",
                    "massage" => "Silahkan masukan password lama anda dengan benar"
            ]);
            return back();
        }


    }
}
