<?php

namespace App\Orchid\Screens\Keluarga;

use App\Models\Keluarga;
use App\Models\Penduduk;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Keluarga\KeluargaEditLayout;

class KeluargaEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit Keluarga';

    public $permission = 'platform.systems.keluarga.edit';

    private $exist = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Keluarga $keluarga): array
    {

        $this->exist = $keluarga->exists;

        if(!$this->exist){
            $this->name = 'Buat Keluarga';
        }

        return [
            'keluarga' => $keluarga,
            'kepala' => $keluarga->kepala,
            'permission'  => $keluarga->getStatusPermission()
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
            ->route('platform.keluargas')
            ->canSee(true),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm('Apakah anda akan menghapus data ini')
                ->method('remove')
                ->canSee($this->exist),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
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
            Layout::block(KeluargaEditLayout::class)
                ->title('Keluarga')
                ->description('Silahkan masukan data keluarga')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('save')
                )
        ];
    }

    public function save(Keluarga $keluarga,Request $request){

        $data_kepala = $request->validate([
            'kepala.name_ayah' => [
                'regex:/^[\pL\s\-]+$/u',
                'required'
            ],
            'kepala.name_ibu' => [
                'regex:/^[\pL\s\-]+$/u',
                'required'
            ],
        ]);

        $data = $request->validate(
            [
                'keluarga.KK' => [
                    'numeric',
                    'unique:keluargas,KK,'.$keluarga->id,
                    'required'
                ],
                'keluarga.id_kepala_keluarga' => [
                    'numeric',
                    'unique:keluargas,id_kepala_keluarga,'.$keluarga->id,
                    'required'
                ],
                'keluarga.address' => [
                    'regex:/[a-zA-Z0-9\s]+/',
                    'required'
                ],
                'keluarga.rt' => [
                    'numeric',
                    'required'
                ],
                'keluarga.rw' => [
                    'numeric',
                    'required'
                ],
                'keluarga.kode_pos' => [
                    'numeric',
                    'required'
                ],
                'keluarga.kelurahan_desa' => [
                    'regex:/^[\pL\s\-]+$/u',
                    'required'
                ],
                'keluarga.kecamatan' => [
                    'regex:/^[\pL\s\-]+$/u',
                    'required'
                ],
                'keluarga.kabupaten_kota' => [
                    'regex:/^[\pL\s\-]+$/u',
                    'required'
                ],
                'keluarga.provinsi' => [
                    'regex:/^[\pL\s\-]+$/u',
                    'required'
                ],

            ]
        );

        $data['id'] = null;

        $ket = "Simpan";

        if($keluarga->exists){
            $data['id'] = $keluarga->id;
            $ket = "Edit";
        }

        $data_keluarga = Keluarga::updateOrCreate(['id' => $data['id']],$data['keluarga']);

        $kepala = Penduduk::find($data['keluarga']['id_kepala_keluarga']);

        $kepala->id_keluarga = $data_keluarga->id;
        $kepala->status_keluarga = "Kepala Rumah Tangga";
        $kepala->name_ayah = $data_kepala['kepala']['name_ayah'];
        $kepala->name_ibu = $data_kepala['kepala']['name_ayah'];

        $kepala->save();

        Toast::info($ket.' Data Berhasil');

        if(!$keluarga->exists){
            return redirect()->route("platform.keluargas");
        }

    }

    public function remove(Keluarga $keluarga){
        $keluarga->delete();

        Toast::info('Hapus Data Berhasil');

        return redirect()->route("platform.keluargas");

    }


}
