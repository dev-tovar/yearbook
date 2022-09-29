<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed pushable_id
 */
class PushStack extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $fillable = [
    	'title',
	    'recipient',
	    'custom',
	    'device',
	    'image',
        'pushable_id',
        'pushable_type'
    ];


    public function pushable()
    {
        return $this->morphTo();
    }

    public function hasPushable()
    {
        //return !is_null($this->pushable_id) && $this->pushable_id !== 0;
    }
}
