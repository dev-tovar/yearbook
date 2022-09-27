<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventVisit extends Model
{
    public $timestamps = false;
    public $table = 'event_visit';

    protected $fillable = [
        'event_id', 'user_id', 'status'
    ];

}
