<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('backup', 'BackupController@index');
Route::get('backup/create', 'BackupController@create');
Route::get('backup/download/{file_name}', 'BackupController@download');
Route::get('backup/delete/{file_name}', 'BackupController@delete');


Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    dd($exitCode);
});

Route::get('randomcode',function(){
	$kode = '';
	$char = array_merge(range('0', '9'));
	$max = count($char)-1;
	for ($i=0; $i < 15; $i++) { 
		$r = mt_rand(0,$max);
		$kode .= $char[$r];
	}
	return $kode;
});
Route::get('stock/chart','LaporanController@chart');
Route::get('stock/get_total_per_bulan','LaporanController@get_total_per_bulan');
Route::get('stock/get_penerimaan_per_bulan','LaporanController@get_penerimaan_per_bulan');

Route::get('/test_mail','PermintaanBarangController@kirim_email');


Route::get('/', function () {
	if(Auth::user() != null){
		
		return redirect('home');
	}
    return view('auth.login');
});

Auth::routes();

//udit scanner
Route::get('qrcode/cek/{kode}','ApiUditScannerController@cek_sesi');
Route::get('qrcode/scan/{kode}','ApiUditScannerController@tambah_sesi');

Route::get('qrcode/cek_detail/{kode}','ApiUditScannerController@cek_detail');
Route::get('qrcode/scan/{kode}/{detail}','ApiUditScannerController@tambah_detail');

//api
Route::get('merek/get_data/','ApiMerekController@get_data');
Route::get('barang/get_data/','ApiBarangController@get_data');
Route::get('barang/get_data/{id}','ApiBarangController@get_data_by_id');
Route::get('permintaan_barang/get_data/','ApiPermintaanBarangController@get_data');
Route::get('pemesanan_barang/get_data/','ApiPemesananBarangController@get_data');
Route::get('bbm/get_data/','ApiBuktiBarangMasukController@get_data');
Route::get('gudang/get_data/','ApiGudangMasukController@get_data');
Route::get('bbk/get_data/','ApiBuktiBarangKeluarController@get_data');
Route::get('camp/get_data/','ApiCampController@get_data');
Route::get('cek_login/{username}/{password}','ApiLoginController@cek_login');


