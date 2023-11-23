<?php

use App\Http\Controllers\ExportImportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\RepairDataController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TmpSuratController;
use App\Http\Controllers\Tmsurat_masterController;
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
        Route::resource('surat', SuratController::class);
        Route::resource('tmsurat_master', Tmsurat_masterController::class);
        Route::resource('tmpsurat', TmpSuratController::class);
        Route::resource('jenis_surat', JenisSuratController::class);
        Route::resource('export_import_data', ExportImportController::class);
        Route::resource('repairdata', RepairDataController::class);
        Route::get('log', [SuratController::class, 'log'])->name('log');

        Route::get('surat_notif/{jenis}', [Tmsurat_masterController::class, 'surat_notif'])->name('surat_notif');
        Route::get('report_surat', [SuratController::class, 'report_surat'])->name('report_surat');
        Route::get('download', [Tmsurat_masterController::class, 'download'])->name('download');
        Route::get('download_suratmaster', [Tmsurat_masterController::class, 'excel'])->name('download_suratmaster');

        // Route::get('download', [Tmsurat_masterController::class, 'download'])->name('download');
        Route::get('download_report', [SuratController::class, 'xls_report'])->name('download_report');
        Route::post('update_surat', [Tmsurat_masterController::class, 'update_surat'])->name('update_surat');
    });
    // api  route datatable
    Route::get('view_download', [Tmsurat_masterController::class, 'view_download'])->name('view_download');

    Route::prefix('api')->name('api.')->group(function () {
        Route::get('log', [SuratController::class, 'api_log'])->name('log');
        Route::get('reportsurat', [SuratController::class, 'api'])->name('reportsurat');
        Route::get('jenis_surat', [JenisSuratController::class, 'api'])->name('jenis_surat');
        Route::get('tmsurat_master', [Tmsurat_masterController::class, 'api'])->name('tmsurat_master');
        Route::get('tmpsurat', [TmpSuratController::class, 'api'])->name('tmpsurat');
        Route::get('log', [SuratController::class, 'log'])->name('log');

        Route::get('laporan_surat', [SuratController::class, 'laporan_surat'])->name('laporan_surat');
        Route::post('table_data', [HomeController::class, 'table_data'])->name('table_data');
    });

    Route::post('jenis_show/{id}', [SuratController::class, 'carijenis'])->name('jenis_show');
    Route::prefix('dashboard_api')->name('dashboard_api.')->group(function () {
        // prefix_dashboard
        Route::get('site_jabodetabek', [HomeController::class, 'site_jabodetabek'])->name('site_jabodetabek');
        Route::get('pr_western_jabo', [HomeController::class, 'pr_western_jabo'])->name('pr_western_jabo');
        Route::get('pr_centeral_jabo', [HomeController::class, 'pr_centeral_jabo'])->name('pr_centeral_jabo');
        Route::get('pr_eastern_jabo', [HomeController::class, 'pr_eastern_jabo'])->name('pr_eastern_jabo');

        Route::get('graph_revenue', [HomeController::class, 'graph_revenue'])->name('graph_revenue');
    });
});

Auth::routes();
