<?php

namespace App\Orchid\Layouts\Keluarga;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class KeluargaAnggotaListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'penduduks';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name','Nama')
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('NIK','NIK')
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('full_date','Tempat Tanggal Lahir')
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('gender','Jenis Kelamin')
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('blood','Golongan darah')
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('address','Alamat')
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('rt_rw','RT/RW')
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('kelurahan_desa','Keluarahan/Desa')
                ->sort()
                ->filter(
                    Input::class
                ),

            TD::make('kecamatan','Kecamatan')
                ->sort()
                ->filter(
                    Input::class
                ),

            TD::make('religion','Agama')
                ->sort()
                ->filter(
                    Input::class
                ),

            TD::make('status_perkawinan','Status')
                ->sort()
                ->filter(
                    Input::class
                ),

            TD::make('profession','Pekerjaan')
                ->sort()
                ->filter(
                    Input::class
                ),
            TD::make('kewerganegaraan','Kewerganegaraan')
                ->sort()
                ->filter(
                    Input::class
                ),

            TD::make('education','Pendidikan')
                ->sort()
                ->filter(
                    Input::class
                ),

            TD::make('created_at','Dibuat')
                ->sort()
                ->filter(
                    Input::class
                )
                ->render(function($penduduk){

                     return $penduduk->created_at->isoFormat('dddd, d MMMM YYYY');
                    }
                ),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($penduduk) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.keluargas.anggotas.edit',[$penduduk->keluarga->id,$penduduk->id])
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->method('remove',['id' => $penduduk->id]),
                        ])
                        ->canSee($penduduk->id != $this->query->get('keluarga')->id_kepala_keluarga);
                }),

        ];
    }
}
