<?php

namespace App\Orchid\Screens\Warga;

use App\Models\AtributeData;
use App\Models\Pelayanan;
use App\Models\SuratKeluar;
use App\Orchid\Layouts\Warga\PelayananAddLayout;
use Illuminate\Http\Request;
use Orchid\Attachment\File;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PelayananAddScreen extends Screen
{
    public SuratKeluar $suratKeluar;
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Tambah Pelayanan';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(SuratKeluar $pelayanan): array
    {
        $this->suratKeluar = $pelayanan;
        $this->name = "Tambah " . $pelayanan->title;
        return [
            "surat_keluar" => $this->suratKeluar
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
            Button::make("Tambah")
                ->method("save")
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::block(PelayananAddLayout::class)
                ->title("pelayanan")
                ->description("Masukan data pelayanan anda")
        ];
    }

    public function save(SuratKeluar $pelayanan,Request $request)
    {
        $data = $request->all();

//        $data = $request->validate(
//            [
//                'pelayanan.nik' => [
//                    'exists:penduduks,NIK',
//                    'required'
//                ],
//                'pelayanan.keprluan' => [
//                    'required'
//                ],
//                'pelayanan.image' => [
//                    'mimes:jpg,jpeg,gif,JPG',
//                    'required'
//                ]
//            ]
//        );

        $datas_surat = AtributeData::all();
        $atribute = array_key_exists("atribute",$data['pelayanan']);


        if($atribute){
            $data['pelayanan']['atribute']['data'] = collect($data['pelayanan']['atribute']['data'])
                ->map(function($data,$key) use ($datas_surat){

                    return[
                        'key' => $key,
                        'type' => $datas_surat->where('key','=',$key)->first()->type,
                        'value' => $data
                    ];
                })->toArray();
        }
        else{
            $data['pelayanan']['atribute']['data'] = [];
        }

        $collection = collect($data["pelayanan"]["images"]);

        $data['pelayanan']['images'] = $collection->implode(function ($item){
            $file = new File($item);
            $attachment = $file->load();
            return "$attachment->path$attachment->name.$attachment->extension";
        },"|");

        $data['pelayanan']['atribute'] = json_encode($data['pelayanan']['atribute']);

        $data['pelayanan']['id_surat_keluar'] = $pelayanan->id;

        $data['pelayanan']['status'] = "diterima";

        dd($data['pelayanan']);

        Pelayanan::create($data["pelayanan"]);

        dd($data);

        Toast::success("Simpan Sukses");
    }
}
