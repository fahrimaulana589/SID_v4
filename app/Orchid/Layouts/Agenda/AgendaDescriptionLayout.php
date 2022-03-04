<?php

namespace App\Orchid\Layouts\Agenda;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\TextArea;

class AgendaDescriptionLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            TextArea::make('agenda.description')
                ->type('textarea')
                ->max(255)
                ->required()
                ->title('Deskripsi')
                ->rows(5)
                ->placeholder('Masukan Deskripsi'),
            Group::make(
                    $this->makeCheckBoxData()
                )
                    ->alignEnd()
                    ->autoWidth(),
        ];
    }

    private function makeCheckBoxData() : array{



        $datas = $this->query->get('data_atribute');

        if (count($datas) == 0) {
            return [];
        }

        $datas_surat = $this->query->get('agenda')->atribute;

        if ($datas_surat != null && $datas_surat != '{"data":[]}'){
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
                    CheckBox::make("agenda.atribute.data.{$item->title}")
                        ->title('Data')
                        ->placeholder($item->title)
                        ->value( "{$item->key}")
                        ->checked(in_array($item->key,$datas_surat))
                );

                $first = false;
            }
            else{
                array_push($check_box,
                    CheckBox::make("agenda.atribute.data.{$item->title}")
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
