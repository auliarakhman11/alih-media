<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::middleware('auth')->group(function(){
//     Route::get('/',[SosmedController::class,'admin'])->name('admin');
// Route::post('export-youtube',[SosmedController::class,'exportYoutube'])->name('exportYoutube');
// Route::post('export-instagram',[SosmedController::class,'exportInstagram'])->name('exportInstagram');

// Route::get('/logout',[AuthController::class,'logout'])->name('logout');
// });

Route::middleware('auth')->group(function(){

    Route::get('/',[HomeController::class,'index'])->name('home');

    
    Route::middleware('hakakses:1')->group(function(){
        Route::get('user',[UserController::class,'index'])->name('user');
        Route::get('get-data-user',[UserController::class,'getDataUser'])->name('getDataUser');
        Route::post('edit-user',[UserController::class,'editUser'])->name('editUser');
        Route::post('add-user',[UserController::class,'addUser'])->name('addUser');
    });


    //berkas
    Route::get('berkas',[BerkasController::class,'index'])->name('berkas');
    Route::get('getKelurahan/{kecamatan_id}',[BerkasController::class,'getKelurahan'])->name('getKelurahan');
    Route::post('addBerkas',[BerkasController::class,'addBerkas'])->name('addBerkas');
    Route::get('list-berkas',[BerkasController::class,'listBerkas'])->name('listBerkas');
    Route::get('getListBerkas',[BerkasController::class,'getListBerkas'])->name('getListBerkas');
    Route::get('getKirim/{proses_id}/{history_id}',[BerkasController::class,'getKirim'])->name('getKirim');
    Route::get('krimBerkas/{jenis}/{history_id}/{berkas_id}/{proses_id}',[BerkasController::class,'krimBerkas'])->name('krimBerkas');
    Route::get('getKeterangan/{berkas_id}/{history_id}',[BerkasController::class,'getKeterangan'])->name('getKeterangan');
    Route::post('keteranganBerkas',[BerkasController::class,'keteranganBerkas'])->name('keteranganBerkas');
    
    Route::get('exportExcel',[BerkasController::class,'exportExcel'])->name('exportExcel');
    
    Route::post('pengesahanBt',[BerkasController::class,'pengesahanBt'])->name('pengesahanBt');
    
    // Route::get('import',[BerkasController::class,'import'])->name('import');
    // Route::post('importDataSU',[BerkasController::class,'importDataSU'])->name('importDataSU');
    //endberkas

    //kembali
    Route::get('getKembali/{berkas_id}',[BerkasController::class,'getKembali'])->name('getKembali');
    Route::post('kembaliBerkas',[BerkasController::class,'kembaliBerkas'])->name('kembaliBerkas');
    //end kembali



    //buka validasi
    Route::get('buka-validasi',[BerkasController::class,'bukaValidasi'])->name('bukaValidasi');
    Route::get('getListBukaValidasi',[BerkasController::class,'getListBukaValidasi'])->name('getListBukaValidasi');
    Route::get('bukaValidasiBerkas/{berkas_id}/{seksi_id}',[BerkasController::class,'bukaValidasiBerkas'])->name('bukaValidasiBerkas');
    //end buka validasi

    //kunci
    Route::get('kunciBerkas/{history_id}',[BerkasController::class,'kunciBerkas'])->name('kunciBerkas');
    Route::get('bukaBerkas/{history_id}',[BerkasController::class,'bukaBerkas'])->name('bukaBerkas');
    //end kunci

    //laporan
    Route::get('info-berkas',[LaporanController::class,'infoBerkas'])->name('infoBerkas');
    Route::post('dtInfoBerkas',[LaporanController::class,'dtInfoBerkas'])->name('dtInfoBerkas');
    
    Route::get('berkas-tunggakan',[LaporanController::class,'berkasTunggakan'])->name('berkasTunggakan');
    Route::get('getListTunggakan',[LaporanController::class,'getListTunggakan'])->name('getListTunggakan');
    Route::get('dtInfoTunggakan/{id}',[LaporanController::class,'dtInfoTunggakan'])->name('dtInfoTunggakan');
    
    Route::get('berkas-selesai',[LaporanController::class,'berkasSelesai'])->name('berkasSelesai');
    Route::get('getListSelesai',[LaporanController::class,'getListSelesai'])->name('getListSelesai');
    
    Route::get('laporan-perhari',[LaporanController::class,'laporanPerhari'])->name('laporanPerhari');
    Route::get('getPekerjaanPerhari/{user_id}/{tgl}',[LaporanController::class,'getPekerjaanPerhari'])->name('getPekerjaanPerhari');
    Route::get('laporan-perproses',[LaporanController::class,'laporanPerproses'])->name('laporanPerproses');
    Route::get('getLaporanPerproses/{proses_id}',[LaporanController::class,'getLaporanPerproses'])->name('getLaporanPerproses');
    //endLaporan
    
    //tutup berkas
    Route::get('tutupBerkas/{berkas_id}',[LaporanController::class,'tutupBerkas'])->name('tutupBerkas');
    Route::get('dtInfoBerkasGet/{berkas_id}',[LaporanController::class,'dtInfoBerkasGet'])->name('dtInfoBerkasGet');
    //end tutup berkas
    

    //block
    Route::get('forbidden-access',[AuthController::class,'block'])->name('block');
    //endblock
    Route::get('ganti-password',[UserController::class,'gantiPassword'])->name('gantiPassword');
    Route::post('edit-password',[UserController::class,'editPassword'])->name('editPassword');

    

    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
    Route::get('non-active',[AuthController::class,'nonActive'])->name('nonActive');
});




Route::middleware('guest')->group(function(){
    Route::get('login',[AuthController::class,'login_page'])->name('loginPage');
    Route::post('login',[AuthController::class,'login'])->name('login');
});




