<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed type
 */
class TemplateFields extends Model
{

    const TWO_IMAGES = 'two_images';
    const IMAGE = 'image';
    const GALLERY = 'gallery';
    const THREE_IMAGES = 'three_images';
    const FOUR_IMAGES = 'four_images';
    const TYPE_IMAGES = [self::FOUR_IMAGES, self::GALLERY, self::IMAGE, self::THREE_IMAGES, self::TWO_IMAGES];

    /**
     * @var array
     */
    protected $fillable  = [
            'type',
            'name',
            'position',
            'title',
            'template_id',
            'limits',
        ];

    public function template()
    {
        return $this->hasMany(Template::class);
    }


}
