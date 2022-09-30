<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Enums\UserAppStatus;
use App\Events\PushEvent;
use App\Exports\UsersExport;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UserImportFileRequest;
use App\Http\Requests\UsersPushRequest;
use App\Repositories\YearBookRepository;
use App\Models\School;
use App\Services\Admin\UserService;
use App\Services\User\CSVImporter;
use App\Services\User\XMLmporter;
use App\Models\User;
use App\Models\UsersYearBook;
use App\Models\YearBook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaveUser;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class UsersManagerController extends Controller
{

    const XML = 'text/xml';
    const CSV = 'text/csv';

    protected $yearbookRepository;
    protected $userService;

    public function __construct(YearBookRepository $yearbookRepository, UserService $userService)
    {
        $this->yearbookRepository = $yearbookRepository;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $this->authorize('yearbook.publish');
        try {
            $yearbookId = $request->get('yearbook_id');
            /** @var YearBook $yearbook */
            $yearbook = YearBook::find($yearbookId);
            $users = $yearbook->yearbook_users()->with(['user', 'user.parents'])
                ->whereHas('user', function ($q) use ($request) {
                    return $q->filter($request->all());
                })
                ->myorder()
                ->paginate(100);
            $school = School::findOrFail($request->get('school_id') ?? $yearbook->school_id);

            if (policy(User::class)->get(Auth::user(), $school)) {
                $nextYearbook = $this->yearbookRepository->getNextYearbook($yearbookId);
                $schools = School::query()
                    ->select('schools.*', DB::raw('max(yb.id) as lastYbId'))
                    ->join('year_books as yb', 'schools.id', '=', 'yb.school_id')
                    ->groupBy(['schools.id'])
                    ->get();
                return view('admin.user_manager', [
                    'school' => $school,
                    'school_id' => $school->id,
                    'schools' => $schools,
                    'users' => $users,
                    'request' => $request,
                    'yearbook_id' => $yearbookId,
                    'nextYearbook' => $nextYearbook,
                    'grades' => \App\Helpers\Yearbook::$grades,
                    'moveSuccess' => $request->move_success ?? 0,
                ]);
            } else {
                return response('Forbidden', 403);
            }
        } catch (\Exception $exception) {
            Log::error($exception);

            return response($exception->getMessage(), 404);
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @deprecated
     *
     */
    public function filter(Request $request)
    {
        $this->authorize('yearbook.publish');
        $school = School::findOrFail($request->school_id);
        $users = User::filtered($request->all());

        return view('admin.user_manager', [
            'school' => $school,
            'users' => $users,
            'yearbook_id' => $request->yearbook_id,
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('yearbook.publish');
        try {
            $school = School::findOrFail($request->school_id);
            if (policy(User::class)->get(Auth::user(), $school)) {
                return view('admin.school.createStudentForm', [
                    'school' => $school,
                    'grades' => \App\Helpers\Yearbook::$grades,
                    'yearbook_id' => $request->yearbook_id,
                ]);
            } else {
                return response('Forbidden', 403);
            }
        } catch (\Exception $exception) {
            Log::error($exception);

            return response($exception->getMessage(), 404);
        }
    }

    public function store(StoreSaveUser $request)
    {
        $data = $request->all();
        $data['school_id'] = $request->school_id;
        $data['is_admin'] = intval(isset($data['is_admin']));
        $data['is_faculty'] = intval(isset($data['is_faculty']));
        if ($data['school_id']) {
            /** @var User $user */
            $user = User::create($data);
            if (!$user->isPresentInYearBook($request->yearbook_id)) {
                $user->assignToYearBook($request->yearbook_id, $data);
            }
        }
        if ($data['user_type'] === "admin") {
            $userId = $user->id;
            $data['user_id'] = $userId;
            $role = Role::where('key', '=', 'admin')->first();
            Admin::create($data)->roles()->attach($role);
        }

        return redirect()->action('Admin\UsersManagerController@index',
            [
                'school_id' => $data['school_id'],
                'yearbook_id' => $request->yearbook_id,
            ]
        )->with('success-message',
            sprintf('User <strong>"%s"</strong> was successfully created',
                $user->name));
    }

    public function destroy($id, Request $request)
    {
        /** @var User $user */
        $user = UsersYearBook::find($request->user_id);
        if ($user) {
            $name = $user->user->name;
            $user->delete();
            return redirect()->back()->with('success-message',
                sprintf('User <strong>"%s"</strong> was successfully deleted',
                    $name));
        }

        return redirect()->back();
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('yearbook.publish');
        try {
            /** @var UsersYearBook $userYear */
            $userYear = UsersYearBook::find($id);

            $school = $userYear->yearbook()->first()->school;
            $user = $userYear->user;

            $yearbook_id = $userYear->yearbook_id;

            if (policy(User::class)->get(Auth::user(), $school)) {
                return view('admin.school.editStudentFrom', [
                    'user' => $user,
                    'school' => $school,
                    'userYear' => $userYear,
                    'grades' => \App\Helpers\Yearbook::$grades,
                    'yearbook_id' => $yearbook_id,
                ]);
            } else {
                return response('Forbidden', 403);
            }
        } catch (\Exception $exception) {
            Log::error($exception);

            return response($exception->getMessage(), 404);
        }
    }

    public function update(StudentRequest $request, $user_id)
    {
        $data = $request->except('_token');
        $data = array_filter($data);
        $data['is_admin'] = intval(isset($data['is_admin']));
        $data['is_alumni'] = intval(isset($data['is_alumni']));
        $data['is_faculty'] = intval(isset($data['is_faculty']));
        $data['is_content_manager'] = intval(isset($data['is_content_manager']));
        $data['is_news_feed'] = intval(isset($data['is_news_feed']));
        $data['is_school_admin'] = intval(isset($data['is_school_admin']));
        /** @var User $user */
        $user = User::query()->find($user_id);
        $this->isAdmin($user_id, $data);
        if (key_exists('password', $data)) {
            unset($data['password']);
        }
        $user->update($data);
        $user->users_yearbooks()->where('yearbook_id', $request->yearbook_id)
            ->first()->update($data);

        return redirect()->action('Admin\UsersManagerController@index', [
            'school_id' => $request->school_id,
            'yearbook_id' => $request->yearbook_id,
        ])->with('success-message',
            sprintf('User <strong>"%s"</strong> was successfully updated',
                $user->name));
    }

    public function isAdmin($userId, $data)
    {
        $data['user_id'] = $userId;
        $user = User::query()->find($userId);
        $admin = Admin::query()->where('user_id', '=', $userId)->first();

        if ($data['is_admin'] || $data['is_school_admin']) {
            if (!$admin) {
                if ($data['is_school_admin']) {
                    $data['password'] = User::generatePassword();
                    $email = $user->email ?? $data['email'];
                    $mailData = [
                        'email' => $email,
                        'password' => $data['password'],
                    ];
                    Mail::send('mail.student-admin', $mailData,
                        function ($m) use ($email) {
                            $m->to($email)
                                ->subject('Student Admin Credentials');
                        });
                }
                /** @var Admin $admin */
                $admin = Admin::query()->create($data);
            } else {
                $admin->update($data);
            }
            $admin->roles()->detach();
            if ($data['is_admin']) {
                $role = Role::query()->where('key', 'admin')->first();
                $admin->roles()->attach($role);
            } else {
                if ($data['is_content_manager']) {
                    $role = Role::query()->firstOrCreate(['key' => 'content_manager', 'value' => 'Content Manager']);
                    $admin->roles()->attach($role);
                }
                if ($data['is_news_feed']) {
                    $role = Role::query()->firstOrCreate(['key' => 'news_feed', 'value' => 'News Feed']);
                    $admin->roles()->attach($role);
                }
            }
        } elseif ($admin) {
            $admin->delete();
        }

        return $data;
    }

    public function importUser(Request $request)
    {
        return view('admin.import-user', [
            'school_id' => $request->school_id,
            'yearbook_id' => $request->yearbook_id,
        ]);
    }

    public function handleImportUser(Request $request)
    {
        $file = $request->file('file');

        Validator::make(
            [
                'file' => $file,
                'extension' => strtolower($file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:csv',
            ]
        )->validate();
        $file->move('files/', $file->getClientOriginalName());
        $mimeType = $file->getClientMimeType();
        try {
            switch ($mimeType) {
                case self::CSV:
                    CSVImporter::loadFile($file->getClientOriginalName(),
                        $request->school_id, $request->yearbook_id);
                    break;

                case self::XML:
                    XMLmporter::loadFile($file->getClientOriginalName(),
                        $request->school_id, $request->yearbook_id);
                    break;

                default:
                    CSVImporter::loadFile($file->getClientOriginalName(),
                        $request->school_id, $request->yearbook_id);
                    break;
            }

            return redirect()->action('Admin\UsersManagerController@index', [
                'yearbook_id' => $request->yearbook_id,
                'school_id' => $request->school_id,
            ]);
        } catch (\Exception $ex) {
            return redirect()->back()
                ->with('error-message', 'Waiting for CSV/XML');
        }
    }

    public function getUsersForDashboard(Request $request)
    {
        return response()->json([
            'registered' => User::getRegistered()->get(),
            'payed' => User::getBuyed()->get(),
        ]);
    }

    public function block(Request $request)
    {
        try {
            if ($user = User::block($request->user_id)) {
                $message = $user->blocked == true ? 'User Blocked' : 'User Unblocked';

                return redirect()->back()
                    ->with('success-message', $message);
            } else {
                return redirect()->back()
                    ->with('error-message', 'Error blocking user!');
            }
        } catch (\Exception $e) {
            Log::error($e);

            return response($e->getMessage(), 500);
        }
    }

    /**
     * @param UsersPushRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function push(UsersPushRequest $request)
    {
        if (User::pushNotification('direct', $request->get('recipient'), $request->get('message'),
            $request->get('school_id'), $request->get('levels'))
        ) {
            return redirect()->back()
                ->with('success-message', 'Notification sent');
        } else {
            return redirect()->back()
                ->with('error-message', 'Error send notifications!');
        }
    }

    public function paidForAll($yearbookId)
    {
        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($yearbookId);

        if (!$yearbook) {
            abort(404);
        }

        $yearbook->yearbook_users()->update(['status' => 'paid']);

        return redirect()->back();

    }

    public function export($yearbookId)
    {

        return Excel::download(new UsersExport($yearbookId),
            'users' . time() . '.csv');
    }

    public function moveUsers(Request $request)
    {
        $this->userService->moveUser($request);
        return ['status' => true];
    }
}
