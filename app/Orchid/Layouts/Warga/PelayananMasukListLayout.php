<?php

namespace App\Orchid\Layouts\Warga;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PelayananMasukListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'pelayanan_masuk';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('nik_penduduks',"Nama")
                ->sort()
                ->filter(
                    Input::class
                )
                ->render(function ($value){
                    return $value->penduduk->name;
                }),
            TD::make('keperluan',"Keperluan")
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('jenis_surat',"Jenis Surat")
                ->sort()
                ->filter(
                    Input::class
                )->render(function ($value){
                    return $value->surat->title;
                }),

            TD::make('status',"Status")
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($pelayan_masuk) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.pelayanan.masuk.edit',$pelayan_masuk->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm('Apakah anda akan menghapus data ini')
                                ->method('remove', [
                                    'id' => $pelayan_masuk->id,
                                ]),
                        ]);
                }),
        ];
    }
}
