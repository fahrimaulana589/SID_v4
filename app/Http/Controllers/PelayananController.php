<?php

namespace App\Http\Controllers;

use App\Models\AtributeData;
use App\Models\Pelayanan;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Attachment\File;
use Orchid\Support\Facades\Toast;

class PelayananController extends Controller
{
    public function show(){

        $pelayanan = SuratKeluar::all();

        return view("pages.pelayanan",["pelayanan"=>$pelayanan]);
    }

    public function store(SuratKeluar $pelayanan,Request $request){
        dd($request->all());

        $data = $request->validate(
            [
                'pelayanan.nik_penduduks' => [
                    'exists:penduduks,NIK',
                    'required'
                ],
                'pelayanan.keperluan' => [
                    'required'
                ],
                'pelayanan.images' => [
                    'required'
                ]
            ]
        );

        $datas_surat = AtributeData::all();
        $atribute = array_key_exists("attribute", $data['pelayanan']);

        if ($atribute) {
            $data['pelayanan']['atribute']['data'] = collect($data['pelayanan']['atribute']['data'])
                ->map(function ($data, $key) use ($datas_surat) {

                    return [
                        'key' => $key,
                        'type' => $datas_surat->where('key', '=', $key)->first()->type,
                        'value' => $data
                    ];
                })->toArray();
        } else {
            $data['pelayanan']['attribute']['data'] = [];
        }

        $value = "";

        $int = 1;
        $jumlah_gambar = count($data["pelayanan"]["images"]);

        foreach ($data["pelayanan"]["images"] as $item) {
            $file = new File($item);
            $attachment = $file->load();
            if ($int == $jumlah_gambar) {
                $value .= "$attachment->path$attachment->name.$attachment->extension";
            } else {
                $value .= "$attachment->path$attachment->name.$attachment->extension|";
                $int++;
            }
        }

        $data['pelayanan']['images'] = $value;

        $data['pelayanan']['attribute'] = json_encode($data['pelayanan']['attribute']);

        $data['pelayanan']['id_surat_keluar'] = $pelayanan->id;

        $data['pelayanan']['kode_unik'] = "K-" . Str::uuid();
        $data['pelayanan']['status'] = "masuk";
        $data["pelayanan"]["no_surat"] = "null";

        $pelayanan = Pelayanan::create($data["pelayanan"]);

//        return redirect()->route("platform.warga.pelayanan.cek",$pelayanan->kode_unik);
    }

    public function pelayanan(SuratKeluar $pelayanan){

        $data = str_replace("'",'"',$pelayanan->atribute);

        if($data == '{"data":[]}'){
            $data =  json_decode($data);
            $data_key = [];
        }else{
            $data =  json_decode($data);
            $data =  get_object_vars($data->data);
            $data_key = array_keys($data);
        }

        return view("pages.layanan",["pelayanan"=>$pelayanan,"data"=>$data,"data_key" => $data_key]);
    }
}
