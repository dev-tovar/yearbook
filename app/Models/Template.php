<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = ['name', 'category_id', 'category_name'];

    public function category()
    {
        return $this->belongsTo(ContentCategory::class, 'category_id');
    }

    public function fields()
    {
        return $this->hasMany(TemplateFields::class);
    }

}
