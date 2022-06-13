<?php

namespace App\Orchid\Screens\Warga;

use App\Models\SuratKeluar;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PelayananShowScreen extends Screen
{
    public SuratKeluar $suratKeluar;
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'PelayananShowScreen';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(SuratKeluar $pelayanan): array
    {
        $this->suratKeluar = $pelayanan;
        $this->name = $pelayanan->title;
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make("Buat")
                ->icon("plus")
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::view("pelayanan.syarat",["pelayanan"=>$this->suratKeluar])
        ];
    }
}
