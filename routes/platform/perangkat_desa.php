<?php

use App\Models\PerangkatDesa;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Perangkat\PerangkatEditScreen;
use App\Orchid\Screens\Perangkat\PerangkatListScreen;



Route::screen('perangkat', PerangkatListScreen::class)
    ->name('platform.perangkats')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Perangkat',route('platform.perangkats'));
    });

Route::screen('perangkat/buat', PerangkatEditScreen::class)
    ->name('platform.perangkats.create')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.perangkats')
            ->push('Buat',route('platform.perangkats.create'));
    });

Route::screen('perangkat/{data}/edit', PerangkatEditScreen::class)
    ->name('platform.perangkats.edit')
    ->breadcrumbs(function (Trail $trail,$data){
        return $trail
            ->parent('platform.perangkats')
            ->push('Edit',route('platform.perangkats.edit',$data));
    });







