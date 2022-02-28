<?php

namespace App\Models;

use Carbon\Carbon;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKeluarData extends Model
{
    use RoleAccess, Filterable, AsSource, Chartable, HasFactory, Attachable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_surat_keluar',
        'id_penduduk',
        'id_perangkat_desa',
        'no_surat',
        'tanggal_surat',
        'atribute',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'id_surat_keluar',
        'id_penduduk',
        'id_perangkat_desa',
        'no_surat',
        'tanggal_surat',
        'atribute',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'id_surat_keluar',
        'id_penduduk',
        'id_perangkat_desa',
        'no_surat',
        'tanggal_surat',
        'atribute',
        'updated_at',
        'created_at',
    ];

    public function suratKeluar(){

        return $this->belongsTo(SuratKeluar::class,'id_surat_keluar');
    }

    public function getFullDate(){
        $date = Carbon::parse($this->attributes['tanggal_surat'])->isoFormat('dddd, D MMMM YYYY');

        return "{$date}";
    }

    public function agendaData(){

        return $this->hasOne(DataAgenda::class,'id_data_surat_keluar','id');
    }
}
