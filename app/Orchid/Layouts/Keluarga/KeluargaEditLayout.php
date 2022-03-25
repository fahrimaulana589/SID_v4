<?php

namespace App\Orchid\Layouts\Keluarga;

use App\Models\Penduduk;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;

class KeluargaEditLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('keluarga.KK')
                ->type('text')
                ->max(255)
                ->required()
                ->title('KK')
                ->placeholder('Masukan KK'),

            Relation::make('keluarga.id_kepala_keluarga')
                ->fromModel(Penduduk::class, 'NIK')
                ->required()
                ->title('NIK kepala keluarga'),

            Input::make('kepala.name_ibu')
                ->type('text')
                ->max(99)
                ->required()
                ->title('Ibu kepala keluarga')
                ->placeholder('Masukan nama ibu kepala keluarga'),

            Input::make('kepala.name_ayah')
                ->type('text')
                ->max(99)
                ->required()
                ->title('Ayah kepala keluarga')
                ->placeholder('Masukan nama ayah kepala keluarga'),


            TextArea::make('keluarga.address')
                ->type('text')
                ->rows(5)
                ->required()
                ->title('Alamat')
                ->placeholder('Masukan alamat'),

            Input::make('keluarga.rt')
                ->type('number')
                ->max(99)
                ->required()
                ->title('RT')
                ->placeholder('Masukan RT'),

            Input::make('keluarga.rw')
                ->type('number')
                ->max(99)
                ->required()
                ->title('RW')
                ->placeholder('Masukan RW'),

            Input::make('keluarga.kode_pos')
                ->type('number')
                ->max(999999)
                ->required()
                ->title('Kode pos')
                ->placeholder('Masukan kode pos'),

            Input::make('keluarga.kelurahan_desa')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Kelurahan/Desa')
                ->placeholder('Masukan kelurahan/desa'),

            Input::make('keluarga.kecamatan')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Kecamatan')
                ->placeholder('Masukan kecamatan'),

            Input::make('keluarga.kabupaten_kota')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Kabupaten/Kota')
                ->placeholder('Masukan kabupaten/kota'),

            Input::make('keluarga.provinsi')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Provinsi')
                ->placeholder('Masukan provinsi'),


        ];
    }
}
