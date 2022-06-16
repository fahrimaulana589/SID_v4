<?php

namespace App\Orchid\Screens\Surat;

use App\Orchid\Layouts\User\SuratKeluarEdit2Layout;
use mysqli;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use App\Models\SuratKeluar;
use Orchid\Attachment\File;
use App\Models\AtributeData;
use App\Models\SuratKeluarData;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Schema;
use function PHPUnit\Framework\returnSelf;

use App\Orchid\Layouts\Surat\SuratKeluarEditLayout;
use Illuminate\Http\Client\Request as ClientRequest;

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
    public function query(SuratKeluar $suratKeluar,SuratKeluarData $suratKeluarData, Request $request): array
    {

        session(['url_data' => '' . $request->url()]);

        $this->exist = $suratKeluar->exists;

        $data = $suratKeluar->atribute;

        $this->name = !$this->exist ? 'Tambah Pelayanan Surat' : 'Edit Pelayanan Surat';

        return [
            'surat-keluar' => $suratKeluar,
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

            Link::make(__('Kembali'))
                ->icon('action-undo')
                ->route('platform.surat-keluars')
                ->canSee(true),

            Link::make('Data')
                ->icon('info')
                ->route('platform.datas'),

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
            Layout::view('components.data', $data),
            Layout::block(SuratKeluarEditLayout::class)
                ->title('Pelayanan Surat')
                ->description('Silahkan masukan data surat')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('edit')
                        ->canSee($this->exist),
                ),
            SuratKeluarEdit2Layout::class
        ];
    }

    public function save(Request $request)
    {

        $datas_surat = AtributeData::all();

        $file = $request->validate(
            [
                'surat-keluar.newtemplate' => [
                    'mimes:doc,docx',
                    'required',
                ],
            ]
        );

        $data = $request->validate(
            [
                'surat-keluar.title' => [
                    'required',
                    'regex:/^[a-zA-Z0-9\s_().,]+$/',
                    'unique:surat_keluars,title',
                ],
                'surat-keluar.description' => [
                    'regex:/^[a-zA-Z0-9\s_().,]+$/',
                    'required'
                ],
                'surat-keluar.syarat' => [
                    'required'
                ],
                'surat-keluar.no_surat' => [
                    'numeric',
                    'required',
                    'unique:surat_keluars,no_surat',
                ],
                'surat-keluar.atribute.data.*' => [
                    'regex:/^[a-zA-Z0-9\s_().,]+$/',
                    'required'
                ],
                'surat-keluar.id_agenda' => [
                    'numeric',
                    'required'
                ],
            ]
        );

        $atribute = array_key_exists("atribute", $data['surat-keluar']);

        if ($atribute) {
            $data['surat-keluar']['atribute']['data'] = collect($data['surat-keluar']['atribute']['data'])
                ->map(function ($data, $key) use ($datas_surat) {

                    return [
                        'key' => $data,
                        'type' => $datas_surat->where('key', '=', $data)->first()->type
                    ];
                })->toArray();
        } else {
            $data['surat-keluar']['atribute']['data'] = [];
        }

        $data['surat-keluar']['atribute'] = json_encode($data['surat-keluar']['atribute']);

        $surat = SuratKeluar::create($data['surat-keluar']);

        $file = new File($request->file('surat-keluar.newtemplate'), null, "doct");

        $attachment = $file->load();

        $surat->attachment()->save($attachment);

        Toast::info('Simpan Data Berhasil');

        return redirect()->route('platform.surat-keluars.edit', $surat->id);
    }

    public function edit(SuratKeluar $suratKeluar, Request $request)
    {
        $datas_surat = AtributeData::all();

        $file = $request->validate(
            [
                'surat-keluar.newtemplate' => [
                    'mimes:doc,docx'
                ],
            ]
        );

        $data = $request->validate(
            [
                'surat-keluar.title' => [
                    'required',
                    'regex:/^[a-zA-Z0-9\s_().,]+$/',
                    'unique:surat_keluars,title,' . $suratKeluar->id,
                ],
                'surat-keluar.description' => [
                    'regex:/^[a-zA-Z0-9\s_().,]+$/',
                    'required'
                ],
                'surat-keluar.syarat' => [
                    'required'
                ],
                'surat-keluar.no_surat' => [
                    'numeric',
                    'required',
                    'unique:surat_keluars,no_surat,' . $suratKeluar->id,
                ],
                'surat-keluar.atribute.data.*' => [
                    'regex:/^[a-zA-Z0-9\s_().,]+$/',
                    'required'
                ],
                'surat-keluar.id_agenda' => [
                    'numeric',
                    'required'
                ],
            ]
        );


        $atribute = array_key_exists("atribute", $data['surat-keluar']);

        if ($atribute) {

            $data['surat-keluar']['atribute']['data'] = collect($data['surat-keluar']['atribute']['data'])
                ->map(function ($data, $key) use ($datas_surat) {

                    return [
                        'key' => $data,
                        'type' => $datas_surat->where('key', '=', $data)->first()->type
                    ];
                })->toArray();
        } else {

            $data['surat-keluar']['atribute']['data'] = [];
        }

        $data['surat-keluar']['atribute'] = json_encode($data['surat-keluar']['atribute']);

        $suratKeluar->fill($data['surat-keluar'])->save();

        if (count($file) != 0) {

            $file = new File($request->file('surat-keluar.newtemplate'), null, "doct");

            $attachment = $file->load();

            $suratKeluar->attachment('doct')->delete();

            $suratKeluar->attachment()->save($attachment);

        }

        Toast::info('Edit Data Berhasil');
    }

    public function remove(SuratKeluar $suratKeluar, Request $request)
    {
        $suratKeluar->delete();

        Toast::info('Hapus Data berhasil');

        return redirect()->route('platform.surat-keluars');
    }

    public function Penduduk()
    {
        $penduduk_table = Schema::getColumnListing('penduduks');
        $penduduk_table = collect($penduduk_table)
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
            ->map(function ($data, $key) {
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
                    'title' => $title[$key - 1],
                    'key' => $data
                ];
            });


        return $penduduk_table;
    }

    public function surat(): array
    {
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
