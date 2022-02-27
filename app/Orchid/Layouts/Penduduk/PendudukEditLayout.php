<?php

namespace App\Orchid\Layouts\Penduduk;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class PendudukEditLayout extends Rows
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
            Input::make('penduduk.NIK')
                ->type('text')
                ->max(255)
                ->required()
                ->title('NIK')
                ->placeholder('Masukan NIK'),

            Input::make('penduduk.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Nama')
                ->placeholder('Masukan nama'),

            Input::make('penduduk.place_of_birth')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Tempat lahir')
                ->placeholder('Masukan tempat lahir'),

            Input::make('penduduk.date_of_birth')
                ->type('date')
                ->max(255)
                ->required()
                ->title('Tanggal lahir')
                ->placeholder('Masukan tanggal lahir'),

            Select::make('penduduk.gender')
                ->required()
                ->title('Jenis kelamin')
                ->options([
                        'pria' => 'Pria',
                        'wanita' => 'Wanita'
                ]),

            Select::make('penduduk.blood')
                ->required()
                ->title('Golongan darah')
                ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'O' => 'O',
                        'AB' => 'AB'
                ]),

            TextArea::make('penduduk.address')
                ->type('text')
                ->max(255)
                ->required()
                ->rows(5)
                ->title('Alamat')
                ->placeholder('Masukan alamat'),

            Input::make('penduduk.rt')
                ->type('number')
                ->max(99)
                ->required()
                ->title('RT')
                ->placeholder('Masukan RT'),

            Input::make('penduduk.rw')
                ->type('number')
                ->max(99)
                ->required()
                ->title('RW')
                ->placeholder('Masukan RW'),

            Input::make('penduduk.kelurahan_desa')
                ->type('text')
                ->max(99)
                ->required()
                ->title('Kelurahan/Desa')
                ->placeholder('Masukan kelurahan atau desa'),

            Input::make('penduduk.kecamatan')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Kecamatan')
                ->placeholder('Masukan '),

            Select::make('penduduk.religion')
                ->required()
                ->title('Agama')
                ->options([
                        'islam' => 'Islam',
                        'kristen' => 'Kristen',
                ]),

            Select::make('penduduk.status_perkawinan')
                ->required()
                ->title('Status perkawinan')
                ->options([
                        'menikah' => "Menikah",
                        'belum menikah' => 'Belum menikah',
                ]),

            Input::make('penduduk.profession')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Pekerjaan')
                ->placeholder('Masukan pekerjaan'),

            Input::make('penduduk.kewerganegaraan')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Kewerganegaraan')
                ->placeholder('Masukan kewerganegaraan'),

            Input::make('penduduk.education')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Pendidikan')
                ->placeholder('Masukan pendidikan'),

        ];
    }
}
