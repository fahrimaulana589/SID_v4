<?php

use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Penduduk\PendudukEditScreen;
use App\Orchid\Screens\Penduduk\PendudukListScreen;

Route::screen('penduduk', PendudukListScreen::class)
->name('platform.penduduks')
->breadcrumbs(function (Trail $trail) {
    return $trail
        ->parent('platform.index')
        ->push(__('Penduduk'), route('platform.penduduks'));
});


Route::screen('penduduk/buat', PendudukEditScreen::class)
->name('platform.penduduks.create')
->breadcrumbs(function (Trail $trail) {
    return $trail
        ->parent('platform.penduduks')
        ->push("Buat", route('platform.penduduks.create'));
});

Route::screen('penduduk/{penduduk}/edit', PendudukEditScreen::class)
->name('platform.penduduks.edit')
->breadcrumbs(function (Trail $trail,$penduduk) {
    return $trail
        ->parent('platform.penduduks')
        ->push("Edit", route('platform.penduduks.edit',$penduduk));
});
