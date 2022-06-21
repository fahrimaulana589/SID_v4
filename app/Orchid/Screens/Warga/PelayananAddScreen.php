<?php

namespace App\Orchid\Screens\Warga;

use App\Models\AtributeData;
use App\Models\Pelayanan;
use App\Models\SuratKeluar;
use App\Orchid\Layouts\Warga\PelayananAddLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
                ->icon("plus")
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

    public function save(SuratKeluar $pelayanan, Request $request)
    {
        $data = $request->all();

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

        Toast::success("Simpan Sukses");

        return redirect()->route("platform.warga.pelayanan.cek",$pelayanan->kode_unik);
    }
}
