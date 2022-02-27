<?php

namespace App\Orchid\Layouts\Agenda;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;

class DataAgendaListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'data_agendas';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name','Nama')
                ->sort()
                ->filter(Input::class),
            TD::make('place_of_birth','Tempat lahir')
                ->sort()
                ->filter(Input::class),
            TD::make('date_of_birth','Tanggal lahir')
                ->sort()
                ->filter(Input::class),
            TD::make('address','Alamat')
                ->sort()
                ->filter(Input::class),
            TD::make('necessity','Keperluan')
                ->sort()
                ->filter(Input::class),
            TD::make('Action')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($data_agenda){
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make('Lihat')
                                ->modal('data-'.$data_agenda->id)
                                ->icon('full-screen'),

                            Link::make(__('Edit'))
                                ->icon('pencil')
                                ->route('platform.agendas.edit.data',[$data_agenda->agenda,$data_agenda]),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->method('remove',[
                                    'id' => $data_agenda->id,
                                ]),
                        ]);
                }),

        ];
    }
}
