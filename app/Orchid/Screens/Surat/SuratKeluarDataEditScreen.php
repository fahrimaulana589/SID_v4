<?php

namespace App\Orchid\Screens\Surat;

use Orchid\Screen\Screen;
use App\Models\DataAgenda;
use App\Models\SuratKeluar;
use App\Models\AtributeData;
use Illuminate\Http\Request;
use App\Models\SuratKeluarData;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use PhpOffice\PhpWord\TemplateProcessor;
use Orchid\Support\Facades\Toast as FacadesToast;
use App\Orchid\Layouts\Surat\SuratKeluarEditLayout;
use App\Orchid\Layouts\Surat\SuratKeluarDataEditLayout;
use App\Orchid\Layouts\Agenda\DataAgendaKeperluanLayout;

class SuratKeluarDataEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'SuratKeluarDataEditScreen';

    public $suratKeluar;

    public $dataAgenda;

    public $surat_data_keluar;

    public $exist = false;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(SuratKeluar $suratKeluar,SuratKeluarData $surat_data_keluar): array
    {

        $this->suratKeluar = $suratKeluar;
        $this->surat_data_keluar  = $surat_data_keluar;
        $this->name = $suratKeluar->title;
        $this->exist = $surat_data_keluar->exists;

        $this->dataAgenda = $suratKeluar->agenda;

        if($this->exist){
            $this->surat_data_keluar = $suratKeluar->datas()->findOrFail($surat_data_keluar->id);
            $this->dataAgenda = $surat_data_keluar->agendaData;
        }



        return [
            'exist' =>  $this->exist,
            'agenda' => $suratKeluar->agenda,
            'dataAgenda' => $this->dataAgenda,
            'surat_keluar' => $suratKeluar,
            'surat_keluar_data' =>  $this->surat_data_keluar ,
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
                ->route('platform.surat-keluars.show',$this->suratKeluar->id)
                ->canSee(true),

            Button::make('Hapus')
                ->icon('trash')
                ->method('remove')
                ->confirm('Apakah anda akan menghapus data ini')
                ->canSee($this->exist),

            Button::make('Simpan')
                ->icon('check')
                ->method('save')
                ->canSee(!$this->exist),

            Link::make('Download')
                ->icon('check')
                ->route('download',[$this->suratKeluar->id, ($this->exist ? $this->surat_data_keluar->id : 0)])
                ->canSee($this->exist),

            Link::make('Print')
                ->icon('check')
                ->route('print',[$this->suratKeluar->id, ($this->exist ? $this->surat_data_keluar->id : 0)])
                ->canSee($this->exist),

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
                ),
            Layout::block(DataAgendaKeperluanLayout::class)
                ->title('Data Agenda')
                ->description('Silahkan masukan data agenda')
                ->commands(
                    Button::make('Simpan')
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('edit')
                )
        ];
    }

    public function save(SuratKeluar $suratKeluar,Request $request){
        $data = $request->validate(
            [
                'surat_keluar_data.no_surat' => [
                    'unique:data_agendas,no_surat',
                    'required'
                ],
                'surat_keluar_data.tanggal_surat' => [
                    'date',
                    'required'
                ],
                'surat_keluar_data.id_penduduk' => [
                    'numeric',
                    'required'
                ],
                'surat_keluar_data.id_perangkat_desa' => [
                    'numeric',
                    'required'
                ],
                'surat_keluar_data.atribute.data' => [
                    'required'
                ],

            ]
        );

        $dataAgenda = $request->validate(
            [
                'dataAgenda.atribute.data' => [
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

        $dataAgenda['dataAgenda']['atribute']['data'] = collect($dataAgenda['dataAgenda']['atribute']['data'])
        ->map(function($data,$key) use ($datas_surat){

            return[
                'key' => $key,
                'type' => $datas_surat->where('key','=',$key)->first()->type,
                'value' => $data
            ];
        })->toArray();


        $data['surat_keluar_data']['atribute'] = json_encode($data['surat_keluar_data']['atribute']);

        $data['surat_keluar_data']['id_surat_keluar'] = $suratKeluar->id;

        $surat = SuratKeluarData::create($data['surat_keluar_data']);

        $dataAgenda['dataAgenda']['id_penduduk'] = $data['surat_keluar_data']['id_penduduk'];
        $dataAgenda['dataAgenda']['id_agenda'] =  $suratKeluar->agenda->id;
        $dataAgenda['dataAgenda']['no_surat'] = $data['surat_keluar_data']['no_surat'];
        $dataAgenda['dataAgenda']['id_data_surat_keluar'] = $surat->id;
        $dataAgenda['dataAgenda']['atribute'] = json_encode($dataAgenda['dataAgenda']['atribute']);

        DataAgenda::create($dataAgenda['dataAgenda']);

        Toast::info('Simpan Data Berhasil');

        return redirect()->route('platform.surat-keluars.show',$suratKeluar->id);
    }

    public function edit(SuratKeluar $suratKeluar,SuratKeluarData $surat_data_keluar,Request $request){

        $data = $request->validate(
            [
                'surat_keluar_data.no_surat' => [
                    'unique:data_agendas,no_surat,'.$surat_data_keluar->id,
                    'regex:/^\d{1,}\/\d{1,}\/\d{4}$/',
                    'required'
                ],
                'surat_keluar_data.tanggal_surat' => [
                    'date',
                    'required'
                ],
                'surat_keluar_data.id_penduduk' => [
                    'numeric',
                    'required'
                ],
                'surat_keluar_data.id_perangkat_desa' => [
                    'numeric',
                    'required'
                ],
                'surat_keluar_data.atribute.data' => [
                    'required'
                ],

            ]
        );

        $dataAgenda = $request->validate(
            [
                'dataAgenda.atribute.data' => [
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

        $dataAgenda['dataAgenda']['atribute']['data'] = collect($dataAgenda['dataAgenda']['atribute']['data'])
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

        $dataAgenda['dataAgenda']['id_penduduk'] = $data['surat_keluar_data']['id_penduduk'];
        $dataAgenda['dataAgenda']['id_agenda'] =  $suratKeluar->agenda->id;
        $dataAgenda['dataAgenda']['no_surat'] = $data['surat_keluar_data']['no_surat'];
        $dataAgenda['dataAgenda']['id_data_surat_keluar'] = $surat_data_keluar->id;
        $dataAgenda['dataAgenda']['atribute'] = json_encode($dataAgenda['dataAgenda']['atribute']);

        $data = $surat_data_keluar->agendaData->fill($dataAgenda['dataAgenda'])->save();

        Toast::info('Edit Data Berhasil');

    }
    public function remove(SuratKeluar $suratKeluar,SuratKeluarData $surat_data_keluar,Request $request){
        $surat_data_keluar->delete();

        Toast::info('Hapus Data Berhasil');

        return redirect()->route('platform.surat-keluars.show',$suratKeluar->id);
    }

}
