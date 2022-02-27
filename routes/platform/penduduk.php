<?php

use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Penduduk\PendudukEditScreen;
use App\Orchid\Screens\Penduduk\PendudukListScreen;

Route::screen('penduduks', PendudukListScreen::class)
->name('platform.penduduks')
->breadcrumbs(function (Trail $trail) {
    return $trail
        ->parent('platform.index')
        ->push(__('Data Penduduk'), route('platform.penduduks'));
});


Route::screen('penduduks/create', PendudukEditScreen::class)
->name('platform.penduduks.create')
->breadcrumbs(function (Trail $trail) {
    return $trail
        ->parent('platform.penduduks')
        ->push("Create", route('platform.penduduks.create'));
});

Route::screen('penduduks/{penduduk}/edit', PendudukEditScreen::class)
->name('platform.penduduks.edit')
->breadcrumbs(function (Trail $trail,$penduduk) {
    return $trail
        ->parent('platform.penduduks')
        ->push("Create", route('platform.penduduks.edit',$penduduk));
});


 