<?php

namespace App\Models;

use App\YearBook;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property YearBook yearbook
 */
class ContentCategory extends Model
{
    protected $fillable
        = [
            'name',
            'can_edit',
            'year_book_id',
            'parent_category_id',
            'position',
        ];

    public function yearbook()
    {
        return $this->belongsTo(YearBook::class, 'year_book_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(ContentCategory::class, 'parent_category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(ContentCategory::class, 'parent_category_id');
    }

    public function templates()
    {
        return $this->hasMany(Template::class, 'category_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'category_id');
    }

    public function scopeRoot($query)
    {
        return $query->where('parent_category_id', null);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->orderBy('position','ASC')
                ->orderBy('id','ASC');
        });
    }
}
