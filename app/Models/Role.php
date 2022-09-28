<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = ['key', 'value'];

    public static function admin() {
    	$admin = self::where('key', 'admin')->get();
    	if ($admin->count() > 0) {
    		return $admin->first()->id;
	    }
	    else {
	    	return null;
	    }
    }

    public static function superAdmin() {
	    $admin = self::where('key', 'super-admin')->get();
	    if ($admin->count() > 0) {
		    return $admin->first()->id;
	    }
	    else {
		    return null;
	    }
    }

}
