<?php

namespace App\Policies;

use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SchoolPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get($user, School $school) {
        if (Session::get('customAdmin')) {
            return true;
        } elseif (Auth::guard('admin')->user()->hasRole('super-admin')) {
            return true;
        }
        if ($user->getSchool()->id == $school->id) {
            return true;
        }
        return false;
    }
}
