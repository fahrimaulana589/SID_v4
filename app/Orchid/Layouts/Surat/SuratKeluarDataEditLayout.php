<?php

namespace App\Orchid\Layouts\Surat;

use App\Models\Penduduk;
use App\Models\PerangkatDesa;
use Carbon\Carbon;
use DateTime;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\TextArea;

class SuratKeluarDataEditLayout extends Rows
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
        $no_surat = $this->noSurat();
        $tanggal_surat = $this->tanggalSurat();

        $field = [
            Input::make('surat_keluar_data.no_surat')
                ->title('No surat')
                ->value($no_surat)
                ->required()
                ->max(255),
            DateTimer::make('surat_keluar_data.tanggal_surat')
                ->title('Tanggal surat')
                ->value($tanggal_surat)
                ->placeholder('Masukan tanggal')
                ->required(),

            Relation::make('surat_keluar_data.id_perangkat_desa')
                ->title('Atas nama')
                ->required()
                ->fromModel(PerangkatDesa::class,'name','id'),

            Relation::make('surat_keluar_data.id_penduduk')
                ->title('Penduduk')
                ->required()
                ->fromModel(Penduduk::class,'NIK','id')
        ];

        $exist = $this->query->get('exist');

        $data = $this->query->get('surat_keluar')->atribute;

        if($exist){
            $data_surat = $this->query->get('surat_keluar_data')->atribute;

            $data_surat = str_replace("'",'"',$data_surat);

            $data_surat =  json_decode($data_surat);
            $data_surat =  get_object_vars($data_surat->data);

        }
        else{
            $data_surat = [];
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
                TextArea::make("surat_keluar_data.atribute.data.{$data[$item]->key}")
                    ->title($item)
                    ->required()
                    ->value($value)
                    ->rows(5)
                    ->max(255));
            }
            else if($data[$item]->type == 'text'){
                array_push($field,
                Input::make("surat_keluar_data.atribute.data.{$data[$item]->key}")
                    ->title($item)
                    ->required()
                    ->value($value)
                    ->max(255));
            }
        }

        return $field;
    }

    public function noSurat() : string{
        $data = '';
        $tahun = 0;
        $no = 0;

        $surat_keluar = $this->query->get('surat_keluar');

        if(!$surat_keluar->datas()->exists()){
            $tahun = Carbon::now()->year;
            $no = 1;

            $data = "{$surat_keluar->no_surat}/{$no}/{$tahun}";

            return $data;
        };

        $tahun = Carbon::now()->year;
        $data_terakhir = $surat_keluar->datas->last()->no_surat;
        $data_terakhir = explode('/',$data_terakhir);
        $tahun_trakhir = $data_terakhir[2];

        if($tahun > $tahun_trakhir){
            $no = 1;

            $data = "{$surat_keluar->no_surat}/{$no}/{$tahun}";

            return $data;
        };

        $no = (int) $data_terakhir[1] + 1;
        $data = "{$surat_keluar->no_surat}/{$no}/{$tahun}";

        return $data;
    }

    public function tanggalSurat() : string{
        $data = "";

        $data = Carbon::now()->toDateTimeString();

        return $data;
    }
}
