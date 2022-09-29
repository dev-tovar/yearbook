<?php

namespace App\Models;

use App\Like;
use App\User;
use App\UsersYearBook;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed value
 * @property TemplateFields field
 */
class PageContent extends Model
{
    protected $fillable = ['page_id', 'field_id', 'value'];

    protected $with = ['field', 'likes'];

    protected $appends = ['like'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function field()
    {
        return $this->belongsTo(TemplateFields::class, 'field_id');
    }

    public function getLikeAttribute()
    {
        if ($this->field) {
            if (in_array($this->field->type,
                [
                    'gallery',
                    'two_images',
                    'three_images',
                    'four_images',
                    'image',
                ])
            ) {
                $user_id = Auth::id();
                return [
                    'count' => $this->likes()->count(),
                    'isLike' => $this->likes()
                            ->where('user_id', $user_id)
                            ->first() != null,
                ];

            }
        }

        return null;
    }

//    public function getMarksAttribute()
//    {
//        if ($this->field->type !== 'image') {
//            return null;
//        }
//
//        $src = json_decode($this->value) ? json_decode($this->value)->src : null;
//
//        if ($src) {
//            $idUsersMark = MarkImage::confirm()->where('src', $src)->groupBy('marked')->pluck('marked')->toArray();
//            return User::whereIn('id', $idUsersMark)->with('users_yearbooks')->get();
//        }
//
//        return null;
//    }

    public function getValueAttribute($value)
    {
        $page = Page::find($this->page_id);
        if (!$page) {
            return null;
        }
        if (optional($page->realCategory())->name == 'Grades') {
            $value = json_decode($value, true);
            try {
                $user = UsersYearBook::find($value['user_id'])->user;
                $value['user_real_id'] = $user->id;

            } catch (\Exception $exception) {
                $value['user_real_id'] = null;
            }


            $value = json_encode($value);
        }

        if (in_array($this->field->type, TemplateFields::TYPE_IMAGES) && $value != 'null') {
            $res = [];
            $valueArr = gettype($value) == 'object' ? $value : json_decode($value);

            if (is_array($valueArr)) {
                foreach ($valueArr as $item) {
                    if (is_object($item->path)) {
                        $src = $item->path->src;

                    } else {
                        $src = $item->path;
                    }

                    $item->countMarks = MarkImage::query()
                        ->select(DB::raw("count(DISTINCT marked) as cnt"))
                        ->where(['src' => $src, 'confirm' => 1])
                        ->first()->cnt;
                    $res[] = $item;
                }
            } else {
                if (!$valueArr) {
                    return null;
                }

                $valueArr->countMarks =
                    MarkImage::query()
                        ->select(DB::raw("count(DISTINCT marked) as cnt"))
                        ->where(['src' => $valueArr->src, 'confirm' => 1])
                        ->first()->cnt;
                $res = $valueArr;
            }

            return json_encode($res);
        }

        return $value;
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'page_content_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->select('page_contents.*',
                'tf.position as position')
                ->orderBy('position')
                ->leftJoin('template_fields as tf', 'page_contents.field_id', '=',
                    'tf.id');
        });
    }

    public function scopeOrders($query)
    {
        return $query;//->select('page_contents.*',
//            'tf.position as position')
//            ->orderBy('position')
//            ->leftJoin('template_fields as tf', 'page_contents.field_id', '=',
//                'tf.id');
    }
}
