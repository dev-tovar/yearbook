<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository
{
    public function getCountPaidUsers()
    {
        return User::query()
            ->join('users_year_books as uyb', 'uyb.id','=','users.id')
            ->where('uyb.status','paid')
            ->where('users.user_type','student')
            ->count();
    }
}