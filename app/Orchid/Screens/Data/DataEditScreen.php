<?php

namespace App\Orchid\Screens\Data;

use Orchid\Screen\Screen;
use Orchid\Support\Color;
use App\Models\AtributeData;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Data\DataEditLayout;

class DataEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Create Data';

    public $permission = 'platform.systems.data.edit';

    public $exist = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(AtributeData $atributeData): array
    {

        $this->exist = $atributeData->exists;

        $this->name = !$this->exist ? 'Buat Data' : "Edit Data";

        return [
            'data' => $atributeData
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
                ->route('platform.datas')
                ->canSee(true),

            Button::make('Hapus')
                ->icon('trash')
                ->confirm('Apakah anda akan menghapus data ini')
                ->method('remove')
                ->canSee($this->exist),

            Button::make('Simpan')
                ->icon('check')
                ->method('save')
                ->canSee(!$this->exist),

            Button::make('Simpan')
                ->icon('check')
                ->method('edit')
                ->canSee($this->exist)
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
            Layout::block(DataEditLayout::class)
                ->title('Data')
                ->description('Silahkan masukan data')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('edit')
                )
        ];
    }

    public function save(Request $request){
        $data = $request->validate(
            [
                'data.title' => [
                    'required'
                ],
                'data.key' => [
                    'required'
                ],
                'data.type' => [
                    'required'
                ],
            ]
        );

        AtributeData::create($data['data']);

        Toast::info("Simpan Data Berhasil");

        return redirect()->route('platform.datas');
    }

    public function edit(AtributeData $atributeData,Request $request){
        $data = $request->validate(
            [
                'data.title' => [
                    'required'
                ],
                'data.key' => [
                    'required'
                ],
                'data.type' => [
                    'required'
                ],
            ]
        );

        $atributeData->fill($data['data'])->save();

        Toast::info("Edit Data Berhasil");

    }

    public function remove(AtributeData $atributeData){

        $atributeData->delete();

        Toast::info("Hapus Data Berhasil");

        return redirect()->route('platform.datas');
    }


}
