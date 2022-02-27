<?php

namespace App\Orchid\Layouts\Agenda;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;

class DataAgendaPendudukLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('dataAgenda.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Nama')
                ->placeholder('Masukan nama'),
            Input::make('dataAgenda.place_of_birth')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Tempat')
                ->placeholder('Masukan tempat lahir'),
            Input::make('dataAgenda.date_of_birth')
                ->type('date')
                ->required()
                ->title('Tanggal lahir'),
            Select::make('dataAgenda.gender')
                ->options([
                    'pria'   => 'Pria',
                    'wanita' => 'Wanita',
                ])
                ->required()
                ->title('Pilih jenis kelamin'),
            Input::make('dataAgenda.profession')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Pekerjaan')
                ->placeholder('Masukan pekerjaan'),
            Input::make('dataAgenda.religion')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Agama')
                ->placeholder('Masukan agama'),
            TextArea::make('dataAgenda.address')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Alamat')
                ->placeholder('Masukan alamat')
                ->rows('7'),
            Input::make('dataAgenda.education')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Pendidikan')
                ->placeholder('Masukan pendidikan'),
            Input::make('dataAgenda.status')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Status')
                ->placeholder('Masukan status'),

        ];
    }
}
