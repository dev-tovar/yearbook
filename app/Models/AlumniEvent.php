<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder as MyBuilder;
use Illuminate\Database\Eloquent\Model;

class AlumniEvent extends Model
{
    protected $fillable = [
        'school_id',
        'title',
        'recipients',
        'message',
        'link',
        'attach',
    ];

    protected $appends = ['time', 'attachment'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (MyBuilder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function grades()
    {
        return $this->hasMany(EventsLevel::class, 'event_id');
    }

    public function eventVisits()
    {
        return $this->hasMany(EventVisit::class, 'event_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_visit', 'event_id', 'user_id')->withPivot('status');
    }

    /**
     * @return mixed
     */
    public function getTimeAttribute()
    {
        return $this->created_at->format('M d, Y h:i a');
    }

    public function getAttachmentAttribute()
    {
        $res = [];
        if ($this->attach) {
            $res = collect(json_decode($this->attach))
                ->map(function ($item) {
                    return [
                        'mime'      => $item->mime,
                        'full_path' => $item->src,
                        'cover'     => $item->path,
                    ];
                })
                ->toArray();
        }

        return $res;
    }

    public function scopeFilter($query, Array $filter)
    {
//    	dd($filter);
        if (isset($filter['search']) && $filter['search'] != null) {
            $query->search($filter['search']);
        }
        if (isset($filter['date_start']) && $filter['date_start'] != null) {
            $query->dateFrom($filter['date_start']);
        }
        if (isset($filter['date_end']) && $filter['date_end'] != null) {
            $query->dateTo($filter['date_end']);
        }
        if (isset($filter['recipient']) && $filter['recipient'] != null) {
            $query->recipient($filter['recipient']);
        }

        return $query;
    }

    public static function getCountByStatus($status)
    {

    }
}
