<?php

namespace App\Orchid\Screens\Data;

use Orchid\Screen\Screen;
use App\Models\AtributeData;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Data\DataListLayout;
use Illuminate\Http\Request;

class DataListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Data Data';

    public $permission = 'platform.systems.data';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): array
    {

       $data = AtributeData::filters()
            ->defaultSort('id', 'desc')
            ->paginate(10);

        return [
            'datas' => $data
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

            Link::make(__('Kembali'))
                ->icon('action-undo')
                ->href("".session('url_data'))
                ->canSee(true),

            Link::make('Tambah')
                ->icon('plus')
                ->route('platform.datas.create')
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
            DataListLayout::class
        ];
    }

    public function remove(AtributeData $atributeData){
        $atributeData->delete();

        Toast::info("Hapus Data Berhasil");

    }
}