Route::group(['middleware' => ['auth']] , function(){
	Route::get('ajax/get_supplier/{id}', 'DetailPermintaanBarangController@get_supplier');
	Route::get('ajax/get_detail_pemesanan/{id}', 'PemesananBarangController@get_detail_pemesanan');
	Route::get('ajax/get_detail_bbm/{id}', 'BuktiBarangMasukController@get_detail_bbm');
	Route::get('ajax/get_detail_bbk/{id}', 'BuktiBarangKeluarController@get_detail_bbk');
	Route::get('ajax/cek_pemesanan/{id}', 'PemesananBarangController@cek_pemesanan');
	//Route::get('ajax/get_barang_camp/{id}','CampController@get_barang_camp');
	Route::post('ajax/get_barang_camp','CampController@get_barang_camp');
	Route::get('ajax/get_list_barang_permintaan_barang/{id}/{permintaan_id}','PermintaanBarangController@get_list_barang_permintaan_barang');
	Route::get('ajax/get_permintaan/{id}','PermintaanBarangController@get_permintaan');
	Route::get('ajax/get_pemesanan_lama/{supplier_id}','PemesananBarangController@get_pemesanan_lama');
	Route::get('ajax/get_pemesanan/{id}','PemesananBarangController@get_pemesanan');
	Route::get('ajax/get_kode_unit/{id}','UnitController@get_kode_unit');

	Route::Resource('/job', 'JabatanController');
	Route::Resource('/group', 'GroupController');
	Route::Resource('/lokasi', 'LokasiController');

	Route::get('/home', 'HomeController@index')->name('home');
	Route::post('/user/{id}/ubah_password', 'UserController@ubah_password');
	Route::Resource('/user', 'UserController');
	Route::get('/unit/excel', 'UnitController@excel');
	Route::Resource('/unit', 'UnitController');
	Route::get('/category/excel', 'KategoriController@excel');
	Route::Resource('/category', 'KategoriController');
	Route::Resource('/brand', 'MerekController');
	Route::Resource('/type_unit', 'JenisUnitController');
	Route::Resource('/satuan', 'SatuanController');
	Route::Resource('/item', 'BarangController');
	Route::Resource('/purchase_request', 'PermintaanBarangController');
	Route::get('/purchase_request/{id}/xls/', 'PermintaanBarangController@print_xls');
	Route::get('/purchase_request/{id}/doc/', 'PermintaanBarangController@print_doc');
	Route::get('/purchase_request/{id}/print/', 'PermintaanBarangController@print_out');

	Route::Resource('/detail_purchase_request', 'DetailPermintaanBarangController');

	Route::Resource('/supplier', 'PemasokController');
	Route::Resource('/set_supplier', 'AturPemasokController');
	Route::post('/set_supplier/gabung', 'AturPemasokController@gabung');

	Route::get('/set_supplier/{id}/xls/', 'AturPemasokController@print_xls');
	Route::get('/set_supplier/{id}/doc/', 'AturPemasokController@print_doc');
	Route::Resource('/approval', 'PersetujuanController');
	Route::post('/approval/{id}/detail', 'PersetujuanController@update_detail');


	Route::put('order/detail_baru', 'PemesananBarangController@detail_baru2');
	Route::put('order/{id}/detail_baru', 'PemesananBarangController@detail_baru');
	Route::get('/order/{id}/xls/', 'PemesananBarangController@print_xls');
	Route::Resource('/order', 'PemesananBarangController');
	Route::Resource('/detail_order', 'DetailPemesananBarangController');
	Route::get('/order/doc/{id}/', 'PemesananBarangController@print_doc');
	Route::get('/order/xls/{id}/', 'PemesananBarangController@print_xls');
	
	Route::get('/order/pdf/{id}/', 'PemesananBarangController@print_pdf');
	Route::get('/order/print/{id}/', 'PemesananBarangController@print_out');

	Route::get('/item_in/barcode/{id}', 'BuktiBarangMasukController@barcode');
	Route::get('/item_in/{id}/buat_bbm', 'BuktiBarangMasukController@bbm_baru');
	Route::post('/item_in/{id}/buat_bbm', 'BuktiBarangMasukController@buat_bbm');
	Route::get('/item_in/qrcode/{id}', 'BuktiBarangMasukController@qrcode');
	Route::post('/item_in/get_bbm', 'BuktiBarangMasukController@get_bbm');
	Route::post('/item_in/check_serial', 'BuktiBarangMasukController@check_serial');
	Route::Resource('/item_in', 'BuktiBarangMasukController');
	
	Route::Resource('/detail_item_in', 'DetailBuktiBarangMasukController');
	Route::Resource('/warehouse', 'GudangController');
	Route::get('/warehouse_all', 'GudangController@print_all');


	Route::Resource('/warehouse_use', 'PemakaianGudangController');
	Route::Resource('/camp_list','DapurController');


	Route::get('/item_out/{id}/print/', 'BuktiBarangKeluarController@print_out');
	Route::get('/item_out/{id}/xls/', 'BuktiBarangKeluarController@print_xls');
	Route::get('/item_out/{id}/doc/', 'BuktiBarangKeluarController@print_doc');
	Route::get('/item_out/scan/', 'BuktiBarangKeluarController@scan');
	Route::post('/item_out/scan/', 'BuktiBarangKeluarController@store_scan');
	Route::post('/item_out/scan_barang/', 'BuktiBarangKeluarController@scan_barang');
	Route::Resource('/item_out', 'BuktiBarangKeluarController');
	Route::post('/item_out/new_item/{id}', 'BuktiBarangKeluarController@new_item');
	Route::post('/item_out/send/{id}', 'BuktiBarangKeluarController@send');
	Route::post('/item_out/cancel/{id}', 'BuktiBarangKeluarController@cancel');

	Route::post('/warehouse_udit/check_serial', 'CampController@check_serial');
	Route::Resource('/warehouse', 'GudangController');
	// Route::get('/warehouse_udit/stok_lama', 'CampController@stok_lama');
	// Route::post('/warehouse_udit/stok_lama', 'CampController@tambah_stok_lama');
	Route::Resource('/warehouse_udit', 'CampController');
	Route::Resource('/warehouse_udit_lama', 'CampLamaController');


	Route::get('/item_use/scan', 'PemakaianBarangController@scan');
	Route::post('/item_use/scan', 'PemakaianBarangController@insert_scan');
	Route::Resource('/item_use', 'PemakaianBarangController');
	Route::Resource('/detail_item_use','DetailPemakaianBarangController');
	Route::get('/item_use/print/{id}', 'PemakaianBarangController@print_out');
	Route::get('/item_use/{id}/xls/', 'PemakaianBarangController@print_xls');
	Route::get('/item_use/{id}/doc/', 'PemakaianBarangController@print_doc');

	Route::Resource('/retur_item', 'ReturBarangController');
	Route::get('/retur_item/print/{id}', 'ReturBarangController@print_out');
	Route::get('/retur_item/{id}/xls/', 'ReturBarangController@print_xls');
	Route::get('/retur_item/{id}/doc/', 'ReturBarangController@print_doc');
	Route::Resource('/detail_retur_item', 'DetailReturBarangController');

	Route::Resource('/retur_camp', 'ReturBarangCampController');
	Route::get('/retur_camp/print/{id}', 'ReturBarangCampController@print_out');
	Route::get('/retur_camp/{id}/xls/', 'ReturBarangCampController@print_xls');
	Route::get('/retur_camp/{id}/doc/', 'ReturBarangCampController@print_doc');
	Route::Resource('/detail_retur_camp', 'DetailReturBarangCampController');
	Route::Resource('/detail_retur_camp_lama', 'DetailReturBarangCampLamaController');

	Route::Resource('/log_user', 'AktivitasUserController');


	Route::Resource('/report', 'LaporanController');
	Route::get('/report/pemakaian/{nama}', 'LaporanController@pemakaian');
	Route::get('/report/penerimaan/{nama}', 'LaporanController@penerimaan');
	Route::get('/report/opname/{nama}', 'LaporanController@opname');
	Route::get('/report/pemakaian_per_unit/{nama}','LaporanController@pemakaian_per_unit');
	Route::get('/report/oil/{nama}','LaporanController@oil');
	Route::get('/report/supplier/{nama}', 'LaporanController@supplier');
	Route::get('/report/monitoring/{nama}', 'LaporanController@monitoring');
	Route::get('/report/pemakaian_gudang/{nama}', 'LaporanController@pemakaian_gudang');
	Route::get('/report/piutang/{nama}', 'LaporanController@piutang');
	Route::get('/report/dapur/{nama}', 'LaporanController@dapur');


	Route::get('/report/pemakaian_doc/{nama}', 'LaporanController@pemakaian_doc');
	Route::get('/report/penerimaan_doc/{nama}', 'LaporanController@penerimaan_doc');
	Route::get('/report/opname_doc/{nama}', 'LaporanController@opname_doc');
	Route::get('/report/pemakaian_per_unit_doc/{nama}','LaporanController@pemakaian_per_unit_doc');
	Route::get('/report/oil_doc/{nama}','LaporanController@oil_doc');

	Route::get('/report/bbm/{nama}','LaporanController@bbm');

	Route::Resource('/monitoring', 'MonitoringUnitController');

	Route::Resource('/arsip', 'ArsipController');
	Route::post('/item_baru', 'PermintaanBarangController@barang_baru');



	
});

Route::get('files/arsip/{filename}', function ($filename)
	{
		$path = storage_path('app\public\\arsip\\' . $filename);

		if (!File::exists($path)) {
			abort(404);
		}

		$file = File::get($path);
		$type = File::mimeType($path);

		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);

		return $response;
	});




