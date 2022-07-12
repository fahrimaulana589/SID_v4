<?php

namespace App\Orchid\Screens\Page;

use App\Models\Page;
use App\Orchid\Layouts\Page\PageListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class PageListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Daftar Page';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $pages = Page::filters()
            ->defaultSort('id','desc')
            ->paginate(10);

        return [
            "pages" => $pages
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
            Link::make("Tambah")
                ->icon("plus")
                ->route("platform.pages.create")
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
            PageListLayout::class
        ];
    }

    public function remove(Page $page){
        $page->delete();

        Toast::info('Hapus Data Berhasil');

    }
}
