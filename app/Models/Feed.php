<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as MyBuilder;


class Feed extends Model
{
    protected $fillable
        = [
            'school_id',
            'title',
            'recipients',
            'message',
            'link',
            'attach',
        ];

    protected $appends = ['time', 'attachment'];

    public function getTimeAttribute()
    {
        return $this->created_at->format('M d, Y h:i a');
    }

    public function getAttachmentAttribute()
    {
        $res = [];
        if ($this->attach) {
            $attach = json_decode($this->attach);
            foreach ($attach as $att) {
                $res[] = [
                    'mime' => $att->mime,
                    'full_path' => $att->src,
                    'cover' => $att->path,
                ];
            }
        }

        return $res;
    }

    public function getCountViewsAttribute()
    {
        return FeedView::query()->where('feed_id', $this->id)->count();
    }


    public function school()
    {
        return $this->belongsTo('school_id');
    }


    public function attachments()
    {
        return $this->hasMany(FeedAttachment::class);
    }

//    /**
//     * @param Builder $query
//     * @param $grade
//     */
//    public function scopeWhereGrades($query, $grade){
//
//    }

    public function grades()
    {
        return $this->hasMany(FeedGradeLevels::class);
    }

    /**
     * @param Builder $query
     * @param         $search
     */
    public function scopeSearch($query, $search)
    {
        $query->where(function ($sQuery) use ($search) {
            $sQuery->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('message', 'LIKE', '%' . $search . '%');
        });
    }

    /**
     * @param Builder $query
     * @param         $dateFrom
     */
    public function scopeDateFrom($query, $dateFrom)
    {
        $query->where('created_at', '>=',
            Carbon::parse($dateFrom)->format('Y-m-d 00:00:00'));
    }

    /**
     * @param Builder $query
     * @param         $dateTo
     */
    public function scopeDateTo($query, $dateTo)
    {
        $query->where('created_at', '<=',
            Carbon::parse($dateTo)->format('Y-m-d 23:59:59'));
    }

    /**
     * @param Builder $query
     * @param         $recipient
     */
    public function scopeRecipient($query, $recipient)
    {
        $query->where('recipients', '=', strtolower($recipient));
    }

    /**
     * @param Builder $query
     * @param array $filter
     *
     * @return mixed
     */
    public function scopeFilter($query, array $filter)
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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (MyBuilder $builder) {
            $builder->orderByDesc('id');
        });
    }
}
