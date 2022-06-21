<?php

namespace App\Orchid\Screens\Warga;

use App\Models\Pelayanan;
use App\Orchid\Layouts\Warga\PelayananMasukEditLayout;
use http\Env\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PelayananMasukEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit Pelayanan';
    public $pelayan_masuk;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Pelayanan $pelayanan): array
    {
        $this->pelayan_masuk = $pelayanan;
        return [
            "pelayanan" => $pelayanan
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
            Button::make("kembali")
                ->icon("action-undo")
                ->method("back"),
            Button::make("Edit")
                ->icon("pencil")
                ->method("edit")
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
            Layout::block(PelayananMasukEditLayout::class)
                ->title("Pelayanan Masuk"),
            Layout::view("status",["pelayanan"=>  $this->pelayan_masuk])
        ];
    }

    public function edit(Pelayanan $pelayanan,\Illuminate\Http\Request $request){

        $data = $request->all();

        $pelayanan->fill($data["pelayanan"])->save();

        Toast::info("Edit sukses");
    }

    public function back(){

        return redirect()->route("platform.pelayanan.masuk");
    }
}
