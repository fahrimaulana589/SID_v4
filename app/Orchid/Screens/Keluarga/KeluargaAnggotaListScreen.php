<?php

namespace App\Orchid\Screens\Keluarga;

use Orchid\Screen\TD;
use App\Models\Keluarga;
use App\Models\Penduduk;
use Orchid\Screen\Sight;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Auth;
use App\Orchid\Layouts\Penduduk\PendudukListLayout;
use App\Orchid\Layouts\Keluarga\KeluargaAnggotaListLayout;

class KeluargaAnggotaListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Daftar Anggota Keluarga';

    public $description = 'Daftar anggota keluarga';

    public $permission = 'platform.systems.keluarga';

    public $keluarga;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Keluarga $keluarga): array
    {
        $this->description = "Kepala keluarga : {$keluarga->kepala->name}";
        $this->keluarga = $keluarga;

        return [
            'penduduks' => $keluarga->penduduks()->get()->reverse(),
            'kepala_keluarga' => $keluarga->kepala->name,
            'keluarga' => $keluarga
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

            Link::make('Tambah')
                ->icon('plus')
                ->route('platform.keluargas.anggotas.create',$this->keluarga->id)
                ->canSee(Auth::user()->hasAccess('platform.systems.keluarga.edit')),
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
            Layout::legend('keluarga', [
                Sight::make('KK','No KK'),
                Sight::make('address','Alamat'),
                Sight::make('rt','RT'),
                Sight::make('rw','RW'),
                Sight::make('kode_pos','Kode POS'),
                Sight::make('kelurahan_desa','Kelurahan/Desa'),
                Sight::make('kecamatan','Kecamatan'),
                Sight::make('kabupaten_kota','Kabupaten/Kota'),
                Sight::make('provinsi','Provinsi'),
            ]),
            KeluargaAnggotaListLayout::class,
            Layout::table('penduduks', [
                TD::make('name','Nama'),
                TD::make('status_keluarga','Status keluarga'),
                TD::make('name_ayah','Nama ayah'),
                TD::make('name_ibu','Nama ibu'),
            ])
        ];
    }

    public function remove(Penduduk $anggota){
        $data = [
            'status_keluarga' => null,
            'name_ayah' => null,
            'name_ibu' => null,
            'id_keluarga' => null
        ];

        $anggota->fill($data);
        $anggota->save();

        Toast::info('Data berhasil di hapus');
    }

}
