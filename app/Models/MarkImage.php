<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property Collection contents
 */
class MarkImage extends Model
{
    const TYPE_FOR_PUSH = 'mark_image';
    /**
     * @var string[]
     */
    protected $fillable
        = [
            'path',
            'src',
            'type',
            'who_mark',
            'marked',
            'confirm',
            'yearbook_id',
            'is_confirm',
        ];

    /**
     * @param $query
     * @param $src
     * @param $whoMark
     * @param $marked
     * @return mixed
     */
    public function scopeFindMark($query, $src, $whoMark, $marked)
    {
        return $query->where('src', $src)->where('who_mark', $whoMark)->where('marked', $marked);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeConfirm($query)
    {
        return $query->where('confirm', 1);
    }

}
