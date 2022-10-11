<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\School;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class SchoolController extends Controller
{

    public function index($id)
    {
        $school = School::find($id);

        return view('admin.school.index', [
            'school' => $school
        ]);
    }

    public function show($id)
    {
        $school = School::find($id);
//        if (policy(Auth::user())->get(Auth::user(), $school)) {
        return view('admin.school.index', [
            'school' => $school
        ]);
//        }
//        else {
//            return response('Forbidden', 403);
//        }
    }

    public function feeds($schoolId)
    {
        $school = School::find($schoolId);

        return view('admin.feeds.index', [
            'school' => $school
        ]);
    }

    public function users($schoolId)
    {
        $school = School::find($schoolId);

        return view('admin.user_manager', [
            'school' => $school
        ]);
    }

    public function content($schoolId)
    {
        $school = School::find($schoolId);

        return view('admin.content_manager', [
            'school' => $school
        ]);
    }

    public function contacts($id)
    {

    }
}
