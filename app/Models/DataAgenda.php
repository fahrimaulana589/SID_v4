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

    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id_agenda',

    ];


    public function agenda(){
        return $this->belongsTo(Agenda::class,'id_agenda');
    }

}
