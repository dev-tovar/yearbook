<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * @property Collection contents
 */
class Page extends Model
{
    protected $fillable
        = [
            'template_id',
            'category_id',
            'is_publish',
            'user_id',
            'is_app_publish',
        ];

    protected $with = ['contents','user'];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public static function formatSt($pages)
    {
        foreach ($pages as &$page) {
            $page->user->avatar
                = $page->user->getImage($page->category->year_book_id);
        }

        return $pages;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ContentCategory::class, 'category_id');
    }

    public function contents()
    {
        return $this->hasMany(PageContent::class)->orders();
    }

    public function realCategory()
    {
        if ($parentCategory = optional($this->category)->parentCategory) {
            return $parentCategory;
        }

        return $this->category;
    }

    public function subCategory()
    {
        if ($parentCategory = optional($this->category)->parentCategory) {
            return $this->category;
        }

        return null;
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->orderBy('position', 'ASC')
                ->orderBy('id', 'ASC');
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_app_publish',true);
    }

    public function scopePublishedInAdmin($query)
    {
        return $query->where('is_publish',true);
    }

    /**
     * @return Collection
     */
    public function resolveImageJson()
    {
        return $this->contents->map(function (PageContent $pageContent) {
            if($pageContent->field->type == TemplateFields::IMAGE) {
                $data = json_decode($pageContent->value);
                if(is_array($data)) {
                    $pageContentArray = json_decode($pageContent->value)[0]->path;
                } else {
                    $pageContentArray = $data;
                }
              // dd($pageContentArray);
                return $pageContent->setAttribute('value', json_encode($pageContentArray));
            }

            return $pageContent->setAttribute('value', $pageContent->getAttribute('value'));
        });
    }
}
