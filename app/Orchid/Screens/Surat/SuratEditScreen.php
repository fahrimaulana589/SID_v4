<?php

namespace App\Orchid\Screens\Surat;

use App\Models\Surat;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Attachment\File;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;

class SuratEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Edit Surat Masuk';

    public $permission = 'platform.systems.surat';

    private $exist = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Surat $surat): array
    {
        $this->exist = $surat->exists ;

        if(!$this->exist){
            $this->name = 'Create Surat Masuk';
        }

        return [
            'surat_masuk' => $surat,
            'exist' => $this->exist,
            'permission'  => $surat->getStatusPermission()
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
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->exist),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save')
                ->canSee(!$this->exist),

            Button::make(__('Save'))
                ->icon('check')
                ->method('edit')
                ->canSee($this->exist),
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
            Layout::block(SuratEditLayout::class)
                ->title('Surat Masuk')
                ->description('Silahkan masukan data surat masuk')
                ->commands(
                    Button::make('Simpan')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->exist)
                        ->method('edit')
            )
        ];
    }

    public function save(Request $request){

        $data = $request->validate(
             [
                 'surat_masuk.title' => [
                     'required'
                 ],

                 'surat_masuk.description' => [
                     'required'
                 ],

                 'surat_masuk.pengirim' => [
                     'required'
                 ],

                 'surat_masuk.new_file' => [
                     'mimes:pdf',
                     'required'
                 ],
             ]
        );

        $data['surat_masuk']['file'] = $request->file('surat_masuk.new_file')->getClientOriginalName();

        $surat = Surat::create($data['surat_masuk']);

        $file = new File($request->file('surat_masuk.new_file'));
        $attachment = $file->load();

        $surat->attachment()->save($attachment);

        Toast::info('Surat berhasil disimpan');
        return redirect()->route("platform.surat-masuks");

    }

    public function edit(Surat $surat,Request $request){
        $data = $request->validate(
            [
                'surat_masuk.title' => [
                    'required'
                ],

                'surat_masuk.description' => [
                    'required'
                ],

                'surat_masuk.pengirim' => [
                    'required'
                ],

                'surat_masuk.new_file' => [
                    'mimes:pdf',
                ],
            ]
        );

        if($request->has('surat_masuk.new_file')){
            $data['surat_masuk']['file'] = $request->file('surat_masuk.new_file')->getClientOriginalName();

            $file = new File($request->file('surat_masuk.new_file'));
            $attachment = $file->load();

        }else{
            $data['surat_masuk']['file'] = $request->input('surat_masuk.file');
        }

        $surat->fill($data['surat_masuk'])->save();

        if($request->has('surat_masuk.new_file')){

            $surat->attachment()->delete();
            $surat->attachment()->save($attachment);

        }

        Toast::info('Surat berhasil disimpan');

    }

    public function remove(Surat $surat){

        $surat->attachment()->delete();
        $surat->delete();

        Toast::info('Penduduk berhasil dihapus');
        return redirect()->route("platform.surat-masuks");
    }
}
