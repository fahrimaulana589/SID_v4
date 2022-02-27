<?php

namespace App\Orchid\Screens\agenda;

use App\Models\Agenda;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use App\Service\AgendaService;
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
    public function query(Agenda $agenda): array
    {

        $this->exist = $agenda->exists;

        if(!$this->exist){
            $this->name = 'Create Agenda';
        }

        return [
            'agenda'       => $agenda,
            'permission' => $agenda->getStatusPermission(),
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


        $data = $request->validate(
            [
                'agenda.title' => [
                    'required'
                ],
                'agenda.description' => [
                    'required'
                ],
            ]
        );

        $data['id'] = null;

        if($agenda->exists){
            $data['id'] = $agenda->id;
        }

        Agenda::updateOrCreate(['id' => $data['id']],$data['agenda']);

        Toast::info(__('User was saved.'));

        if(!$agenda->exists){
            return redirect()->route('platform.agendas');
        }
    }

    public function remove(Agenda $agenda){

        $agenda->delete();

        Toast::info('Agenda Dihapus');

        return redirect()->route('platform.agendas');
    }
}
