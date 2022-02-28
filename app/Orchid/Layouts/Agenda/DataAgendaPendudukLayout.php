<?php

namespace App\Orchid\Layouts\Agenda;

use App\Models\Penduduk;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
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
            Input::make('dataAgenda.no_surat')
                ->type('text')
                ->max(255)
                ->required()
                ->title('No surat')
                ->placeholder('Masukan nama'),
            Relation::make('dataAgenda.id_penduduk')
                ->fromModel(Penduduk::class,'NIK')
                ->title('Penduduk')
                ->required()
        ];
    }
}
