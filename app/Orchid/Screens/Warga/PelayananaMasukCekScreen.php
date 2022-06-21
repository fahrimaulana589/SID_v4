<?php

namespace App\Orchid\Screens\Warga;

use App\Models\Pelayanan;
use App\Orchid\Layouts\Warga\PelayananMasukCekLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PelayananaMasukCekScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Cek';
    public $pelayanan_masuk;

    /**
     * Query data.
     *
     * @return array
     */
    public function query($pelayanan): array
    {
        $this->name = $pelayanan;

        $this->pelayanan_masuk = Pelayanan::where("kode_unik","=",$pelayanan)->first();

        return [
            "pelayanan" => $this->pelayanan_masuk
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        $see = [];

        if($this->pelayanan_masuk != null){
            if($this->pelayanan_masuk->dataSurat != null){
                $see = [
                    Link::make('Download')
                        ->icon('check')
                        ->route('download',[$this->pelayanan_masuk->dataSurat->id_surat_keluar, $this->pelayanan_masuk->dataSurat->id])
                ];
            }
        }

        array_push($see,
          Button::make("Cek")
            ->icon("eye")
            ->method("cek")
        );

        return $see;
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::view("welcome"),
            Layout::block(PelayananMasukCekLayout::class)
                ->title("Cek Surat"),
            Layout::view("status",["pelayanan"=>$this->pelayanan_masuk])
                ->canSee($this->pelayanan_masuk != null)
        ];
    }

    public function cek(Request $request){

        $data = $request->all()["pelayanan"]["kode_unik"];

        return redirect()->route("platform.warga.pelayanan.cek",$data);
    }
}
