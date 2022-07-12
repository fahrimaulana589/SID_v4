<?php

use App\Orchid\Screens\Profile\ProfileEditScreen;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Agenda\AgendaEditScreen;
use App\Orchid\Screens\Agenda\AgendaListScreen;
use App\Orchid\Screens\Agenda\AgendaShowScreen;
use App\Orchid\Screens\Agenda\DataAgendaEditScreen;

// Agenda
Route::screen('profile-desa', ProfileEditScreen::class)
    ->name('platform.profiledesa')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Profile Desa',route('platform.profiledesa'));
    });
