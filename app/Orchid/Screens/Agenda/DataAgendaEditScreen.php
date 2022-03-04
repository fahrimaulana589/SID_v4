<?php

namespace App\Orchid\Screens\Agenda;

use App\Models\Agenda;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use App\Models\DataAgenda;
use App\Models\AtributeData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Agenda\AgendaEditLayout;
use App\Orchid\Layouts\Agenda\AgendaDescriptionLayout;
use App\Orchid\Layouts\Agenda\DataAgendaPendudukLayout;
use App\Orchid\Layouts\Agenda\DataAgendaKeperluanLayout;

class DataAgendaEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit Data Agenda';

    public $permission = 'platform.systems.agenda';

    private $exist = false;

    private $agenda;


    /**
     * Query data.
     *
     * @return array
     */
    public function query(Agenda $agenda,DataAgenda $dataAgenda): array
    {
        $this->exist = $dataAgenda->exists;
        $this->agenda = $agenda;

        if(!$this->exist){
            $this->name = 'Buat Data Agenda';
        }

        return [
            'exist' => $this->exist,
            'dataAgenda'       => $dataAgenda,
            'agenda' => $agenda,
            'permission' => $dataAgenda->getStatusPermission(),
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
            ->route('platform.agendas.show',$this->agenda->id)
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
            Layout::block(DataAgendaPendudukLayout::class)
                ->title('Data Agenda')
                ->description('Silah kan masukan data agenda')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('save')
                ),
            Layout::block(DataAgendaKeperluanLayout::class)
                ->title('Data Tambahan')
                ->description('Silahkan masukan data tambahan')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('save')
                )
                ->canSee($this->agenda->atribute != '{"data":[]}')
        ];
    }

    public function save(Agenda $agenda,DataAgenda $dataAgenda,Request $request){

        $data = $request->validate(
            [
                'dataAgenda.no_surat' => [
                    'unique:data_agendas,no_surat,'.$dataAgenda->id,
                    'regex:/^\d{1,4}\/\d{1,4}\/\d{4}$/',
                    Rule::exists('surat_keluars','no_surat')->where('no_surat','111'),
                    'required'
                ],
                'dataAgenda.id_penduduk' => [
                    'numeric',
                    'required'
                ],
                'dataAgenda.atribute.data.*' => [
                    'regex:/^[\pL\s\-]+$/u',
                    'required'
                ],
            ]
        );
        dd();

        $atribute = array_key_exists("atribute",$data['dataAgenda']);

        $data['id'] = null;
        $data['dataAgenda']['id_agenda'] = $agenda->id;
        $data['dataAgenda']['id_data_surat_keluar'] = 0;

        if($dataAgenda->exists){
            $data['id'] = $dataAgenda->id;
            $data['dataAgenda']['id_agenda'] = $agenda->id;
            $data['dataAgenda']['id_data_surat_keluar'] = $dataAgenda->id_data_surat_keluar;
        }

        $datas_surat = AtributeData::all();

        if($atribute){

            $data['dataAgenda']['atribute']['data'] = collect($data['dataAgenda']['atribute']['data'])
            ->map(function($data,$key) use ($datas_surat){

                return[
                    'key' => $key,
                    'type' => $datas_surat->where('key','=',$key)->first()->type,
                    'value' => $data
                ];
            })->toArray();
        }else{
            $data['dataAgenda']['atribute']['data'] = [];
        }

        $data['dataAgenda']['atribute'] = json_encode($data['dataAgenda']['atribute']);

        DataAgenda::updateOrCreate([
            'id' => $data['id'],
            'id_agenda' => $data['dataAgenda']['id_agenda']
        ],$data['dataAgenda']);

        $ket = $dataAgenda->exists? "Edit" : "Simpan";

        Toast::info(__($ket.' Data Berhasil'));

        if(!$dataAgenda->exists){
            return redirect()->route('platform.agendas.show',$agenda);
        }
    }

    public function remove(Agenda $agenda,DataAgenda $dataAgenda){

        $dataAgenda->delete();
        Toast::info('Hapus Data Berhasil');

        return redirect()->route('platform.agendas.show',$agenda);

    }

}
