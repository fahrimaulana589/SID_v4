<?php

use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Keluarga\KeluargaEditScreen;
use App\Orchid\Screens\Keluarga\KeluargaListScreen;
use App\Orchid\Screens\Keluarga\KeluargaAnggotaEditScreen;
use App\Orchid\Screens\Keluarga\KeluargaAnggotaListScreen;

Route::screen('keluarga',KeluargaListScreen::class)
    ->name('platform.keluargas')
    ->breadcrumbs(function (Trail $trail){

        return $trail
            ->parent('platform.index')
            ->push('Keluarga',route('platform.keluargas'));
    });

Route::screen('keluarga/buat',KeluargaEditScreen::class)
    ->name('platform.keluargas.create')
    ->breadcrumbs(function (Trail $trail){

        return $trail
            ->parent('platform.keluargas')
            ->push('Buat',route('platform.keluargas.create'));
    });

Route::screen('keluarga/{keluarga}/edit',KeluargaEditScreen::class)
    ->name('platform.keluargas.edit')
    ->breadcrumbs(function (Trail $trail,$keluaga){

        return $trail
            ->parent('platform.keluargas')
            ->push('Edit',route('platform.keluargas.edit',$keluaga));
    });

Route::screen('keluarga/{keluarga}/anggota',KeluargaAnggotaListScreen::class)
    ->name('platform.keluargas.anggotas')
    ->breadcrumbs(function (Trail $trail,$keluarga){

        return $trail
            ->parent('platform.keluargas')
            ->push('Anggota',route('platform.keluargas.anggotas',$keluarga));

    });

Route::screen('keluarga/{keluarga}/anggota/buat',KeluargaAnggotaEditScreen::class)
    ->name('platform.keluargas.anggotas.create')
    ->breadcrumbs(function (Trail $trail,$keluarga){

        return $trail
            ->parent('platform.keluargas.anggotas',$keluarga)
            ->push('Buat',route('platform.keluargas.anggotas.create',$keluarga));

    });

Route::screen('keluarga/{keluarga}/anggota/{anggota}/edit',KeluargaAnggotaEditScreen::class)
    ->name('platform.keluargas.anggotas.edit')
    ->breadcrumbs(function (Trail $trail,$keluarga,$anggota){

        return $trail
            ->parent('platform.keluargas.anggotas',$keluarga)
            ->push('Edit',route('platform.keluargas.anggotas.edit',[$keluarga,$anggota]));

    });

