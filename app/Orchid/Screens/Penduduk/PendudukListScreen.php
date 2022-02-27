<?php

namespace App\Orchid\Screens\Penduduk;

use App\Models\Penduduk;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Auth;
use App\Orchid\Layouts\Penduduk\PendudukListLayout;

class PendudukListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Penduduk Desa';

    public $description = 'Data penduduk desa karanganyar';

    public $permission = 'platform.systems.penduduk';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {

        $penduduks = Penduduk::filters()
            ->defaultSort('id','desc')
            ->paginate(10);

        return [
            'penduduks' => $penduduks
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
                ->route('platform.penduduks.create')
                ->canSee(Auth::user()->hasAccess('platform.systems.penduduk.edit')),
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
            PendudukListLayout::class
        ];
    }

    public function remove(Penduduk $penduduk){

        $penduduk->delete();

        Toast::info('Penduduk berhasil dihapus');

    }
}
