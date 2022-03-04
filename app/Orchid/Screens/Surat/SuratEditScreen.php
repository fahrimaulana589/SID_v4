<?php

namespace App\Orchid\Screens\Surat;

use App\Models\Surat;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Attachment\File;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Surat\SuratEditLayout;

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
            $this->name = 'Buat Surat Masuk';
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

            Link::make(__('Kembali'))
                ->icon('action-undo')
                ->route('platform.surat-masuks')
                ->canSee(true),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm('Apakah anda akan menghapus data ini')
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
                    'regex:/^[\pL\s\-]+$/u',
                     'required'
                 ],

                 'surat_masuk.description' => [
                    'regex:/^[\pL\s\-]+$/u',
                     'required'
                 ],

                 'surat_masuk.pengirim' => [
                    'regex:/^[\pL\s\-]+$/u',
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

        Toast::info('Simpan Data Berhasil');
        return redirect()->route("platform.surat-masuks");

    }

    public function edit(Surat $surat,Request $request){
        $data = $request->validate(
            [
                'surat_masuk.title' => [
                    'regex:/^[\pL\s\-]+$/u',
                     'required'
                 ],

                 'surat_masuk.description' => [
                    'regex:/^[\pL\s\-]+$/u',
                     'required'
                 ],

                 'surat_masuk.pengirim' => [
                    'regex:/^[\pL\s\-]+$/u',
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

        Toast::info('Edit Data Berhasil');

    }

    public function remove(Surat $surat){

        $surat->attachment()->delete();
        $surat->delete();

        Toast::info('Hapus Data Berhasil');
        return redirect()->route("platform.surat-masuks");
    }
}
