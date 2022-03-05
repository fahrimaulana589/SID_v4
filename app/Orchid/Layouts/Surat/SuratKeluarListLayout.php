<?php

namespace App\Orchid\Layouts\Surat;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class SuratKeluarListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'surat-keluars';

    /*
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title','Judul')
                ->sort()
                ->filter(
                    Input::class
                ),

            TD::make('description','Deskripsi')
                ->sort()
                ->filter(
                    Input::class
                ),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($surat_keluar) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Lihat')
                                ->route('platform.surat-keluars.show',$surat_keluar->id)
                                ->icon('monitor'),

                            Link::make(__('Edit'))
                                ->route('platform.surat-keluars.edit',$surat_keluar->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm('Apakah anda akan menghapus data ini')
                                ->method('remove', [
                                    'id' => $surat_keluar->id,
                                ]),
                        ]);
                }),

        ];
    }
}
