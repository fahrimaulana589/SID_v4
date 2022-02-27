<?php

namespace App\Orchid\Screens\Penduduk;

use App\Models\Penduduk;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Penduduk\PendudukEditLayout;
use Illuminate\Http\Request;

class PendudukEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit Penduduk';

    public $permission = 'platform.systems.penduduk.edit';

    private $exist = false;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Penduduk $penduduk): array
    {

        $this->exist = $penduduk->exists;

        if(!$this->exist){
            $this->name = 'Create Penduduk';
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
            Layout::block(PendudukEditLayout::class)
                ->title('Penduduk')
                ->description('Silahkan masukan data penduduk')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('save')
                )
        ];
    }

    public function save(Penduduk $penduduk,Request $request){

       $data = $request->validate(
            [
                'penduduk.NIK' => [
                    'required'
                ],
                'penduduk.name' => [
                    'required'
                ],
                'penduduk.place_of_birth' => [
                    'required'
                ],
                'penduduk.date_of_birth' => [
                    'required'
                ],
                'penduduk.gender' => [
                    'required'
                ],
                'penduduk.blood' => [
                    'required'
                ],
                'penduduk.address' => [
                    'required'
                ],
                'penduduk.rt' => [
                    'required'
                ],
                'penduduk.rw' => [
                    'required'
                ],
                'penduduk.kelurahan_desa' => [
                    'required'
                ],
                'penduduk.kecamatan' => [
                    'required'
                ],
                'penduduk.religion' => [
                    'required'
                ],
                'penduduk.status_perkawinan' => [
                    'required'
                ],
                'penduduk.profession' => [
                    'required'
                ],
                'penduduk.kewerganegaraan' => [
                    'required'
                ],
                'penduduk.education' => [
                    'required'
                ],

            ]
        );

        $data['id'] = null;

        if($penduduk->exists){
            $data['id'] = $penduduk->id;
        }

        Penduduk::updateOrCreate(['id' => $data['id']],$data['penduduk']);

        Toast::info('Penduduk berhasil disimpan');

        if(!$penduduk->exists){
            return redirect()->route("platform.penduduks");
        }
    }

    public function remove(Penduduk $penduduk){

        $penduduk->delete();

        Toast::info('Penduduk berhasil dihapus');

        return redirect()->route("platform.penduduks");

    }


}
