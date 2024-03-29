<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JenisGuruController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TmpGuruController;
use App\Http\Controllers\SiswaPresensiController;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::group(['middleware' => ['auth', 'api']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/index.html', [App\Http\Controllers\HomeController::class, 'index'])->name('index.html');
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('profile', [UserController::class, 'profile']);
    });
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('guru', GuruController::class);
        Route::resource('siswa', SiswaController::class);
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('mapel', MapelController::class);
        Route::resource('jadwal', JadwalController::class);
        Route::resource('rekap_presensi', SiswaPresensiController::class);
        Route::resource('user', UserController::class);

        Route::post('presensi_update/{id}', [SiswaPresensiController::class, 'presensi_update'])->name('presensi_update');
        Route::get('scan', [SiswaPresensiController::class, 'scan'])->name('scan');
        Route::get('scandetail/{id}', [SiswaPresensiController::class, 'scandetail'])->name('scandetail');


        Route::post('mapeldata', [SiswaPresensiController::class, 'mapeldata'])->name('mapedata');
        Route::get('cetakpresensi', [SiswaPresensiController::class, 'cetakpresensi'])->name('cetakpresensi');
        Route::get('laporan_presensi', [SiswaPresensiController::class, 'laporanPresensi'])->name('laporan_presensi');
        Route::get('presensi_edit/{id}', [SiswaPresensiController::class, 'edit'])->name('presensi_edit');

        Route::get('surat_notif/{jenis}', [Tmsurat_masterController::class, 'surat_notif'])->name('surat_notif');
        Route::get('report_surat', [GuruController::class, 'report_surat'])->name('report_surat');
        Route::get('download', [Tmsurat_masterController::class, 'download'])->name('download');
        Route::get('download_suratmaster', [Tmsurat_masterController::class, 'excel'])->name('download_suratmaster');

        Route::get('download_report', [GuruController::class, 'xls_report'])->name('download_report');
        Route::post('update_surat', [Tmsurat_masterController::class, 'update_surat'])->name('update_surat');
    });
    // api  route datatable
    Route::get('view_download', [Tmsurat_masterController::class, 'view_download'])->name('view_download');

    Route::prefix('api')->name('api.')->group(function () {
        Route::get('log', [GuruController::class, 'api_log'])->name('log');
        Route::get('reportsurat', [GuruController::class, 'api'])->name('reportsurat');
        Route::get('jenis_surat', [JenisGuruController::class, 'api'])->name('jenis_surat');
        Route::get('tmsurat_master', [Tmsurat_masterController::class, 'api'])->name('tmsurat_master');
        Route::get('tmpsurat', [TmpGuruController::class, 'api'])->name('tmpsurat');
        Route::get('log', [GuruController::class, 'log'])->name('log');
        Route::post('laporan_presensi', [PresensiController::class, 'api'])->name('laporan_presensi');
        Route::post('kartu_siswa', [SiswaPresensiController::class, 'api'])->name('kartu_siswa');

        Route::post('mapel', [MapelController::class, 'api'])->name('mapel');
        Route::post('jadwal', [JadwalController::class, 'api'])->name('jadwal');
        Route::post('jadwalscan', [JadwalController::class, 'jadwalscan'])->name('jadwalscan');
        Route::post('user', [UserController::class, 'api'])->name('user');

        Route::post('siswa', [SiswaController::class, 'api'])->name('siswa');
        Route::post('guru', [GuruController::class, 'api'])->name('guru');
        Route::get('laporan_surat', [GuruController::class, 'laporan_surat'])->name('laporan_surat');
        Route::post('table_data', [HomeController::class, 'table_data'])->name('table_data');
        Route::post('saveabsen', [PresensiController::class, 'saveabsen'])->name('saveabsen');
        Route::post('simpanjadwal', [PresensiController::class, 'setJadwal'])->name('simpanjadwal');

    });
    Route::post('jenis_show/{id}', [GuruController::class, 'carijenis'])->name('jenis_show');
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('laporan_presensi', [SiswaPresensiController::class, 'laporan_presensi'])->name('laporan_presensi');
        Route::post('delete_presensi', [SiswaPresensiController::class, 'destroy'])->name('delete_presensi');

        Route::get('pegawai', [PegawaiController::class, 'laporan_pegawai'])->name('pegawai');
        Route::get('siswa', [SiswaController::class, 'laporan_siswa'])->name('siswa');
    });

    Route::prefix('dashboard_api')->name('dashboard_api.')->group(function () {
        Route::get('site_jabodetabek', [HomeController::class, 'site_jabodetabek'])->name('site_jabodetabek');
        Route::get('pr_western_jabo', [HomeController::class, 'pr_western_jabo'])->name('pr_western_jabo');
        Route::get('pr_centeral_jabo', [HomeController::class, 'pr_centeral_jabo'])->name('pr_centeral_jabo');
        Route::get('pr_eastern_jabo', [HomeController::class, 'pr_eastern_jabo'])->name('pr_eastern_jabo');

        Route::get('graph_revenue', [HomeController::class, 'graph_revenue'])->name('graph_revenue');
    });
});

Auth::routes();
