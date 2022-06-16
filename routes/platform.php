<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\PlatformScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('dashboard', PlatformScreen::class)
    ->name('platform.dashboard');

include_once('platform/agenda.php');
include_once('platform/user.php');
include_once('platform/role.php');
include_once('platform/surat.php');
include_once('platform/penduduk.php');
include_once('platform/keluarga.php');
include_once('platform/atribute.php');
include_once('platform/perangkat_desa.php');
include_once('platform/pelayanan.php');










