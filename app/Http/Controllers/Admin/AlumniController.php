<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AlumniPushRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('admin')) {
            return redirect()->back();
        }

        $selectedYear = $request->year;
        $search = $request->search;

        $list = User::alumni(Auth::user()->getSchool()->id)->alumniFilter($selectedYear, $search)->paginate(50);

        $years = Auth::user()->getSchool()->getAlumniYears();
        $school = Auth::user()->getSchool();

        return view('admin.alumni.index', compact('list', 'years', 'selectedYear', 'search', 'school'));
    }

    public function getInfo($id)
    {
        /** @var User $user */
        $user = User::alumni(Auth::user()->getSchool()->id)->find($id);
        $user->avatars = $user->getAlumniAvatars();
        return view('admin.alumni.info', compact('user'));
    }

    public function view(Request $request, $id)
    {
        if (Gate::denies('admin')) {
            return redirect()->back();
        }

        $user = User::find($id);
        $school = Auth::user()->getSchool();

        return view('admin.alumni.viewStudentForm', compact('user', 'school'));
    }

    public function push(AlumniPushRequest $request)
    {
        $data = $request->except('_token');
        if (!key_exists('levels', $data)) {
            $levels = ['All'];
        } else {
            $levels = array_unique($data['levels']);
        }

        if (User::alumniPushNotification($data['message'], 'alumni',
            $data['school_id'], $levels)
        ) {
            return redirect()->back()
                ->with('success-message', 'Notification sent');
        } else {
            return redirect()->back()
                ->with('error-message', 'Error send notifications!');
        }

    }
}
