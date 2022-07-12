<?php

namespace App\Orchid\Screens\Page;

use App\Models\Page;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PageAddScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Tambah Page';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make("Kembali")
                ->icon("action-undo")
                ->route("platform.pages"),

            Button::make("Buat")
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
            Layout::block(
                Layout::rows([
                    Input::make("page.title")
                        ->title("Judul"),

                    Picture::make("page.image")
                        ->title("Gambar")
                ])
            )->title("Page"),
            Layout::rows([
                Quill::make("page.content")
                    ->title("Konten")
            ])
        ];
    }

    public function save(Request $request){
        $data  = $request->validate([
            'page.title' => "required|unique:pages,title",
            'page.image' => "required",
            'page.content' => "required",
        ]);

        Page::create($data["page"]);

        Toast::success("Sukses Tambah");

        return redirect()->route("platform.pages");
    }
}
