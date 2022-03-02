<?php

namespace App\Orchid\Screens\Surat;

use mysqli;
use Orchid\Screen\Screen;
use App\Models\SuratKeluar;
use Orchid\Attachment\File;
use App\Models\AtributeData;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Schema;
use App\Orchid\Layouts\Surat\SuratKeluarEditLayout;
use Illuminate\Http\Client\Request as ClientRequest;

use function PHPUnit\Framework\returnSelf;

class SuratKeluarEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Tambah Surat Keluar';

    public $permission = 'platform.systems.surat-keluar.edit';

    public $exist = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(SuratKeluar $suratKeluar): array
    {

        $this->exist = $suratKeluar->exists;

        $data = $suratKeluar->atribute;

        $this->name = !$this->exist ? 'Tambah Surat Keluar' : 'Edit Surat Keluar';

        return [
            'surat-keluar' =>$suratKeluar,
            'exist' => $this->exist,
            'data_atribute' => AtributeData::all()
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


            Link::make('Data')
                ->icon('info')
                ->route('platform.datas'),

            Button::make('Hapus')
                ->icon('check')
                ->method('remove')
                ->canSee($this->exist),

            Button::make('Simpan')
                ->icon('check')
                ->method('save')
                ->canSee(!$this->exist),

            Button::make('Simpan')
                ->icon('check')
                ->method('edit')
                ->canSee($this->exist),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {

        $data = [
            'penduduks' => $this->Penduduk(),
            'surats' => $this->surat()
        ];

        return [
            Layout::view('components.data',$data),
            Layout::block(SuratKeluarEditLayout::class)
                ->title('Surat Masuk')
                ->description('Silahkan masukan data surat')
                ->commands(
                    Button::make('Simpan')
                    ->icon('check')
                    ->method('edit')
                    ->canSee($this->exist),
                ),
        ];
    }

    public function save(Request $request){

        $datas_surat = AtributeData::all();

        $file = $request->validate(
            [
                'surat-keluar.newtemplate' => [
                    'mimes:docx'
                ],
            ]
        );

        $data = $request->validate(
            [
                'surat-keluar.title' =>[
                    'required'
                ],
                'surat-keluar.description' => [
                    'required'
                ],
                'surat-keluar.no_surat' => [
                    'required'
                ],
                'surat-keluar.atribute.data.*' => [

                ],
                'surat-keluar.id_agenda' => [

                ],
            ]
        );

        $data['surat-keluar']['atribute']['data'] = collect($data['surat-keluar']['atribute']['data'])
        ->map(function($data,$key) use ($datas_surat){

            return[
                'key' => $data,
                'type' => $datas_surat->where('key','=',$data)->first()->type
            ];
        })->toArray();

        $data['surat-keluar']['atribute'] = json_encode($data['surat-keluar']['atribute']);

        $surat = SuratKeluar::create($data['surat-keluar']);

        $file = new File(group:"doct",file:$request->file('surat-keluar.newtemplate'));

        $attachment = $file->load();

        $surat->attachment()->save($attachment);

        Toast::info('Surat Keluar berhasil disimpan');

        return redirect()->route('platform.surat-keluars.edit',$surat->id);
    }

    public function edit(SuratKeluar $suratKeluar,Request $request){
        $datas_surat = AtributeData::all();

        $file = $request->validate(
            [
                'surat-keluar.new_template' => [
                    'mimes:docx'
                ],
            ]
        );

        $data = $request->validate(
            [
                'surat-keluar.title' =>[
                    'required'
                ],
                'surat-keluar.description' => [
                    'required'
                ],
                'surat-keluar.no_surat' => [
                    'required'
                ],
                'surat-keluar.atribute.data.*' => [

                ],
                'surat-keluar.id_agenda' => [

                ],
            ]
        );


        $data['surat-keluar']['atribute']['data'] = collect($data['surat-keluar']['atribute']['data'])
        ->map(function($data,$key) use ($datas_surat){

            return[
                'key' => $data,
                'type' => $datas_surat->where('key','=',$data)->first()->type
            ];
        })->toArray();

        $data['surat-keluar']['atribute'] = json_encode($data['surat-keluar']['atribute']);

        $suratKeluar->fill($data['surat-keluar'])->save();

        if(count($file) != 0){

            $file = new File(group:"doct",file:$request->file('surat-keluar.new_template'));

            $attachment = $file->load();

            $suratKeluar->attachment('doct')->delete();

            $suratKeluar->attachment()->save($attachment);
        }

        Toast::info('Suarat berhasil di simpan');
    }

    public function remove(SuratKeluar $suratKeluar,Request $request){
        $suratKeluar->delete();

        Toast::info('Surat berhasil di hapus');

        return redirect()->route('platform.surat-keluars');
    }

    public function Penduduk(){
        $penduduk_table = Schema::getColumnListing('penduduks');

        $penduduk_table =   collect($penduduk_table)
                            ->filter(function ($data) {
                                return
                                $data != 'id' &&
                                $data != 'created_at' &&
                                $data != 'updated_at' &&
                                $data != 'id_keluarga' &&
                                $data != 'status_keluarga' &&
                                $data != 'name_ayah' &&
                                $data != 'name_ibu' && true;
                            })
                            ->map(function ($data,$key){
                                $title = [
                                    "NIK",
                                    "id_keluarga",
                                    "status_keluarga",
                                    "name_ayah",
                                    "name_ibu",
                                    "Nama",
                                    "Tempat_lahir",
                                    "Tanggal_lahir",
                                    "Jenis_kelamin",
                                    "Golongan_darah",
                                    "Alamat",
                                    "Rt",
                                    "Rt",
                                    "Kelurahan_desa",
                                    "Kecamatan",
                                    "Agama",
                                    "Status_perkawinan",
                                    "Pekerjaan",
                                    "Kewerganegaraan",
                                    "Pendidikan"
                                ];

                                return [
                                    'title' => $title[$key-1],
                                    'key' => $data
                                ];
                            });



        return $penduduk_table;
    }

    public function surat() : array{
        $datas_surat = [
            [
                'title' => 'No_surat',
                'key' => 'no_surat',
            ],
            [
                'title' => 'Tanggal_surat',
                'key' => 'tanggal_surat',
            ],
            [
                'title' => 'Atas_nama',
                'key' => 'name',
            ],
            [
                'title' => 'Jabatan_atas_nama',
                'key' => 'jabatan',
            ],
            [
                'title' => 'Singkatan_jabatan',
                'key' => 'persingkat_jabatan',
            ],
        ];

        return $datas_surat;
    }

}
