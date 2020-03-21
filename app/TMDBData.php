<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TMDBData extends Model
{
    //
    protected $fillable = ['tmdb_id', 'user_id', 'original_title', 'genre', 'primary_release_date', ];
}
