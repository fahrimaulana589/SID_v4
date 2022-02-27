<?php

namespace App\Orchid\Layouts\Agenda;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class AgendaDescriptionLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            TextArea::make('agenda.description')
                ->type('textarea')
                ->max(255)
                ->required()
                ->title('Deskripsi')
                ->rows(5)
                ->placeholder('Masukan Deskripsi')
        ];
    }
}
