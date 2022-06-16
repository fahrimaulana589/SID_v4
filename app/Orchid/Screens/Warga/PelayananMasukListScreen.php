<?php

namespace App\Orchid\Screens\Warga;

use Orchid\Screen\Screen;

class PelayananMasukListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'PelayananMasukListScreen';

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
        return [];
    }
}
