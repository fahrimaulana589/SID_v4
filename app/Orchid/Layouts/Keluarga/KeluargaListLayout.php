<?php

namespace App\Orchid\Layouts\Keluarga;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class KeluargaListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'keluargas';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [

            TD::make('KK','No KK')
                ->sort()
                ->filter(Input::make()),

            TD::make('kepala','Nama kepala keluarga')
                ->sort()
                ->render(function ($value){
                    return $value->kepala->name;
                })
                ->filter(Input::make()),

            TD::make('address','Alamat')
                ->sort()
                ->filter(Input::make()),

            TD::make('rt_rw',"RT/RW")
                ->sort()
                ->filter(Input::make()),

            TD::make('kode_pos','Kode pos')
                ->sort()
                ->filter(Input::make()),

            TD::make('kelurahan_desa','Keluarah/Desa')
                ->sort()
                ->filter(Input::make()),

            TD::make('kecamatan','Kecamatan')
                ->sort()
                ->filter(Input::make()),

            TD::make('kabupaten_kota','Kabutan/Kota')
                ->sort()
                ->filter(Input::make()),

            TD::make('provinsi','Provinsi')
                ->sort()
                ->filter(Input::make()),

            TD::make('dibuat','Dibiat')
                ->sort()
                ->filter(Input::make()),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($keluarga) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Anggota')
                                ->icon('monitor')
                                ->route('platform.keluargas.anggotas',$keluarga->id),

                            Link::make(__('Edit'))
                                ->route('platform.keluargas.edit',$keluarga->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->method('remove', [
                                    'id' => $keluarga->id,
                                ]),
                        ]);
                }),
        ];
    }
}
