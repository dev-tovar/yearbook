<?php

namespace App\Models;

use App\School;
use Illuminate\Database\Eloquent\Model;

class AlumniPushHistory extends Model
{
    protected $guarded = ['id'];

    public function scopeNotRead($query)
    {
        return $query->where('is_read', 0);
    }

    public function push_stack()
    {
        return $this->morphOne('App\PushStack', 'pushable');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
