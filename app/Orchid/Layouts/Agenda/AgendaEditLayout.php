<?php

namespace App\Orchid\Layouts\Agenda;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
class AgendaEditLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('agenda.title')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Nama')
                ->placeholder('Masukan nama')
    ];
    }
}
