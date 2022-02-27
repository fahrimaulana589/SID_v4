<?php

namespace App\Orchid\Layouts\Surat;

use App\Models\Penduduk;
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
                ->readonly()
                ->max(255),
            DateTimer::make('surat_keluar_data.tanggal_surat')
                ->title('Tanggal surat')
                ->value($tanggal_surat)
                ->placeholder('Masukan tanggal')
                ->required(),
            Input::make('surat_keluar_data.atas_nama')
                ->title('Atas nama')
                ->required()
                ->max(255),
            Select::make('surat_keluar_data.jabatan_atas_nama')
                ->title('Jabatan')
                ->required()
                ->options(
                    [
                        'Kepala Desa' => 'Kepala Desa Karanganyar'
                    ]
                ),
            Relation::make('surat_keluar_data.id_penduduk')
                ->title('Penduduk')
                ->required()
                ->fromModel(Penduduk::class,'NIK','id')
        ];

        $data = $this->query->get('surat_keluar')->atribute;

        $data = str_replace("'",'"',$data);

        $data =  json_decode($data);
        $data =  get_object_vars($data->data);
        $data_key = array_keys($data);

        foreach($data_key as $item){

            if($data[$item]->type == 'multitext'){
                array_push($field,
                TextArea::make("surat_keluar_data.atribute.data.{$data[$item]->key}")
                    ->title($item)
                    ->required()
                    ->rows(5)
                    ->max(255));
            }
            else if($data[$item]->type == 'text'){
                array_push($field,
                Input::make("surat_keluar_data.atribute.data.{$data[$item]->key}")
                    ->title($item)
                    ->required()
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

        return $data;
    }

    public function tanggalSurat() : string{
        $data = "";

        $data = Carbon::now()->toDateTimeString();

        return $data;
    }
}
