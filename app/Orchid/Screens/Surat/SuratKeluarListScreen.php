<?php

namespace App\Orchid\Screens\Surat;

use Orchid\Screen\Screen;
use App\Models\SuratKeluar;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Surat\SuratKeluarListLayout;

class SuratKeluarListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Data Pelayanan Surat';

    public $description = 'Data pelayanan surat';

    public $permission = 'platform.systems.surat';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'surat-keluars' => SuratKeluar::filters()
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
                ->route('platform.surat-keluars.create')
        ];
    }

    /**
     * Views.
     *pleuar
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            SuratKeluarListLayout::class
        ];
    }

    public function remove(SuratKeluar $suratKeluar){

        $suratKeluar->delete();

        Toast::info('Surat berhasil di hapus');
    }
}
