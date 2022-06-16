<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    protected $fillable = [
        'nik_penduduks',
        'id_surat_keluar',
        'status',
        'images',
        'attribute',
        'keperluan',
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
        'nik_penduduks',
        'id_surat_keluar',
        'status',
        'images',
        'attribute',
        'keperluan',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'nik_penduduks',
        'id_surat_keluar',
        'status',
        'images',
        'attribute',
        'keperluan',
        'updated_at',
        'created_at',
    ];
}
