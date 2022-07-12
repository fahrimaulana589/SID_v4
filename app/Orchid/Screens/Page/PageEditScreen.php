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

class PageEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit Page';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Page $page): array
    {
        return [
            "page" => $page
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
            Link::make("Kembali")
                ->icon("action-undo")
                ->route("platform.pages"),

            Button::make("Update")
                ->icon("save")
                ->method("update")

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

    public function update(Page $page,Request $request){

        $data  = $request->validate([
            'page.title' => "required|unique:pages,title,".$page->id,
            'page.image' => "required",
            'page.content' => "required",
        ]);

        $page->fill($data["page"])->save();

        Toast::success("Sukses Edit");

    }
}
