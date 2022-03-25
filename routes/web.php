<?php

use App\Http\Controllers\SuratKeluarController;
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

Route::get('/', function () {
    return redirect('admin/profile');
});

Route::get('surat-keluars/{surat_keluar}/datas/{data}/download',[SuratKeluarController::class,'download'])->name('download');
Route::get('surat-keluars/{surat_keluar}/datas/{data}/print',[SuratKeluarController::class,'print'])->name('print');
