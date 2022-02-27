<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataAgenda extends Model
{
    use RoleAccess, Filterable, AsSource, Chartable, HasFactory;

    protected $fillable = [
        'id_agenda',
        'name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'profession',
        'address',
        'religion',
        'education',
        'status',
        'necessity'
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
        'id_agenda',
        'name',
        'place_of_birth',
        'date_of_birth',
        'gender','profession',
        'address','religion',
        'education',
        'status',
        'necessity'
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id_agenda',
        'name',
        'place_of_birth',
        'date_of_birth',
        'gender','profession',
        'address','religion',
        'education',
        'status',
        'necessity'
    ];


    public function agenda(){
        return $this->belongsTo(Agenda::class,'id_agenda');
    }

}
