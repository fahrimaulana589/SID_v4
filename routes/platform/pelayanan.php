<?php

use App\Orchid\Screens\Warga\PelayananMasukListScreen;
use App\Orchid\Screens\Warga\PelayananMasukEditScreen;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;

Route::screen('pelayanan/{pelayanan}/edit', PelayananMasukEditScreen::class)
    ->name('platform.pelayanan.masuk.edit')
    ->breadcrumbs(function (Trail $trail,$pelayanan){
        return $trail
            ->parent('platform.pelayanan.masuk')
            ->push('Edit',route('platform.pelayanan.masuk.edit',$pelayanan));
    });

Route::screen('pelayanan', PelayananMasukListScreen::class)
    ->name('platform.pelayanan.masuk')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Pelayanan Masuk',route('platform.pelayanan.masuk'));
    });


