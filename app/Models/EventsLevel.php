<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsLevel extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'event_id', 'grade'
    ];

}
