<?php

namespace App\Orchid\Screens\agenda;

use App\Models\Agenda;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use App\Models\AtributeData;
use Illuminate\Http\Request;
use App\Service\AgendaService;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Agenda\AgendaEditLayout;
use App\Orchid\Layouts\Agenda\AgendaDescriptionLayout;

class AgendaEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit Agenda';

    public $permission = 'platform.systems.agenda.edit';

    private $exist = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Agenda $agenda,Request $request): array
    {
        session(['url_data' => ''.$request->url()]);

        $this->exist = $agenda->exists;

        if(!$this->exist){
            $this->name = 'Buat Agenda';
        }

        return [
            'agenda'       => $agenda,
            'permission' => $agenda->getStatusPermission(),
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
                ->route('platform.agendas')
                ->canSee(true),

            Link::make('Data')
                ->icon('info')
                ->route('platform.datas'),

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
            Layout::block(AgendaEditLayout::class)
                ->title('Nama')
                ->description('Silah kan masukan nama buku agenda')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('save')
                ),
            Layout::block(AgendaDescriptionLayout::class)
                ->title('Deskripsi')
                ->description('Silahkan masukan deskripsi buku agenda')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('save')
                )
        ];
    }

    public function save(Agenda $agenda,Request $request){
        $datas_agenda = AtributeData::all();

        $data = $request->validate(
            [
                'agenda.title' => [
                    'unique:agendas,title,'.$agenda->id,
                    'regex:/^[\pL\s\-]+$/u',
                    'required'
                ],
                'agenda.description' => [
                    'regex:/^[\pL\s\-]+$/u',
                    'required'
                ],
                'agenda.atribute.data.*' => [
                    'regex:/^[\pL\s\-]+$/u',
                    'required'
                ],
            ]
        );


        $atribute = array_key_exists("atribute",$data['agenda']);

        if($atribute){

            $data['agenda']['atribute']['data'] = collect($data['agenda']['atribute']['data'])
            ->map(function($data,$key) use ($datas_agenda){

                return[
                    'key' => $data,
                    'type' => $datas_agenda->where('key','=',$data)->first()->type
                ];

            })->toArray();
        }else{
            $data['agenda']['atribute']['data'] = [];
        }

        $data['agenda']['atribute'] = json_encode($data['agenda']['atribute']);

        $data['id'] = null;

        $ket = 'Simpan';
        if($agenda->exists){
            $data['id'] = $agenda->id;
            $ket = "Edit";
        }

        Agenda::updateOrCreate(['id' => $data['id']],$data['agenda']);

        Toast::info(__($ket.' Data Berhasil'));

        if(!$agenda->exists){
            return redirect()->route('platform.agendas');
        }
    }

    public function remove(Agenda $agenda){

        $agenda->delete();

        Toast::info('Hapus Data berhasil');

        return redirect()->route('platform.agendas');
    }
}
