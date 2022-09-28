<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @method Builder where(string $string, int $id)
 * @property Collection users
 */
class YearBook extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable
        = [
            'school_id',
            'year_from',
            'year_to',
            'image',
            'is_student_tribute'
        ];

}
