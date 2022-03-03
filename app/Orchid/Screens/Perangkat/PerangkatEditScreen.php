<?php

namespace App\Orchid\Screens\Perangkat;

use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use App\Models\PerangkatDesa;
use Orchid\Screen\Actions\Link;
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
    public $name = 'Buat Perangkat';

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

        $this->name = !$this->exist ? 'Buat Perangkat' : "Edit Perangkat";

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

            Link::make('Kembali')
                ->icon('action-undo')
                ->route('platform.perangkats')
                ->canSee(true),

            Button::make('Hapus')
                ->icon('trash')
                ->confirm(
                    'Apakah anda akan menghapus data ini'
                )
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
                ->description('Silahkan masukan data perangkat')
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
                    'alpha',
                    'required'
                ],
                'perangkat.jabatan' => [
                    'alpha',
                    'required',
                    'unique:perangkat_desas,jabatan'
                ],
                'perangkat.persingkat_jabatan' => [
                    'alpha',
                    'required'
                ],
            ]
        );

        PerangkatDesa::create($perangkat['perangkat']);

        Toast::info("Simpan Data Berhasil");

        return redirect()->route('platform.perangkats');
    }

    public function edit(PerangkatDesa $perangkatDesa,Request $request){
        $perangkat = $request->validate(
            [
                'perangkat.name' => [
                    'alpha',
                    'required'
                ],
                'perangkat.jabatan' => [
                    'alpha',
                    'required',
                    'unique:perangkat_desas,jabatan,'.$perangkatDesa->id
                ],
                'perangkat.persingkat_jabatan' => [
                    'alpha',
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
