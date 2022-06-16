<?php

namespace App\Orchid\Layouts\Warga;

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
            TD::make('nik_penduduks',"NIK")
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('keperluan',"Keperluan")
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('keperluan',"Jenis Surat")
                ->sort()
                ->filter(
                    Input::class
                )->render(function ($value){
                    return $value->surat->title;
                }),
        ];
    }
}
