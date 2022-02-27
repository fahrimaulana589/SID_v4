<?php

namespace App\Orchid\Screens\Keluarga;

use App\Models\Keluarga;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Auth;
use App\Orchid\Layouts\Keluarga\KeluargaListLayout;

class KeluargaListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Data Keluarga';

    public $description = "Data keluarga desa karanganyar";

    public $permission = 'platform.systems.keluarga';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'keluargas' => Keluarga::filters()
                ->defaultSort('id','desc')
                ->paginate(10)
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
                ->route('platform.keluargas.create')
                ->canSee(Auth::user()->hasAccess('platform.systems.keluarga.edit'))
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
            KeluargaListLayout::class
        ];
    }

    public function remove(Keluarga $keluarga){

        $keluarga->delete();

        Toast::info('Agenda Telah Di Hapus');

    }
}
