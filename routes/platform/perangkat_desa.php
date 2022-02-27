<?php

use App\Models\PerangkatDesa;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Perangkat\PerangkatEditScreen;
use App\Orchid\Screens\Perangkat\PerangkatListScreen;



Route::screen('perangkats', PerangkatListScreen::class)
    ->name('platform.perangkats')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Data',route('platform.perangkats'));
    });

Route::screen('perangkats/create', PerangkatEditScreen::class)
    ->name('platform.perangkats.create')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.perangkats')
            ->push('Create',route('platform.perangkats.create'));
    });

Route::screen('perangkats/{data}/edit', PerangkatEditScreen::class)
    ->name('platform.perangkats.edit')
    ->breadcrumbs(function (Trail $trail,$data){
        return $trail
            ->parent('platform.perangkats')
            ->push('Edit',route('platform.perangkats.edit',$data));
    });







