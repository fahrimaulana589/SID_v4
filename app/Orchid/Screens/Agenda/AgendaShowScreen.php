<?php

namespace App\Orchid\Screens\Agenda;

use App\Models\Agenda;
use Orchid\Screen\Sight;
use Orchid\Screen\Screen;
use App\Models\DataAgenda;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Agenda\DataAgendaListLayout;

class AgendaShowScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'as';

    public $description = 'as';

    public $permission = 'platform.systems.agenda';

    public $agenda;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Agenda $agenda): array
    {

        $this->name = $agenda->title;
        $this->description = $agenda->description;
        $this->agenda = $agenda;

        $data['agendas'] = $this->agenda;

        $data['data_agendas'] = $agenda->dataAgendas()
                                            ->filters()
                                            ->defaultSort('id', 'desc')
                                            ->paginate(10);

        foreach($agenda->dataAgendas as $item){
            $data['data-'.$item->penduduk->id] = $item->penduduk;
        }
        return $data;
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

            Link::make('Tambah')
                ->icon('plus')
                ->route('platform.agendas.create.data',$this->agenda->id)
        ];
        dd();
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $data = [];
        array_push($data,DataAgendaListLayout::class);

        foreach($this->agenda->dataAgendas as $key => $item){
            $model = Layout::modal('data-'.$item->id, [
                Layout::legend('data-'.$item->penduduk->id, [
                    Sight::make('id','Id'),
                    Sight::make('name','Nama'),
                    Sight::make('place_of_birth','Tempat Lahir'),
                    Sight::make('date_of_birth','Tanggal lahir'),
                    Sight::make('gender','Jenis kelamin'),
                    Sight::make('profession','Pekerjaan'),
                    Sight::make('address','Alamat'),
                    Sight::make('education','Pendidikan'),
                    Sight::make('religion','Agama'),
                ])
            ])->withoutApplyButton()
                ->title('Data agenda');

            array_push($data,$model);
        }

        return $data;
    }

    public function remove(DataAgenda $dataAgenda){
        $dataAgenda->delete();
        Toast::info('Data Agenda Telah Di Hapus');
    }

}
