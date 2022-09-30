<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UsersYearBook;
use App\Models\YearBook;
use Illuminate\Support\Facades\DB;

class YearBookRepository
{
    public function switchTribute($yearbookId)
    {
        $yearbook = YearBook::query()->find($yearbookId);
        if ($yearbook) {
            $yearbook->is_student_tribute = !$yearbook->is_student_tribute;
            $yearbook->save();
        }

        return true;
    }

    public function getInviteUsers($yearbookId, $currentUserId)
    {
        return User::query()
            ->select('users.*', 'uyb.yearbook_id', 'uyb.avatar as user_avatar', 'uyb.is_faculty as is_faculty_yearbook')
            ->where('user_type', 'student')
            ->join('users_year_books as uyb', function ($j) use ($yearbookId) {
                $j->on('uyb.user_id', '=', 'users.id')->where('uyb.yearbook_id', $yearbookId);
            })
            ->get();
    }

    public function getNextYearbook($yearbookId)
    {
        $schoolId = YearBook::query()->select('school_id')->where('id', $yearbookId)->first()->school_id;
        return YearBook::query()
            ->where('school_id', $schoolId)
            ->where('id', '>', $yearbookId)
            ->first();
    }

    public function getUserIds($yearbookId)
    {
        return UsersYearBook::query()
            ->where('yearbook_id', $yearbookId)
            ->pluck('user_id');
    }

    public function addUserYearbook($data)
    {
        DB::table('users_year_books')->insert($data);
    }

    public function hasYearbook($yearbookId, $userId)
    {
        return UsersYearBook::query()
                ->where('user_id', $userId)
                ->where('yearbook_id', $yearbookId)
                ->first() != null;
    }

    public function getGradeLvl($yearbookId, $userId)
    {
        return optional(UsersYearBook::query()
            ->where('user_id', $userId)
            ->where('yearbook_id', $yearbookId)
            ->first())->grade_level;
    }
}