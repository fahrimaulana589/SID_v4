<?php

namespace App\Orchid\Screens\agenda;

use App\Models\Agenda;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Auth;
use App\Orchid\Layouts\User\UserListLayout;
use App\Orchid\Layouts\User\UserFiltersLayout;
use App\Orchid\Layouts\Agenda\AgendaListLayout;

class AgendaListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Daftar Agenda Desa';

    public $description = 'Daftar buku agenda desa karanganayar';

    public $permission = 'platform.systems.agenda';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'agendas' => Agenda::with('dataAgendas')
                ->filters()
                ->defaultSort('id', 'desc')
                ->paginate(10),
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
            Link::make('Tambah')
                ->icon('plus')
                ->route('platform.agendas.create')
                ->canSee(Auth::user()->hasAccess('platform.systems.agenda.edit'))
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        if(Auth::user()->hasAccess('platform.systems.agenda.edit')
        ){
            return [
                AgendaListLayout::class,
            ];
        }
        else{
            return [
                Layout::view('agenda.index')
            ];
        }
    }

    public function remove(Agenda $agenda){

        $agenda->delete();

        Toast::info('Hapus Data berhasil');

    }
}
