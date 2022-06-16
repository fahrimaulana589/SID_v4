<?php

use App\Orchid\Screens\Warga\PelayananMasukListScreen;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;

// Agenda
Route::screen('pelayanan', PelayananMasukListScreen::class)
    ->name('platform.pelayanan.masuk')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Pelayanan Masuk',route('platform.pelayanan.masuk'));
    });
