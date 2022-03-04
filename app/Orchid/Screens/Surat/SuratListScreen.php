<?php

namespace App\Orchid\Screens\Surat;

use App\Models\Surat;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Auth;
use App\Orchid\Layouts\Surat\SuratListLayout;

class SuratListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Daftar Surat Masuk Desa';

    public $description = 'Daftar surat masuk desa karanganyar';

    public $permission = 'platform.systems.surat';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'surat_masuks' => Surat::filters()
                                ->defaultSort('id','desc')
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
                ->route('platform.surat-masuks.create')
                ->canSee(Auth::user()->hasAccess('platform.systems.surat.edit'))
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
            SuratListLayout::class
        ];
    }

    public function remove(Surat $surat){
        $surat->attachment()->delete();
        $surat->delete();

        Toast::info('Penduduk berhasil dihapus');
    }
}
