<?php

namespace App\Models;

use App\Models\NotificationRead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PushHistory extends Model
{
    //
    protected $fillable
        = [
            'user_id',
            'image',
            'title',
            'is_read',
            'type'
        ];

    public function read()
    {
        return $this->hasMany(NotificationRead::class, 'notification_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('push_histories.id');
        });
    }

    public function push_stack()
    {
        return $this->morphOne('App\PushStack', 'pushable');
    }
}
