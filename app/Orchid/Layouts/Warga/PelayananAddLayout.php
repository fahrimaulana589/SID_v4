<?php

namespace App\Orchid\Layouts\Warga;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\TD;

class PelayananAddLayout extends Rows
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
        $data = $this->query->get('surat_keluar')->atribute;

        $field =  [
            Input::make("pelayanan.nik_penduduks")
                ->required(true)
                ->title("NIK"),

            TextArea::make("pelayanan.keperluan")
                ->required(true)
                ->title("Keperluan"),

            Input::make("pelayanan.images","Data diri")
                ->type("file")
                ->required(true)
                ->title("Data diri")
                ->multiple()

        ];

        $data = str_replace("'",'"',$data);

        if($data == '{"data":[]}'){
            return $field;
        }

        $data =  json_decode($data);
        $data =  get_object_vars($data->data);
        $data_key = array_keys($data);

        foreach($data_key as $item){
            $value = '';

            if($data[$item]->type == 'multitext'){
                array_push($field,
                    TextArea::make("pelayanan.atribute.data.{$data[$item]->key}")
                        ->title($item)
                        ->required()
                        ->value($value)
                        ->rows(5)
                        ->max(255));
            }
            else if($data[$item]->type == 'text'){
                array_push($field,
                    Input::make("pelayanan.atribute.data.{$data[$item]->key}")
                        ->title($item)
                        ->required()
                        ->value($value)
                        ->max(255));
            }
        }

        return $field;
    }
}
