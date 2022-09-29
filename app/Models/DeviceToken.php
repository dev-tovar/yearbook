<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = ['token','user_id','device','version'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
