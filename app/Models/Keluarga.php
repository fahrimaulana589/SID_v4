<?php

namespace App\Models;

use Carbon\Carbon;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keluarga extends Model
{
    use RoleAccess, Filterable, AsSource, Chartable, HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    protected $fillable = [
        'KK',
        'id_kepala_keluarga',
        'address',
        'rt',
        'rw',
        'kode_pos',
        'kelurahan_desa',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
    ];

    protected $allowedFilters = [
        'KK',
        'id_kepala_keluarga',
        'address',
        'rt',
        'rw',
        'kode_pos',
        'kelurahan_desa',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
    ];

    protected $allowedSorts = [
        'KK',
        'id_kepala_keluarga',
        'address',
        'rt',
        'rw',
        'kode_pos',
        'kelurahan_desa',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'education',
        'created_at',
    ];

    public function penduduks(){
        return $this->hasMany(Penduduk::class,'id_keluarga');
    }

    public function kepala(){
        return $this->belongsTo(Penduduk::class,'id_kepala_keluarga');
    }

    public function getRtRwAttribute(){

        return "{$this->attributes['rt']}/{$this->attributes['rw']}";
    }

    public function getDibuatAttribute(){

        return Carbon::parse($this->attributes['created_at'])->isoFormat('dddd, d MMMM YYYY');
    }

}
