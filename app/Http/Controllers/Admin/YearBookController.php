<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Models\Page;
use App\Repositories\YearBookRepository;
use App\School;
use App\User;
use App\YearBook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class YearBookController extends Controller
{
    protected $yearBookRepository;

    public function __construct(YearBookRepository $yearBookRepository)
    {
        $this->yearBookRepository = $yearBookRepository;
    }

    public function index(Request $request)
    {
        /** @var School $school */
        try {
            $school = School::findOrFail($request->school_id);
            $yearBooks = $school
                ->yearbooks()
                ->get();

            if (Auth::user()->hasRole('super-admin')) {
                $newAdmin = Auth::user()->getFakeAdmin($school);
                Session::put('customAdmin', $newAdmin);
                Auth::logout();
                Auth::login($newAdmin);

                setcookie($_COOKIE['school_id'] = $school->id);
            }

            if (policy(User::class)->get(Auth::user(), $school)) {

                return response(view('admin.year_books.year_books', [
                    'yearbooks' => $yearBooks,
                    'school_id' => $request->school_id,
                ]))->cookie('school_id', $school->id, 45000);
            } else {
                return response('Forbidden', 403);
            }
        } catch (\Exception $exception) {
            Log::error($exception);

            return response($exception->getMessage(), 404);
        }
    }

    public function publish($id)
    {
        Page::where('is_publish', true)
            ->whereHas('category', function ($q) use ($id) {
                $q->where('year_book_id', $id);
            })->update(['is_app_publish' => true]);

        return redirect()->back();//['status' => true];
    }

    public function finalPublish($id)
    {

        Page::where('is_publish', true)
            ->whereHas('category', function ($q) use ($id) {
                $q->where('year_book_id', $id);
            })->update(['is_app_publish' => true]);

        return redirect()->back();//['status' => true];
    }

    public function changeTribute()
    {
        $id = request()->route('yearbook_id');
        $this->yearBookRepository->switchTribute($id);

        return ['status' => true];
    }
}
