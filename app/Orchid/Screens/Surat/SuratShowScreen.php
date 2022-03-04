<?php

namespace App\Orchid\Screens\Surat;

use App\Models\Surat;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class SuratShowScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Tampilan Surat';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Surat $surat): array
    {
        return [
            'surat' => $surat
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
            Button::make('Kembali')
                ->icon('action-undo')
                ->method('back')
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
            Layout::view('surat.show')
        ];
    }

    public function back(){


        return redirect()->route('platform.surat-masuks');
    }
}
