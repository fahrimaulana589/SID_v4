<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Illuminate\Support\Carbon;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penduduk extends Model
{
    use RoleAccess, Filterable, AsSource, Chartable, HasFactory;

    protected $fillable = [
        'NIK',
        'id_keluarga',
        'status_keluarga',
        'name_ayah',
        'name_ibu',
        'name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'blood',
        'address',
        'rt',
        'rw',
        'kelurahan_desa',
        'kecamatan',
        'religion',
        'status_perkawinan',
        'profession',
        'kewerganegaraan',
        'education',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $allowedFilters = [
        'id',
        'NIK',
        'id_keluarga',
        'status_keluarga',
        'name_ayah',
        'name_ibu',
        'name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'blood',
        'address',
        'rt',
        'rw',
        'kelurahan_desa',
        'kecamatan',
        'religion',
        'status_perkawinan',
        'profession',
        'kewerganegaraan',
        'education',
    ];

    protected $allowedSorts = [
        'id',
        'NIK',
        'id_keluarga',
        'status_keluarga',
        'name_ayah',
        'name_ibu',
        'name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'blood',
        'address',
        'rt',
        'rw',
        'kelurahan_desa',
        'kecamatan',
        'religion',
        'status_perkawinan',
        'profession',
        'kewerganegaraan',
        'education',
        'created_at',
    ];

    public function keluarga(){
        return $this->belongsTo(Keluarga::class,'id_keluarga');
    }

    public function getFullDateAttribute(){

        $date = Carbon::parse($this->attributes['date_of_birth'])->isoFormat('dddd, d MMMM YYYY');

        return "{$this->attributes['place_of_birth']} {$date}";
    }

    public function getRtRwAttribute(){

        return "{$this->attributes['rt']}/{$this->attributes['rw']}";
    }

}
