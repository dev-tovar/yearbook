<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
