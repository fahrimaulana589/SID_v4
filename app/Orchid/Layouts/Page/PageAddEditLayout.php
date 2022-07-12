<?php

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

class PageAddEditLayout extends Rows
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
        return [];
    }
}
