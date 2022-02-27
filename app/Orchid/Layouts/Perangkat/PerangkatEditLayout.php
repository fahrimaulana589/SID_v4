<?php

namespace App\Orchid\Layouts\Perangkat;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class PerangkatEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
        Input::make('perangkat.name')
            ->title('Nama')
            ->required()
            ->max(255),

        Input::make('perangkat.jabatan')
            ->title('Jabatan')
            ->required()
            ->max(255),

        Input::make('perangkat.persingkat_jabatan')
            ->title('Singkatan jabatan')
            ->required()
            ->max(255),
        ];
    }
}
