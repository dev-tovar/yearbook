<?php

namespace App\Models;

use App\Models\Traits\RoleUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;



class Admin extends Authenticatable
{
    use Notifiable, RoleUser;

    protected $guard = 'admin';

    protected $fillable
        = [
            'name',
            'email',
            'password',
            'user_id',
        ];

    protected $hidden
        = [
            'password',
            'remember_token',
        ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_roles',
            'user_id', 'role_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getSchool()
    {
        if (Session::get('customAdmin')) {
            return $this->user->school;
        } else {
            return $this->user->yearbook()->first()->school;
        }
    }

    public function getFakeAdmin($school)
    {
        $admin = Admin::whereHas('user',
            function ($q) use ($school) {
                $q->whereHas('users_yearbooks', function ($qq) use ($school) {
                    $qq->whereHas('yearbook', function ($qqq) use ($school) {
                        $qqq->where('school_id', $school->id);
                    });
                });
            })->first();

        $admin->oldUser = Auth::user();

        return $admin;
    }
}
