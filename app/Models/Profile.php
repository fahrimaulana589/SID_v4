<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Profile extends Model
{
    use RoleAccess, Filterable, AsSource, Chartable, HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    protected $fillable = [
        "name",
        "sambutan",
        "description",
        "logo",
        "background",
        "slogan",
        "kepala_desa",
        "sambutan_kepala_desa",

    ];

    protected $allowedSorts = [
        "name",
        "sambutan",
        "description",
        "logo",
        "background",
        "slogan",
        "kepala_desa",
        "sambutan_kepala_desa",

    ];

    protected $allowedFilters = [
        "name",
        "sambutan",
        "description",
        "logo",
        "background",
        "slogan",
        "kepala_desa",
        "sambutan_kepala_desa",
    ];
}
