<?php

namespace App\Orchid\Layouts\Profile;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Layouts\Rows;

class ProfileEditLayout2 extends Rows
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
            Picture::make("profile.logo")
                ->title("Logo"),

            Picture::make("profile.background")
                ->title("Background"),

            Picture::make("profile.kepala_desa")
                ->title("Kepala Desa"),

        ];
    }
}
