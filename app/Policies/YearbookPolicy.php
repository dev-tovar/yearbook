<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UsersYearBook;
use App\Models\YearBook;
use Illuminate\Auth\Access\HandlesAuthorization;

class YearbookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the year book.
     *
     * @param  \App\Models\User     $user
     * @param  \App\Models\YearBook $yearBook
     *
     * @return mixed
     */
    public function view(User $user, YearBook $yearBook)
    {
        $userType = $this->user_type;
        switch ($userType) {
            case 'student':
                $ybUser = UsersYearBook::where([
                    'yearbook_id' => $yearBook->id,
                    'user_id'     => $user->id,
                    'is_buy'      => true,
                ])
                    ->first();

                return $ybUser != null;
                break;
            case 'parent':
                $ids = $user->childes()->pluck('id');
                $ybUser = UsersYearBook::where([
                    'yearbook_id' => $yearBook->id,
                    'user_id'     => $user->id,
                    'is_buy'      => true,
                ])
                    ->whereIn('user_id',$ids)
                    ->first();

                return $ybUser != null;
                break;
            default:
                return false;
        }
    }
}
