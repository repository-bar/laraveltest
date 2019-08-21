<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    /**
     * Get the user that owns the news.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
