<?php

namespace App\Orchid\Screens\Perangkat;

use Orchid\Screen\Screen;
use App\Models\PerangkatDesa;
use App\Orchid\Layouts\Perangkat\PerangkatListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;

class PerangkatListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Data Perangkat Desa';

    public $description = 'Data perangkat desa karanganyar';

    public $permission = 'platform.systems.perangkat';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {

        $perangkat = PerangkatDesa::filters()
        ->defaultSort('id', 'desc')
        ->paginate(10);

        return [
            'perangkats' => $perangkat
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
                ->route('platform.perangkats.create')
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
            PerangkatListLayout::class
        ];
    }

    public function remove(PerangkatDesa $data){
        $data->delete();

        Toast::info("Hapus Data Berhasil");
    }
}
