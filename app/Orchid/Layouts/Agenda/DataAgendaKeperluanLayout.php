<?php

namespace App\Orchid\Layouts\Agenda;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class DataAgendaKeperluanLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            TextArea::make('dataAgenda.necessity')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Keperluan')
                ->placeholder('Masukan keperluan')
                ->rows('7'),
        ];
    }
}
