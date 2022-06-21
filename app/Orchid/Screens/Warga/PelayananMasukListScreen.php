<?php

namespace App\Orchid\Screens\Warga;

use App\Models\Pelayanan;
use App\Orchid\Layouts\Warga\PelayananMasukListLayout;
use Orchid\Screen\Screen;

class PelayananMasukListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Pelayanan masuk';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            "pelayanan_masuk" => Pelayanan::filters()
                ->defaultSort('id', 'desc')
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
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            PelayananMasukListLayout::class,
        ];
    }
}
