<?php

namespace App\Orchid\Screens\Surat;

use Orchid\Screen\Screen;
use App\Models\SuratKeluar;
use App\Models\SuratKeluarData;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Surat\SuratKeluarListLayout;
use App\Orchid\Layouts\Surat\SuratKeluarShowLayout;
use App\Orchid\Layouts\Surat\SuratKeluarShowScreen as SuratSuratKeluarShowScreen;

class SuratKeluarShowScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'SuratKeluarShowScreen';

    public $exist;

    public $suratKeluar;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(SuratKeluar $suratKeluar): array
    {

        $this->exist = $suratKeluar->exists;
        $this->suratKeluar = $suratKeluar;
        $this->name = $suratKeluar->title;

        return [
            'surat_keluar' => $suratKeluar,
            'datas' => $suratKeluar->datas()->filters()
            ->defaultSort('id', 'desc')
            ->paginate(10),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Tambah')
                ->icon('plus')
                ->route('platform.surat-keluars.datas.create',[$this->suratKeluar->id])
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
            SuratKeluarShowLayout::class
        ];
    }

    public function remove(SuratKeluarData $surat_data_keluar){
        $surat_data_keluar->delete();

        Toast::info('Data berhasil di hapus');
    }
}
