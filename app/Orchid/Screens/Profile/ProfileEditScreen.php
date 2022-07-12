<?php

namespace App\Orchid\Screens\Profile;

use App\Models\Profile;
use App\Orchid\Layouts\Profile\ProfileEditLayout;
use App\Orchid\Layouts\Profile\ProfileEditLayout2;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProfileEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Profile Desa';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            "profile" => Profile::find(1)
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
            Button::make("Update")
                ->method("update")
                ->icon("save")
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
            Layout::columns([
                ProfileEditLayout::class,
                ProfileEditLayout2::class,
            ])
        ];
    }

    public function update(Request $request)
    {
        $data = $request->validate(
            [
                "profile.name" => "required",
                "profile.sambutan" => "required",
                "profile.description" => "required",
                "profile.logo" => "required",
                "profile.background" => "required",
                "profile.slogan" => "required",
                "profile.kepala_desa" => "required",
                "profile.sambutan_kepala_desa" => "required",
            ]
        );

        Profile::updateOrCreate(["id"=>1],$data["profile"]);

        Toast::success("Berhasil update profile");
    }
}
