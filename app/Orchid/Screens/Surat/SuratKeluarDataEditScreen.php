<?php

namespace App\Orchid\Screens\Surat;

use Orchid\Screen\Screen;
use App\Models\SuratKeluar;
use App\Models\AtributeData;
use Illuminate\Http\Request;
use App\Models\SuratKeluarData;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast as FacadesToast;
use App\Orchid\Layouts\Surat\SuratKeluarEditLayout;
use App\Orchid\Layouts\Surat\SuratKeluarDataEditLayout;

class SuratKeluarDataEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'SuratKeluarDataEditScreen';

    public $suratKeluar;

    public $exist = false;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(SuratKeluar $suratKeluar,SuratKeluarData $surat_data_keluar): array
    {

        $this->suratKeluar = $suratKeluar;
        $this->name = $suratKeluar->title;
        $this->exist = $surat_data_keluar->exists;

        if($this->exist){
            $surat_data_keluar = $suratKeluar->datas()->findOrFail($surat_data_keluar->id);
        }

        return [
            'exist' =>  $this->exist,
            'surat_keluar' => $suratKeluar,
            'surat_keluar_data' => $surat_data_keluar,
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
            Layout::block(SuratKeluarDataEditLayout::class)
                ->title('Data Surat')
                ->description('Masukan data surat')
                ->commands(
                    Button::make('Simpan')
                        ->icon('check')
                        ->method('edit')
                        ->canSee($this->exist)
                )
        ];
    }

    public function save(SuratKeluar $suratKeluar,Request $request){


        $data = $request->validate(
            [
                'surat_keluar_data.no_surat' => [
                    'required'
                ],
                'surat_keluar_data.tanggal_surat' => [
                    'required'
                ],
                'surat_keluar_data.id_penduduk' => [
                    'required'
                ],
                'surat_keluar_data.id_perangkat_desa' => [
                    'required'
                ],
                'surat_keluar_data.atribute.data' => [
                    'required'
                ],

            ]
        );

        $datas_surat = AtributeData::all();

        $data['surat_keluar_data']['atribute']['data'] = collect($data['surat_keluar_data']['atribute']['data'])
        ->map(function($data,$key) use ($datas_surat){

            return[
                'key' => $key,
                'type' => $datas_surat->where('key','=',$key)->first()->type,
                'value' => $data
            ];
        })->toArray();

        $data['surat_keluar_data']['atribute'] = json_encode($data['surat_keluar_data']['atribute']);

        $data['surat_keluar_data']['id_surat_keluar'] = $suratKeluar->id;

        SuratKeluarData::create($data['surat_keluar_data']);

        Toast::info('Data berhasil di simpan');

        return redirect()->route('platform.surat-keluars.show',$suratKeluar->id);
    }

    public function edit(SuratKeluar $suratKeluar,SuratKeluarData $surat_data_keluar,Request $request){

        $data = $request->validate(
            [
                'surat_keluar_data.no_surat' => [
                    'required'
                ],
                'surat_keluar_data.tanggal_surat' => [
                    'required'
                ],
                'surat_keluar_data.id_penduduk' => [
                    'required'
                ],
                'surat_keluar_data.id_perangkat_desa' => [
                    'required'
                ],
                'surat_keluar_data.atribute.data' => [
                    'required'
                ],

            ]
        );

        $datas_surat = AtributeData::all();

        $data['surat_keluar_data']['atribute']['data'] = collect($data['surat_keluar_data']['atribute']['data'])
        ->map(function($data,$key) use ($datas_surat){

            return[
                'key' => $key,
                'type' => $datas_surat->where('key','=',$key)->first()->type,
                'value' => $data
            ];
        })->toArray();

        $data['surat_keluar_data']['atribute'] = json_encode($data['surat_keluar_data']['atribute']);

        $data['surat_keluar_data']['id_surat_keluar'] = $suratKeluar->id;

        $surat_data_keluar->fill($data['surat_keluar_data'])->save();

        Toast::info('Data berhasil di simpan');

    }
    public function remove(SuratKeluar $suratKeluar,SuratKeluarData $surat_data_keluar,Request $request){
        $surat_data_keluar->delete();

        Toast::info('Data berhasil di hapus');

        return redirect()->route('platform.surat-keluars.show',$suratKeluar->id);
    }

}
