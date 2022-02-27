<?php

use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\agenda\AgendaEditScreen;
use App\Orchid\Screens\agenda\AgendaListScreen;
use App\Orchid\Screens\Agenda\AgendaShowScreen;
use App\Orchid\Screens\Agenda\DataAgendaEditScreen;

// Agenda
Route::screen('agendas', AgendaListScreen::class)
    ->name('platform.agendas')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Data Agenda',route('platform.agendas'));
    });

// Create agenda
Route::screen('agendas/create', AgendaEditScreen::class)
    ->name('platform.agendas.create')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.agendas')
            ->push('Create',route('platform.agendas.create'));
    });

// Create agenda data
Route::screen('agendas/{agenda}/datas/create', DataAgendaEditScreen::class)
    ->name('platform.agendas.create.data')
    ->breadcrumbs(function (Trail $trail,$agenda){
        return $trail
            ->parent('platform.agendas.show',$agenda)
            ->push('Create',route('platform.agendas.create.data',$agenda));
    });

// Edit agenda data
Route::screen('agendas/{agenda}/datas/{dataAgenda}/create', DataAgendaEditScreen::class)
    ->name('platform.agendas.edit.data')
    ->breadcrumbs(function (Trail $trail,$agenda,$dataAgenda){
        return $trail
            ->parent('platform.agendas.show',$agenda)
            ->push('Create',route('platform.agendas.edit.data',[$agenda,$dataAgenda]));
    });


//show agenda
Route::screen('agendas/{agenda}/datas',AgendaShowScreen::class)
    ->name('platform.agendas.show')
    ->breadcrumbs(function (Trail $trail,$agenda){
        return $trail
            ->parent('platform.agendas')
            ->push('Agenda',route('platform.agendas.show',$agenda));
    });

// Edit agenda
Route::screen('agendas/{agenda}/edit', AgendaEditScreen::class)
    ->name('platform.agendas.edit')
    ->breadcrumbs(function (Trail $trail,$agenda){
        return $trail
            ->parent('platform.agendas')
            ->push('Create',route('platform.agendas.edit',$agenda));
    });



