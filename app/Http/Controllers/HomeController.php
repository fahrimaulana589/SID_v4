<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Profile;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function home(){

        $profile = Profile::find(1);
        return view("pages.homepage",["profile" => $profile]);
    }

    public function page(Page $page){

        return view("pages.page",["page"=>$page]);
    }
}
