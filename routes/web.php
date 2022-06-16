<?php

use App\Http\Controllers\SuratKeluarController;
use App\Orchid\Screens\Surat\SuratKeluarEditScreen;
use App\Orchid\Screens\Warga\PelayananAddScreen;
use App\Orchid\Screens\Warga\PelayananListScreen;
use App\Orchid\Screens\Warga\PelayananShowScreen;
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

Route::get('/', function () {
    return redirect('admin/profile');
});


Route::get('surat-keluars/{surat_keluar}/datas/{data}/download',[SuratKeluarController::class,'download'])->name('download');
Route::get('surat-keluars/{surat_keluar}/datas/{data}/print',[SuratKeluarController::class,'print'])->name('print');


Route::screen('warga/pelayanan/{pelayanan}/add', PelayananAddScreen::class)
    ->name('platform.warga.pelayanan.show.add');

Route::screen('warga/pelayanan/{pelayanan}', PelayananShowScreen::class)
    ->name('platform.warga.pelayanan.show');

Route::screen('warga/pelayanan',PelayananListScreen::class)
    ->name('platform.warga.pelayanan');


