<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class starwarfilm_detail extends Model
{
    use HasFactory;

    protected $table = "starwarfilm_detail";

    protected $fillable = [
        'film_id',
        'title',
        'episode_id',
        'opening_crawl',
        'director',
        'producer',
        'release_date',
        'characters',
        'planets',
        'starships',
        'vehicles',
        'species',
        'created',
        'edited',
        'url',
    ];
}
