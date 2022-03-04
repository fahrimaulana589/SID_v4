<?php

use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Data\DataEditScreen;
use App\Orchid\Screens\Data\DataListScreen;
use App\Orchid\Screens\agenda\AgendaListScreen;

Route::screen('data', DataListScreen::class)
    ->name('platform.datas')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Data',route('platform.datas'));
    });

Route::screen('data/buat', DataEditScreen::class)
    ->name('platform.datas.create')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.datas')
            ->push('Buat',route('platform.datas.create'));
    });

Route::screen('data/{data}/edit', DataEditScreen::class)
    ->name('platform.datas.edit')
    ->breadcrumbs(function (Trail $trail,$data){
        return $trail
            ->parent('platform.datas')
            ->push('Edit',route('platform.datas.edit',$data));
    });



