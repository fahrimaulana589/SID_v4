<?php

namespace App\Orchid\Layouts\Surat;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class SuratEditLayout extends Rows
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
            Input::make('surat_masuk.new_file')
                ->title('File surat')
                ->type('file'),

            Input::make('surat_masuk.file')
                ->canSee($this->query->get('exist'))
                ->readonly(),

            Input::make('surat_masuk.title')
                ->title('Judul surat')
                ->max(255)
                ->placeholder('Masukan judul surat')
                ->required(),

            TextArea::make('surat_masuk.description')
                ->title('Deskripsi surat')
                ->max(255)
                ->rows(5)
                ->placeholder('Masukan deskripsi surat')
                ->required(),

            Input::make('surat_masuk.pengirim')
                ->title('Pengirim surat')
                ->required(),


        ];
    }
}
