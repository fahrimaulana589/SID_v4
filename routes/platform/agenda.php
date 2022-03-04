<?php

use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Agenda\AgendaEditScreen;
use App\Orchid\Screens\Agenda\AgendaListScreen;
use App\Orchid\Screens\Agenda\AgendaShowScreen;
use App\Orchid\Screens\Agenda\DataAgendaEditScreen;

// Agenda
Route::screen('agenda', AgendaListScreen::class)
    ->name('platform.agendas')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Agenda',route('platform.agendas'));
    });

// Create agenda
Route::screen('agenda/buat', AgendaEditScreen::class)
    ->name('platform.agendas.create')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.agendas')
            ->push('Buat',route('platform.agendas.create'));
    });

// Edit agenda
Route::screen('agenda/{agenda}/edit', AgendaEditScreen::class)
->name('platform.agendas.edit')
->breadcrumbs(function (Trail $trail,$agenda){
    return $trail
    ->parent('platform.agendas')
    ->push('Create',route('platform.agendas.edit',$agenda));
});

//show agenda
Route::screen('agenda/{agenda}/data', AgendaShowScreen::class)
    ->name('platform.agendas.show')
    ->breadcrumbs(function (Trail $trail,$agenda){
        return $trail
            ->parent('platform.agendas')
            ->push('Data',route('platform.agendas.show',$agenda));
    });

// Create agenda data
Route::screen('agenda/{agenda}/data/buat', DataAgendaEditScreen::class)
    ->name('platform.agendas.create.data')
    ->breadcrumbs(function (Trail $trail,$agenda){
        return $trail
            ->parent('platform.agendas.show',$agenda)
            ->push('Buat',route('platform.agendas.create.data',$agenda));
    });

// Edit agenda data
Route::screen('agenda/{agenda}/data/{dataAgenda}/edit', DataAgendaEditScreen::class)
    ->name('platform.agendas.edit.data')
    ->breadcrumbs(function (Trail $trail,$agenda,$dataAgenda){
        return $trail
            ->parent('platform.agendas.show',$agenda)

    ->push('Edit',route('platform.agendas.edit.data',[$agenda,$dataAgenda]));
    });




