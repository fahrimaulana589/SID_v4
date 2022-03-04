<?php

namespace App\Orchid\Layouts\Agenda;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\TextArea;

class DataAgendaKeperluanLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {

        $field = [];

        $exist = $this->query->get('exist');

        $data = $this->query->get('agenda')->atribute;

        $data_surat = $this->query->get('dataAgenda')->atribute;

        if($exist && $data_surat != '{"data":[]}'){

            $data_surat = str_replace("'",'"',$data_surat);

            $data_surat =  json_decode($data_surat);
            $data_surat =  get_object_vars($data_surat->data);
        }
        else{
            $data_surat = [];
        }

        if($data == '{"data":[]}'){
            return $field;
        }

        $data = str_replace("'",'"',$data);

        $data =  json_decode($data);
        $data =  get_object_vars($data->data);
        $data_key = array_keys($data);

        foreach($data_key as $item){
            $value = '';
            if(array_key_exists($data[$item]->key,$data_surat)){
                $value = $data_surat[$data[$item]->key]->value;
            };

            if($data[$item]->type == 'multitext'){
                array_push($field,
                TextArea::make("dataAgenda.atribute.data.{$data[$item]->key}")
                    ->title($item)
                    ->required()
                    ->value($value)
                    ->rows(5)
                    ->max(255));
            }
            else if($data[$item]->type == 'text'){
                array_push($field,
                Input::make("dataAgenda.atribute.data.{$data[$item]->key}")
                    ->title($item)
                    ->required()
                    ->value($value)
                    ->max(255));
            }
        }


        return $field;
    }
}
