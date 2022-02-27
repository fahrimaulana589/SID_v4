<?php

namespace App\Orchid\Screens\Agenda;

use App\Models\Agenda;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use App\Models\DataAgenda;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Agenda\AgendaEditLayout;
use App\Orchid\Layouts\Agenda\AgendaDescriptionLayout;
use App\Orchid\Layouts\Agenda\DataAgendaKeperluanLayout;
use App\Orchid\Layouts\Agenda\DataAgendaPendudukLayout;

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

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Agenda $agenda,DataAgenda $dataAgenda): array
    {
        $this->exist = $dataAgenda->exists;

        if(!$this->exist){
            $this->name = 'Create Data Agenda';
        }

        return [
            'dataAgenda'       => $dataAgenda,
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
            Layout::block(DataAgendaPendudukLayout::class)
                ->title('Data Penduduk')
                ->description('Silah kan masukan data penduduk')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('save')
                ),
            Layout::block(DataAgendaKeperluanLayout::class)
                ->title('Keperluan')
                ->description('Silahkan masukan keperluan')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('save')
                )
        ];
    }

    public function save(Agenda $agenda,DataAgenda $dataAgenda,Request $request){

        $data = $request->validate(
            [
                'dataAgenda.name' => [
                    'required'
                ],
                'dataAgenda.place_of_birth' => [
                    'required'
                ],
                'dataAgenda.date_of_birth' =>[
                    'required'
                ],
                'dataAgenda.gender' =>[
                    'required'
                ],
                'dataAgenda.address' =>[
                    'required'
                ],
                'dataAgenda.education' =>[
                    'required'
                ],
                'dataAgenda.status' =>[
                    'required'
                ],
                'dataAgenda.profession' =>[
                    'required'
                ],
                'dataAgenda.religion' =>[
                    'required'
                ],
                'dataAgenda.necessity' =>[
                    'required'
                ]
            ]
        );


        $data['id'] = null;
        $data['id_agenda'] = null;


        if($agenda->exists || $dataAgenda->exists){
            $data['id'] = $dataAgenda->id;
            $data['id_agenda'] = $agenda->id;
        }


        DataAgenda::updateOrCreate([
            'id' => $data['id'],
            'id_agenda' => $data['id_agenda']
        ],$data['dataAgenda']);

        Toast::info(__('Data agenda telah tersimpan.'));

        if(!$dataAgenda->exists ){
            return redirect()->route('platform.agendas.show',$agenda);
        }
    }
    
}
