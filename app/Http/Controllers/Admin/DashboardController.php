<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Contract;
use App\Repositories\UserRepository;
use App\School;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        if (Auth::user()->hasRole('super-admin')) {
            $data = [
                'totalSchools' => School::count(),
                'schoolsWithContract' => School::whereHas('contract')->count(),
                'allUsers' => User::all()->count(),
                'totalStudents' => User::where('user_type', '=',
                    'student')
                    ->where('password', '!=', null)
                    ->count(),
                'totalParents' => User::where('user_type', '=', 'parent')
                    ->count(),
                'totalPaidUsers' => $this->userRepository->getCountPaidUsers(),
                'totalAdmins' => Admin::whereHas('roles',
                    function ($q) {
                        $q->where('key', 'super-admin');
                    })->count(),
            ];
            return view('admin.dashboard', [
                'data' => $data,
            ]);
        } elseif (Auth::user()->hasRole('admin')) {
            /** @var School $school */
            $school = Auth::user()->getSchool();

            return redirect()->action('Admin\YearBookController@index', ['school_id' => $school]);
        } elseif (Auth::user()->hasRole('content_manager')) {
            return redirect()->action('Admin\ContentManagerController@index',
                [
                    'name' => 'cover',
                    'id' => Auth::user()->getSchool()->id,
                    'yearbook_id' => Auth::user()->getSchool()->yearbooks()->first()->id
                ]);

        } elseif (Auth::user()->hasRole('news_feed')) {
            return redirect()->action('Admin\NewsFeedController@index',
                ['id' => Auth::user()->getSchool()->id]);
        }

        Auth::guard('admin')->logout();
        \request()->session()->flush();

        throw new AuthenticationException();
    }
}
