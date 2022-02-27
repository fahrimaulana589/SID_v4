<?php

namespace App\Orchid\Layouts\Keluarga;

use App\Models\Penduduk;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class KeluargaAnggotaEditLayout extends Rows
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
            Relation::make('penduduk.id')
                ->fromModel(Penduduk::class,'NIK')
                ->required()
                ->title('NIK Anggota')
                ->placeholder('Masukan NIK'),

            Input::make('penduduk.status_keluarga')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Statusa dalam keluarga')
                ->placeholder('Masukan status'),

            Input::make('penduduk.name_ayah')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Nama ayah')
                ->placeholder('Masukan nama ayah'),

            Input::make('penduduk.name_ibu')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Nama ibu')
                ->placeholder('Masukan nama ibu'),

        ];
    }
}
