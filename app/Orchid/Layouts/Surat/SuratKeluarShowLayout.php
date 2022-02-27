<?php

namespace App\Orchid\Layouts\Surat;

use Carbon\Carbon;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class SuratKeluarShowLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'datas';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('no_surat','No Surat')
                ->sort()
                ->filter(
                    Input::class
                ),

            TD::make('tanggal_surat','Tanggal Surat')
                ->sort()
                ->filter(
                    Input::class
                )
                ->render(function($data){
                    return $data->getFullDate();
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($data) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.surat-keluars.datas.edit',[$data->suratKeluar->id,$data->id])
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->method('remove', [
                                    'id' => $data->id,
                                ]),
                        ]);
                }),

        ];
    }
}
