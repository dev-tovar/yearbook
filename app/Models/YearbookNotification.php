<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YearbookNotification extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable
        = [
            'message',
            'type',
            'is_dot',
            'is_read',
            'user_id',
            'from_user_id',
            'yearbook_id',
            'wall_id',
            'data',
            'is_action'
        ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function yearbook()
    {
        return $this->belongsTo(YearBook::class, 'yearbook_id');
    }

    public function wall()
    {
        return $this->belongsTo(Wall::class);
    }
}
