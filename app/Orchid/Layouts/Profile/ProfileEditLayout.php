<?php

namespace App\Orchid\Layouts\Profile;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ProfileEditLayout extends Rows
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
        return [
            Input::make("profile.name")
                ->title("Nama Desa"),

            Input::make("profile.slogan")
                ->title("Slogan"),

            TextArea::make("profile.sambutan")
                ->title("Sambutan Desa")
                ->rows(5),

            TextArea::make("profile.description")
                ->title("Deskripsi desa Desa")
                ->rows(5),

            TextArea::make("profile.sambutan_kepala_desa")
                ->title("Sambutan Kepala Desa")
                ->rows(5),
        ];
    }
}
