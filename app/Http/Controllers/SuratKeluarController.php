<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratKeluarController extends Controller
{
    public function download(SuratKeluar $surat_keluar,$surat_data_keluar){

        $data_surat = $surat_keluar->datas()->findOrFail($surat_data_keluar);

        $path = $surat_keluar->attachment()->latest()->first()->path;
        $name = $surat_keluar->attachment()->latest()->first()->name;
        $extension = $surat_keluar->attachment()->latest()->first()->extension;
        $file = storage_path("app/public/{$path}/{$name}.{$extension}");

        $templateProcessor = new TemplateProcessor($file);

        $penduduk = $this->penduduk($data_surat);
        $dataTambahan = $this->dataTambahan($surat_keluar,$data_surat);
        $surat = $this->surat($surat_keluar,$data_surat);

        $templateProcessor->setValues($penduduk);
        $templateProcessor->setValues($dataTambahan);
        $templateProcessor->setValues($surat);

        $file = $templateProcessor->save();

        return response()->download($file,Carbon::now()." {$penduduk['Nama']}.docx");
    }
    public function print(SuratKeluar $surat_keluar,$surat_data_keluar){

        $url = route('download',[$surat_keluar->id, $surat_data_keluar]);
        return redirect()->away("https://docs.google.com/viewerng/viewer?url={$url}");
    }



    private function penduduk($data_surat){

        $penduduk_table = Schema::getColumnListing('penduduks');
        $penduduk =   collect($penduduk_table)
                                ->filter(function ($data) {
                                    return
                                    $data != 'id' &&
                                    $data != 'created_at' &&
                                    $data != 'updated_at' &&
                                    $data != 'id_keluarga' &&
                                    $data != 'status_keluarga' &&
                                    $data != 'name_ayah' &&
                                    $data != 'name_ibu' && true;
                                })
                                ->map(function ($data,$key) use ($data_surat) {
                                    $title = [
                                        "NIK",
                                        "id_keluarga",
                                        "status_keluarga",
                                        "name_ayah",
                                        "name_ibu",
                                        "Nama",
                                        "Tempat_lahir",
                                        "Tanggal_lahir",
                                        "Jenis_kelamin",
                                        "Golongan_darah",
                                        "Alamat",
                                        "Rt",
                                        "Rt",
                                        "Kelurahan_desa",
                                        "Kecamatan",
                                        "Agama",
                                        "Status_perkawinan",
                                        "Pekerjaan",
                                        "Kewerganegaraan",
                                        "Pendidikan"
                                    ];

                                    return [
                                        $title[$key-1]  => "".$data_surat->penduduk->$data
                                    ];
                                })
                                ->flatMap(function($value){
                                    return $value;
                                })
                                ->toArray();
        return $penduduk;
    }

    private function dataTambahan($surat_keluar,$data_surat){

        $data_surat = $data_surat->atribute;

        if($data_surat != '{"data":[]}'){
            $data_surat = str_replace("'",'"',$data_surat);

            $data_surat =  json_decode($data_surat);
            $data_surat =  get_object_vars($data_surat->data);
        }else{
            $data_surat = [];
        }

        $data = $surat_keluar->atribute;


        if($data != '{"data":[]}'){
            $data = str_replace("'",'"',$data);

            $data =  json_decode($data);
            $data =  get_object_vars($data->data);
        }else{
            $data = [];
        }

        $data = collect($data_surat)->flatMap(function($value,$key) use ($data) {
            $data_key = array_keys($data);

            $no = 0;
            foreach ($data as $item){
                if($item->key == $key){
                    $key = $data_key[$no];
                }
                $no++;
            }


            return [$key => $value->value];
        })
        ->toArray();
        return $data;
    }

    private function surat($surat_keluar,$data_surat){
        $data = [];

        $data['No_surat'] = $data_surat->no_surat;
        $data['Tanggal_surat'] = $data_surat->tanggal_surat;
        $data['Atas_nama'] = $data_surat->perangkatDesa->name;
        $data['Jabatan_atas_nama'] = $data_surat->perangkatDesa->jabatan;
        $data['Singkatan_jabatan'] = $data_surat->perangkatDesa->persingkat_jabatan;

        return $data;
    }

}
