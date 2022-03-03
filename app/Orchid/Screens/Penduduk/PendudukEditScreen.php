<?php

namespace App\Orchid\Screens\Penduduk;

use App\Models\Penduduk;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Penduduk\PendudukEditLayout;

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
            $this->name = 'Buat Penduduk';
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
            Link::make(__('Kembali'))
                ->icon('action-undo')
                ->route('platform.penduduks')
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
                    'numeric',
                    'required',
                    'unique:penduduks,NIK,'.$penduduk->id
                ],
                'penduduk.name' => [
                    'alpha',
                    'required'
                ],
                'penduduk.place_of_birth' => [
                    'alpha',
                    'required'
                ],
                'penduduk.date_of_birth' => [
                    'required',
                    'date',
                    'date_format:Y-m-d',
                    'before:tomorrow',
                ],
                'penduduk.gender' => [
                    'alpha',
                    'in:pria,wanita',
                    'required'
                ],
                'penduduk.blood' => [
                    'alpha',
                    'in:A,B,O,AB',
                    'required'
                ],
                'penduduk.address' => [
                    'alpha_num',
                    'required'
                ],
                'penduduk.rt' => [
                    'numeric',
                    'required'
                ],
                'penduduk.rw' => [
                    'numeric',
                    'required'
                ],
                'penduduk.kelurahan_desa' => [
                    'alpha',
                    'required'
                ],
                'penduduk.kecamatan' => [
                    'alpha',
                    'required'
                ],
                'penduduk.religion' => [
                    'alpha',
                    'in:islam,kristen',
                    'required'
                ],
                'penduduk.status_perkawinan' => [
                    'alpha',
                    Rule::in(['sendiri', 'menikah']),
                    'required'
                ],
                'penduduk.profession' => [
                    'alpha',
                    'required'
                ],
                'penduduk.kewerganegaraan' => [
                    'alpha',
                    'required'
                ],
                'penduduk.education' => [
                    'alpha',
                    'required'
                ],

            ]
        );

        $data['id'] = null;

        if($penduduk->exists){
            $data['id'] = $penduduk->id;
        }

        Penduduk::updateOrCreate(['id' => $data['id']],$data['penduduk']);

        $ket = $penduduk->exists ? 'Edit' : 'Simpan';

        Toast::info($ket.' Data Berhasil');

        if(!$penduduk->exists){
            return redirect()->route("platform.penduduks");
        }
    }

    public function remove(Penduduk $penduduk){

        $penduduk->delete();

        Toast::info('Hapus Data Berhasil');

        return redirect()->route("platform.penduduks");

    }


}
