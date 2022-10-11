<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class AdminLoginController extends Controller
{
    public function __construct()
    {
//        $this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::guard('admin')->user();
            if ($user->hasRole('super-admin')) {
                return redirect()->action('Admin\DashboardController@index');
            } elseif ($user->hasRole('admin')) {
                $schoolId = $user->user->yearbook()->first()->school_id;
                return redirect()->action('Admin\YearBookController@index', ['school_id' => $schoolId]);
            } elseif ($user->hasRole('content_manager')) {
                return redirect()->action('Admin\ContentManagerController@index',
                    [
                        'name' => 'cover',
                        'id' => $user->getSchool()->id,
                        'yearbook_id' => $user->getSchool()->yearbooks()->first()->id
                    ]);

            } elseif ($user->hasRole('news_feed')) {
                return redirect()->action('Admin\NewsFeedController@index',
                    ['id' => $user->getSchool()->id]);
            } else {
                Auth::guard('admin')->logout();
                \request()->session()->flush();

                throw new AuthenticationException();
            }

        }

        $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
        return redirect()->back()->withErrors($errors)->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        if (isset($_COOKIE['school_id'])) {
            unset($_COOKIE['school_id']);
            setcookie('school_id', '', time() - 3600, '/');
        }

        Auth::guard('admin')->logout();
        $request->session()->flush();

        throw new AuthenticationException();
    }

    public function backSuperAdmin()
    {
        Session::forget('customAdmin');
        if (isset($_COOKIE['school_id'])) {
            unset($_COOKIE['school_id']);
            setcookie('school_id', '', time() - 3600, '/');
        }
        $user = \Illuminate\Support\Facades\Auth::user();

        \Illuminate\Support\Facades\Auth::logout();
        try {
            if ($user->oldUser) {
                \Illuminate\Support\Facades\Auth::login($user->oldUser);
            }
        } catch (\Exception $exception) {
        }


        return redirect()->intended(action('Admin\DashboardController@index'));
    }
}
