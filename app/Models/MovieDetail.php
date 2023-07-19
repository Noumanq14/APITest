<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'adult',
        'backdrop_path',
        'belongs_to_collection',
        'budget',
        'genres',
        'homepage',
        'movie_id',
        'imdb_id',
        'original_language',
        'original_title',
        'overview',
        'popularity',
        'poster_path',
        'production_companies',
        'production_countries',
        'release_date',
        'revenue',
        'runtime',
        'spoken_languages',
        'status',
        'tagline',
        'title',
        'video',
        'vote_average',
        'vote_count'
    ];
}
