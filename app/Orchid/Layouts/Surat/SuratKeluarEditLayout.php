<?php

namespace App\Orchid\Layouts\Surat;

use App\Models\Agenda;
use Orchid\Screen\Field;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Schema;

class SuratKeluarEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {

        $nama_file = $this->query->get('exist') ? $this->query->get('surat-keluar')->attachment('doct')->first()->original_name : "";


        return [
            Input::make('surat-keluar.title')
                ->title('Judul')
                ->required()
                ->max(255),

            Input::make('surat-keluar.new_template')
                ->title('Template')
                ->type('file')
                ->required(!$this->query->get('exist'))
                ->max(255),

            Input::make('surat_masuk.template')
                ->canSee($this->query->get('exist'))
                ->value($nama_file)
                ->readonly(),

            Relation::make('surat-keluar.id_agenda')
                ->title('Agenda')
                ->fromModel(Agenda::class, 'title','id'),

            Input::make('surat-keluar.no_surat')
                ->title('No surat')
                ->type('text')
                ->required()
                ->max(255),

            TextArea::make('surat-keluar.description')
                ->title('Deskripsi')
                ->required()
                ->max(255)
                ->rows(5),
            Group::make(
                        $this->makeCheckBoxData()
                    )
                        ->alignEnd()
                        ->autoWidth(),
        ];
    }

    private function makeCheckBoxData() : array{

        $datas = $this->query->get('data_atribute');
        $datas_surat = $this->query->get('surat-keluar')->atribute;

        if ($datas_surat != null){
            $datas_surat = json_decode($datas_surat);
            $datas_surat = get_object_vars($datas_surat->data);
            $datas_surat = collect($datas_surat)->map(function($data){
                return $data->key;
            })->toArray();
            $datas_surat = array_values($datas_surat);
            $datas_surat = $datas_surat;
        }
        else{
            $datas_surat = [];
        }

        $check_box = [];

        $first = true;
        $no = 1;
        foreach($datas as $item){

            if($first){

                array_push($check_box,
                    CheckBox::make("surat-keluar.atribute.data.{$item->title}")
                        ->title('Data')
                        ->placeholder($item->title)
                        ->value( "{$item->key}")
                        ->checked(in_array($item->key,$datas_surat))
                );

                $first = false;
            }
            else{
                array_push($check_box,
                    CheckBox::make("surat-keluar.atribute.data.{$item->title}")
                        ->placeholder($item->title)
                        ->value( "{$item->key}")
                        ->checked(in_array($item->key,$datas_surat))
                );
            }
            $no++;
        }

        return $check_box;
    }


}
