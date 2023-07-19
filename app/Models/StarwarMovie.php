<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarwarMovie extends Model
{
    use HasFactory;

    protected $table = "starwar_movie";

    protected $fillable = [
        'name',
        'overview',
        'poster_path',
        'backdrop_path',
        'parts',
        'movie_id'
    ];
}
