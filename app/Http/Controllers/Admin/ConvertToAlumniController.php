<?php

namespace App\Http\Controllers\Admin;

use App\UsersYearBook;
use App\Http\Controllers\Controller;

class ConvertToAlumniController extends Controller
{
    public function __invoke($school_id)
    {
        UsersYearBook::whereHas('yearbook', function ($q)  use ($school_id) {
//            $q->where('year_to', now()->format('Y'));
            $q->where('school_id', $school_id);
        })->where('grade_level',12)->update(['is_alumni'=>true]);

        return redirect()->route('alumni.index');
    }
}
