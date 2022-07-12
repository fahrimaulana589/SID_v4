<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Profile;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposeServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        View::composer("*",function ($view){

            $view->with(['pages' => Page::all(),"profile" => Profile::find(1)]);
        });

    }
}
