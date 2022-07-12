<?php

use App\Orchid\Screens\Page\PageAddScreen;
use App\Orchid\Screens\Page\PageEditScreen;
use App\Orchid\Screens\Page\PageListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;


Route::screen('page/{page}/edit', PageEditScreen::class)
    ->name('platform.pages.edit')
    ->breadcrumbs(function (Trail $trail,$page) {
        return $trail
            ->parent('platform.pages')
            ->push("Edit", route('platform.pages.edit',$page));
    });


Route::screen('page/buat', PageAddScreen::class)
    ->name('platform.pages.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.pages')
            ->push("Buat", route('platform.pages.create'));
    });


Route::screen('page', PageListScreen::class)
    ->name('platform.pages')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Page'), route('platform.pages'));
    });
