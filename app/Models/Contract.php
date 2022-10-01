<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Yearbook AS YBHelper;

class Contract extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'school_id', 'original_name', 'size', 'path'
    ];

    public function school() {
        return $this->belongsTo(School::class);
    }

    protected $appends = ['size_to_human'];

    public function getSizeToHumanAttribute()
    {
        return   YBHelper::bytesToHuman($this->size);

    }

}
