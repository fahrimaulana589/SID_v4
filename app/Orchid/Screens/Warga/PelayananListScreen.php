<?php

namespace App\Orchid\Screens\Warga;

use App\Models\SuratKeluar;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PelayananListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Pelayanan';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $data = SuratKeluar::all();

        return [
            Layout::view("pelayanan.show",["pelayanan" => $data])
        ];
    }
}
