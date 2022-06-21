<?php

declare(strict_types=1);

namespace App\Orchid;

use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        $bool = false;

        return [
            Menu::make('Pelayanan')
                ->icon('info')
                ->route('platform.warga.pelayanan')
                ->title('Warga')
                ->canSee(!Auth::hasUser()),

            Menu::make('Cek Surat')
                ->icon('info')
                ->route('platform.warga.pelayanan.cek')
                ->canSee(!Auth::hasUser()),

            Menu::make('Data Agenda')
                ->icon('info')
                ->route('platform.agendas')
                ->title('Module')
                ->permission('platform.systems.agenda'),

            Menu::make('Pelayanan')
                ->icon('info')
                ->route('platform.surat-keluars')
                ->permission('platform.systems.pelayanan'),

            Menu::make('Pelayanan Masuk')
                ->icon('info')
                ->route('platform.pelayanan.masuk')
                ->permission('platform.systems.pelayanan'),


            Menu::make('Data Penduduk')
                ->icon('info')
                ->route('platform.penduduks')
                ->permission('platform.systems.penduduk')
                ->title(__('Kependuduk')),

            Menu::make('Data Keluarga')
                ->icon('info')
                ->route('platform.keluargas')
                ->permission('platform.systems.keluarga'),

            Menu::make('Data Perangkat Desa')
                ->icon('info')
                ->route('platform.perangkats')
                ->title('Desa')
                ->permission('platform.systems.perangkat'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group(__('Item'))
                ->addPermission('platform.systems.agenda', __('Agenda'))
                ->addPermission('platform.systems.agenda.edit', __('Agenda Edit'))
                ->addPermission('platform.systems.surat', __('Surat'))
                ->addPermission('platform.systems.surat-keluar.edit', __('Surat Keluar Edit'))
                ->addPermission('platform.systems.surat.edit', __('Surat Edit'))
                ->addPermission('platform.systems.penduduk', __('Penduduk'))
                ->addPermission('platform.systems.penduduk.edit', __('Penduduk Edit'))
                ->addPermission('platform.systems.keluarga', __('Keluarga'))
                ->addPermission('platform.systems.keluarga.edit', __('Keluarga Edit'))
                ->addPermission('platform.systems.data', __('Data'))
                ->addPermission('platform.systems.data.edit', __('Data Edit'))
                ->addPermission('platform.systems.perangkat', __('Perangkat'))
                ->addPermission('platform.systems.perangkat.edit', __('Perangkat Edit'))
                ->addPermission('platform.systems.pelayanan', __('Pelayanan'))

            ];
    }
}
