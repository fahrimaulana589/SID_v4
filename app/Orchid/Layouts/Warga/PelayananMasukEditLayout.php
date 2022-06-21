<?php

namespace App\Orchid\Layouts\Warga;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class PelayananMasukEditLayout extends Rows
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
             Select::make("pelayanan.status")
                 ->title("Status")
                 ->options([
                     'masuk'   => 'Masuk',
                     'diproses' => 'Diproses',
                     'ditolak' => 'Ditolak',
                     'diterima' => 'Diterima',
                 ]),
            Input::make("pelayanan.no_surat")
                ->title("No surat")
                ->placeholder("Masukan jika surat telah di buat")
        ];
    }
}
