<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKeluarData extends Model
{
    use RoleAccess, Filterable, AsSource, Chartable, HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_surat_keluar',
        'id_penduduk',
        'title',
        'no_surat',
        'tanggal_surat',
        'atas_nama',
        'jabatan_atas_nama',
        'description',
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
        'title',
        'no_surat',
        'tanggal_surat',
        'atas_nama',
        'jabatan_atas_nama',
        'description',
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
        'title',
        'no_surat',
        'tanggal_surat',
        'atas_nama',
        'jabatan_atas_nama',
        'description',
        'atribute',
        'updated_at',
        'created_at',
    ];

    public function suratKeluar(){

        return $this->belongsTo(SuratKeluar::class,'id_surat_keluar');
    }
}
