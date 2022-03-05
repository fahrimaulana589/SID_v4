<?php

use App\Models\SuratKeluar;
use Tabuna\Breadcrumbs\Trail;
use App\Models\SuratKeluarData;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Orchid\Screens\Surat\SuratEditScreen;
use App\Orchid\Screens\Surat\SuratListScreen;
use App\Orchid\Screens\Surat\SuratShowScreen;
use App\Orchid\Screens\Surat\SuratKeluarEditScreen;
use App\Orchid\Screens\Surat\SuratKeluarListScreen;
use App\Orchid\Screens\Surat\SuratKeluarShowScreen;
use App\Orchid\Screens\Surat\SuratKeluarDataEditScreen;

Route::screen('surat-masuk',SuratListScreen::class)
    ->name('platform.surat-masuks')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Data Surat Masuk',route('platform.surat-masuks'));
    });

Route::screen('surat-masuk/buat',SuratEditScreen::class)
    ->name('platform.surat-masuks.create')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.surat-masuks')
            ->push('Buat',route('platform.surat-masuks.create'));
    });

Route::screen('surats-masuk/{surat}/edit',SuratEditScreen::class)
    ->name('platform.surat-masuks.edit')
    ->breadcrumbs(function (Trail $trail,$surat){
        return $trail
            ->parent('platform.surat-masuks')
            ->push('Edit',route('platform.surat-masuks.edit',$surat));
    });

Route::screen('surats-masuk/{surat}/data',SuratShowScreen::class)
    ->name('platform.surat-masuks.show')
    ->breadcrumbs(function (Trail $trail,$surat){
        return $trail
            ->parent('platform.surat-masuks')
            ->push('Data',route('platform.surat-masuks.show',$surat));
    });

Route::screen('surat-keluar',SuratKeluarListScreen::class)
    ->name('platform.surat-keluars')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Data Surat Keluar',route('platform.surat-keluars'));
        });

Route::screen('surat-keluar/buat',SuratKeluarEditScreen::class)
    ->name('platform.surat-keluars.create')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.surat-keluars')
            ->push('Buat',route('platform.surat-keluars.create'));
    });

Route::screen('surat-keluar/{surat_keluar}/edit',SuratKeluarEditScreen::class)
    ->name('platform.surat-keluars.edit')
    ->breadcrumbs(function (Trail $trail,$surat_keluar){
        return $trail
            ->parent('platform.surat-keluars')
            ->push('Edit',route('platform.surat-keluars.edit',$surat_keluar));
    });

Route::screen('surat-keluar/{surat_keluar}/data',SuratKeluarShowScreen::class)
    ->name('platform.surat-keluars.show')
    ->breadcrumbs(function (Trail $trail,$surat_keluar){
        return $trail
            ->parent('platform.surat-keluars')
            ->push('Data',route('platform.surat-keluars.show',$surat_keluar));
    });

Route::screen('surat-keluar/{surat_keluar}/data/buat',SuratKeluarDataEditScreen::class)
    ->name('platform.surat-keluars.datas.create')
    ->breadcrumbs(function (Trail $trail,$surat_keluar){
        return $trail
            ->parent('platform.surat-keluars.show',$surat_keluar)
            ->push('Buat',route('platform.surat-keluars.datas.create',$surat_keluar));
    });

Route::screen('surat-keluar/{surat_keluar}/data/{data}/edit',SuratKeluarDataEditScreen::class)
    ->name('platform.surat-keluars.datas.edit')
    ->breadcrumbs(function (Trail $trail,$surat_keluar,$data){
        return $trail
            ->parent('platform.surat-keluars.show',$surat_keluar)
            ->push('Edit',route('platform.surat-keluars.datas.edit',[$surat_keluar,$data]));
    });

