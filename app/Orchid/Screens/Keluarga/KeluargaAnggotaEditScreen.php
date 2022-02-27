<?php

namespace App\Orchid\Screens\Keluarga;

use App\Models\Keluarga;
use App\Models\Penduduk;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Keluarga\KeluargaAnggotaEditLayout;

class KeluargaAnggotaEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit Anggota Keluarga';

    public $permission = 'platform.systems.keluarga.edit';

    private $exist = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Keluarga $keluarga,Penduduk $penduduk): array
    {
        $this->exist = $penduduk->exists;

        if(!$this->exist){
            $this->name = 'Edit Anggota Keluarga';
        }

        return [
            'penduduk' => $penduduk,
            'permission'  => $penduduk->getStatusPermission()
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
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
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
            Layout::block(KeluargaAnggotaEditLayout::class)
                ->title("Anggota")
                ->description('Silahkan masukan anggota keluarga')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('save')
                ),
        ];
    }

    public function save(Keluarga $keluarga,Penduduk $penduduk,Request $request){

        $data = $request->validate(
            [
                'penduduk.id' => [
                    'required'
                ],
                'penduduk.status_keluarga' => [
                    'required'
                ],
                'penduduk.name_ayah' => [
                    'required'
                ],
                'penduduk.name_ibu' => [
                    'required'
                ]
            ]
        );

        $data['penduduk']['id_keluarga'] = $keluarga->id;

        $anggota = Penduduk::find($data['penduduk']['id']);
        $anggota->fill($data['penduduk']);
        $anggota->save();

        Toast::info('Anggota berhasil disimpan');

        if(!$penduduk->exists){
            return redirect()->route("platform.keluargas.anggotas",$keluarga->id);
        }

    }

    public function remove(Keluarga $keluarga,Penduduk $anggota){

        $data = [
            'status_keluarga' => null,
            'name_ayah' => null,
            'name_ibu' => null,
            'id_keluarga' => null
        ];

        $anggota->fill($data);
        $anggota->save();

        Toast::info('Data berhasil di hapus');

        return redirect()->route('platform.keluargas.anggotas',$keluarga->id);

    }
}
