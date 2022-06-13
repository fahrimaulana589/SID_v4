<?php

namespace App\Models;

use App\Models\DataAgenda;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKeluar extends Model
{
    use RoleAccess, Filterable, AsSource, Chartable, HasFactory,Attachable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'atribute',
        'no_surat',
        'syarat',
        'id_agenda',
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
        'title',
        'description',
        'no_surat',
        'id_agenda',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'title',
        'description',
        'no_surat',
        'id_agenda',
        'updated_at',
        'created_at',
    ];

    public function datas(){

        return $this->hasMany(SuratKeluarData::class,'id_surat_keluar');
    }

    public function agenda(){

        return $this->belongsTo(Agenda::class,'id_agenda');
    }



}
