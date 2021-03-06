<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\SuratKeluarController;
use App\Orchid\Screens\Surat\SuratKeluarEditScreen;
use App\Orchid\Screens\Warga\PelayananAddScreen;
use App\Orchid\Screens\Warga\PelayananListScreen;
use App\Orchid\Screens\Warga\PelayananShowScreen;
use App\Orchid\Screens\Warga\PelayananaMasukCekScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

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

Route::get('/', [HomeController::class,"home"]);

Route::get("page/{page}",[HomeController::class,"page"]);

Route::get("pelayanan",[PelayananController::class,"show"])->name("pelayanan.show");
Route::post("pelayanan",[PelayananController::class,"store"])->name("pelayanan.store");
Route::get("pelayanan/{pelayanan}",[PelayananController::class,"pelayanan"])->name("pelayanan.pelayanan");

Route::get('surat-keluars/{surat_keluar}/datas/{data}/download',[SuratKeluarController::class,'download'])->name('download');
Route::get('surat-keluars/{surat_keluar}/datas/{data}/print',[SuratKeluarController::class,'print'])->name('print');


Route::screen('warga/cek/{pelayanan?}', PelayananaMasukCekScreen::class)
    ->name('platform.warga.pelayanan.cek');

Route::screen('warga/pelayanan/{pelayanan}/add', PelayananAddScreen::class)
    ->name('platform.warga.pelayanan.show.add');

Route::screen('warga/pelayanan/{pelayanan}', PelayananShowScreen::class)
    ->name('platform.warga.pelayanan.show');

Route::screen('warga/pelayanan',PelayananListScreen::class)
    ->name('platform.warga.pelayanan');
