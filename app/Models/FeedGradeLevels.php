<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedGradeLevels extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'feed_id', 'grade'
    ];


}
