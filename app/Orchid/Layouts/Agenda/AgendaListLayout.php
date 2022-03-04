<?php

namespace App\Orchid\Layouts\Agenda;

use Carbon\Carbon;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class AgendaListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'agendas';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title',"Nama")
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('description',"Deskripsi")
                ->width('50%')
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('created_at',"Di buat")
                ->sort()
                ->render(function($agenda){
                    return $agenda->created_at->isoFormat('dddd, D MMMM Y');
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($agenda) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Lihat')
                                ->route('platform.agendas.show',$agenda->id)
                                ->icon('monitor'),

                            Link::make(__('Edit'))
                                ->route('platform.agendas.edit',$agenda->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm('Apakah anda akan menghapus data ini')
                                ->method('remove', [
                                    'id' => $agenda->id,
                                ]),
                        ]);
                }),
        ];
    }
}
