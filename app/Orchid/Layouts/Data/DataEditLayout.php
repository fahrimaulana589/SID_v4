<?php

namespace App\Orchid\Layouts\Data;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class DataEditLayout extends Rows
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
            Input::make('data.title')
                ->title('Judul')
                ->required()
                ->max(255),

            Input::make('data.key')
                ->title('Key')
                ->required()
                ->max(255),

            Select::make('data.type')
            ->options([
                'text'   => 'Teks',
                'multitext' => 'Paragraf',
            ])
            ->title('Tipe')
        ];
    }
}
