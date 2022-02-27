<?php

use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Keluarga\KeluargaEditScreen;
use App\Orchid\Screens\Keluarga\KeluargaListScreen;
use App\Orchid\Screens\Keluarga\KeluargaAnggotaEditScreen;
use App\Orchid\Screens\Keluarga\KeluargaAnggotaListScreen;

Route::screen('keluargas',KeluargaListScreen::class)
    ->name('platform.keluargas')
    ->breadcrumbs(function (Trail $trail){

        return $trail
            ->parent('platform.index')
            ->push('Data Keluarga',route('platform.keluargas'));
    });

Route::screen('keluargas/create',KeluargaEditScreen::class)
    ->name('platform.keluargas.create')
    ->breadcrumbs(function (Trail $trail){

        return $trail
            ->parent('platform.keluargas')
            ->push('Create',route('platform.keluargas.create'));
    });

Route::screen('keluargas/{keluarga}/edit',KeluargaEditScreen::class)
    ->name('platform.keluargas.edit')
    ->breadcrumbs(function (Trail $trail,$keluaga){

        return $trail
            ->parent('platform.keluargas')
            ->push('Edit',route('platform.keluargas.edit',$keluaga));
    });

Route::screen('keluargas/{keluarga}/anggotas',KeluargaAnggotaListScreen::class)
    ->name('platform.keluargas.anggotas')
    ->breadcrumbs(function (Trail $trail,$keluarga){

        return $trail
            ->parent('platform.keluargas')
            ->push('Data Anggota Keluarga',route('platform.keluargas.anggotas',$keluarga));

    });

Route::screen('keluargas/{keluarga}/anggotas/create',KeluargaAnggotaEditScreen::class)
    ->name('platform.keluargas.anggotas.create')
    ->breadcrumbs(function (Trail $trail,$keluarga){

        return $trail
            ->parent('platform.keluargas')
            ->push('Data Anggota Keluarga',route('platform.keluargas.anggotas.create',$keluarga));

    });

Route::screen('keluargas/{keluarga}/anggotas/{anggota}/edit',KeluargaAnggotaEditScreen::class)
    ->name('platform.keluargas.anggotas.edit')
    ->breadcrumbs(function (Trail $trail,$keluarga,$anggota){

        return $trail
            ->parent('platform.keluargas')
            ->push('Data Anggota Keluarga',route('platform.keluargas.anggotas.edit',[$keluarga,$anggota]));

    });

