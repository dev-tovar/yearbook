<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wall extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable
        = [
            'message',
            'status',
            'user_id',
            'from_user_id',
            'yearbook_id',
            'approve_date',
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

    public function notifications()
    {
        return $this->hasMany(YearbookNotification::class);
    }
}
