<?php

namespace App\Orchid\Layouts\Surat;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class SuratListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'surat_masuks';

    /**
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
            TD::make('pengirim','Pengirim')
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('file','File')
                ->render(function ($surat_masuk){

                    if($surat_masuk->attachment()->first() != null){
                        $url = $surat_masuk->attachment()->first()->url();

                        return Link::make(''.$surat_masuk->file)
                                    ->route('platform.surat-masuks.show',$surat_masuk->id)
                                    ->icon('eye');
                    }
                    else{
                        return Link::make('Tidak ada')
                                    ->icon('eye');
                    }
                }

                ),
            TD::make(__('Actions'))
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(function ($surat_masuk) {
                return DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.surat-masuks.edit',$surat_masuk->id)
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'id' => $surat_masuk->id,
                            ]),
                    ]);
            }),
        ];
    }
}
