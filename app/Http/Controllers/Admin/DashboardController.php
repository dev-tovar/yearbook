<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Contract;
use App\Repositories\UserRepository;
use App\Models\School;
use App\Models\User;
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
        if (Auth::guard('admin')->user()->hasRole('super-admin')) {
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

            return  $data;

            // return view('admin.dashboard', [
            //     'data' => $data,
            // ]);

        } elseif (Auth::guard('admin')->user()->hasRole('admin')) {
            /** @var School $school */
            $school = Auth::guard('admin')->user()->getSchool();

            return redirect()->action('Admin\YearBookController@index', ['school_id' => $school]);
        } elseif (Auth::guard('admin')->user()->hasRole('content_manager')) {
            return redirect()->action('Admin\ContentManagerController@index',
                [
                    'name' => 'cover',
                    'id' => Auth::guard('admin')->user()->getSchool()->id,
                    'yearbook_id' => Auth::guard('admin')->user()->getSchool()->yearbooks()->first()->id
                ]);

        } elseif (Auth::guard('admin')->user()->hasRole('news_feed')) {
            return redirect()->action('Admin\NewsFeedController@index',
                ['id' => Auth::guard('admin')->user()->getSchool()->id]);
        }

        Auth::guard('admin')->logout();
        \request()->session()->flush();

        throw new AuthenticationException();
    }
}
