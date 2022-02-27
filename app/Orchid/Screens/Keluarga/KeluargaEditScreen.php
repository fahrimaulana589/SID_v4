<?php

namespace App\Orchid\Screens\Keluarga;

use App\Models\Keluarga;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
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
            $this->name = 'Create Keluarga';
        }

        return [
            'keluarga' => $keluarga,
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

       $data = $request->validate(
            [
                'keluarga.KK' => [
                    'required'
                ],
                'keluarga.id_kepala_keluarga' => [
                    'required'
                ],
                'keluarga.address' => [
                    'required'
                ],
                'keluarga.rt' => [
                    'required'
                ],
                'keluarga.rw' => [
                    'required'
                ],
                'keluarga.kode_pos' => [
                    'required'
                ],
                'keluarga.kelurahan_desa' => [
                    'required'
                ],
                'keluarga.kecamatan' => [
                    'required'
                ],
                'keluarga.kabupaten_kota' => [
                    'required'
                ],
                'keluarga.provinsi' => [
                    'required'
                ],

            ]
        );

        $data['id'] = null;

        if($keluarga->exists){
            $data['id'] = $keluarga->id;
        }

        Keluarga::updateOrCreate(['id' => $data['id']],$data['keluarga']);

        Toast::info('Keluarga berhasil disimpan');

        if(!$keluarga->exists){
            return redirect()->route("platform.keluargas");
        }
    }

    public function remove(Keluarga $keluarga){

        $keluarga->delete();

        Toast::info('Keluarga berhasil dihapus');

        return redirect()->route("platform.keluargas");

    }


}
