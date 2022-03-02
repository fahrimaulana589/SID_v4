<?php

namespace App\Orchid\Screens\Perangkat;

use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use App\Models\PerangkatDesa;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Perangkat\PerangkatEditLayout;

class PerangkatEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Create Perangkat';

    public $permission = 'platform.systems.perangkat.edit';

    public $exist = false;

    /**
     * Query perangkat.
     *
     * @return array
     */
    public function query(PerangkatDesa $perangkatDesa): array
    {
        $this->exist = $perangkatDesa->exists;

        $this->name = !$this->exist ? 'Create Perangkat' : "Edit Perangkat";

        return [
            'perangkat' => $perangkatDesa
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

            Button::make('Hapus')
                ->icon('trash')
                ->confirm(__('Once the account is deleted, all of its resources and perangkat will be permanently deleted. Before deleting your account, please download any perangkat or information that you wish to retain.'))
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
            Layout::block(PerangkatEditLayout::class)
                ->title('Perangkat Desa')
                ->description('Silahkan masukan perangkat')
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
        $perangkat = $request->validate(
            [
                'perangkat.name' => [
                    'required'
                ],
                'perangkat.jabatan' => [
                    'required'
                ],
                'perangkat.persingkat_jabatan' => [
                    'required'
                ],
            ]
        );

        PerangkatDesa::create($perangkat['perangkat']);

        Toast::info("Saimpan Data Berhasil");

        return redirect()->route('platform.perangkats');
    }

    public function edit(PerangkatDesa $perangkatDesa,Request $request){
        $perangkat = $request->validate(
            [
                'perangkat.name' => [
                    'required'
                ],
                'perangkat.jabatan' => [
                    'required'
                ],
                'perangkat.persingkat_jabatan' => [
                    'required'
                ],
            ]
        );

        $perangkatDesa->fill($perangkat['perangkat'])->save();

        Toast::info("Edit Data Berhasil");

    }

    public function remove(PerangkatDesa $perangkatDesa){

        $perangkatDesa->delete();

        Toast::info("Hapus Data Berhasil");

        return redirect()->route('platform.perangkats');
    }
}
