<?php

namespace App\Models;

use App\School;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Donate extends Model
{
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function scopeSearch($query, $search)
    {
        $query->whereHas('users', function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        })
        ->orWhere('amount', $search);
    }
}
