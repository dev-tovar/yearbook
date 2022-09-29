<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'school_id', 'original_name', 'size', 'path'
    ];

    public function school() {
        return $this->belongsTo(School::class);
    }
}
