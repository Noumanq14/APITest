<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class starwar_films extends Model
{
    use HasFactory;

    protected $table = "starwar_films";

    protected $fillable = [
        'count',
        'next',
        'previous',
        'results'
    ];
}
