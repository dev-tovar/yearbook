<?php

namespace App\Models;

use App\Enums\AlumniPushType;
use App\Enums\EventsVisitStatus;
use App\Enums\UserAppStatus;
use App\Events\AlumniPushEvent;
use App\Events\PushEvent;
use App\Helpers\ValueObjects\AlumniPushMessage;
use App\Models\AlumniEvent;
use App\Models\AlumniPushHistory;
use App\Models\Career;
use App\Models\DeviceToken;
use App\Models\Donate;
use App\Models\Page;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{

    private $userYearbookObj = null;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uuid',
        'user_type',
        'is_admin',
        'is_push_notification',
        'is_email_notification',
        'is_tmp',
        'alumni_email',
        'alumni_phone',
        'is_gps',
        'alumni_address',
        'facebook_link',
        'linkedin_link',
        'twitter_link',
        'instagram_link',
        'phone_privacy',
        'email_privacy',
        'gps_privacy',
        'career_privacy',
        'company',
        'blocked',
        'sports',
        'is_school_admin'
    ];

    private function getUserYearbookObj(){
        if(!$this->userYearbookObj){
            $this->userYearbookObj = $this->users_yearbooks()
                ->orderBy('created_at', 'DESC')->first();
        }

        return $this->userYearbookObj;
    }

    /**
     * @var array
     */
    protected $appends = [
//        'avatar',
        'school_name',
        'is_faculty',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_push_notification' => 'boolean',
        'is_email_notification' => 'boolean',
        'blocked' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events()
    {
        return $this->belongsToMany(AlumniEvent::class, 'event_visit', 'user_id', 'event_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany(DeviceToken::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function yearbook()
    {
        return $this->belongsToMany(YearBook::class, 'users_year_books',
            'user_id', 'yearbook_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users_yearbooks()
    {
        return $this->hasMany(UsersYearBook::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function careers()
    {
        return $this->belongsToMany(Career::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function future_aspirations()
    {
        return $this->belongsToMany(FutureAspiration::class, 'future_aspiration_user');
    }

    public function future_attending()
    {
        return $this->belongsToMany(FutureAttending::class, 'future_attending_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donates()
    {
        return $this->hasMany(Donate::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * @param $data
     * @return bool
     */
    public static function createSchoolAdmin($data)
    {
        try {
            $data['user_type'] = 'admin';
            $data['is_admin'] = true;
            $user = self::create($data);
            $user->assignToYearBook($data['yearbook_id']);
            $data['user_id'] = $user->id;
            $admin = Admin::create($data);
            $mailData = [
                'school' => $user->school,
                'login' => $user->email,
                'password' => $data['password'],
            ];
            $role_id = Role::admin();
            if ($role_id != null) {
                DB::insert('insert into admin_roles (user_id, role_id) values (?, ?)',
                    [$admin->id, $role_id]);
                try {
                    Mail::send('mail.admin', $mailData,
                        function ($m) use ($user) {
                            $m->to($user->email)
                                ->subject('Admin Credentials');
                        });
                } catch (\Exception $exception) {
                    Log::error($exception);
                }
            } else {
                Log::error('Admin role not found');

                return false;
            }
        } catch (\Exception $exception) {
            Log::error($exception);

            return false;
        }

        return $admin;
    }

    /**
     * @return string
     */
    public function getSchoolNameAttribute()
    {
        $yearbookUser = $this->users_yearbooks()->with('yearbook')
            ->orderBy('created_at', 'DESC')->first();

        if ($yearbookUser && $yearbookUser->yearbook->school) {
            return $yearbookUser->yearbook->school->name;
        } else {
            return '';
        }
    }


    public function getIsFacultyAttribute()
    {
        $yearbookUser = $this->getUserYearbookObj();

        if ($yearbookUser) {
            return $yearbookUser->is_faculty;
        } else {
            return false;
        }
    }

    /**
     * @return mixed|string
     */
    public function getUuidAttribute()
    {
        $yearbookUser = $this->users_yearbooks()->with('yearbook')
            ->orderBy('created_at', 'DESC')->first();

        if ($yearbookUser) {
            return $yearbookUser->id;
        } else {
            return '';
        }
    }

    /**
     * @param $yearbookId
     * @return mixed|string
     */
    public function getImage($yearbookId)
    {
        $yearbookUser = $this->users_yearbooks()->with('yearbook')
            ->where('yearbook_id', $yearbookId)
            ->orderBy('created_at', 'DESC')->first();

        if ($yearbookUser) {
            return $yearbookUser->image ? $yearbookUser->image
                : 'images/no-avatar.png';
        } else {
            return 'images/no-avatar.png';
        }
    }

    public function getActualYearBook()
    {
        $yearbookUser = $this->users_yearbooks()->with('yearbook')
            ->orderByDesc('id')
            ->first();

        if ($yearbookUser) {
            return $yearbookUser->yearbook;
        } else {
            return null;
        }
    }

    /**
     * @return mixed|null
     */
    public function getAvatarAttribute()
    {
        $yearbookUser = UsersYearBook::query()
            ->select('users_year_books.avatar')
            ->where('users_year_books.user_id', $this->id)
            ->whereNotNull('users_year_books.avatar')
            ->join(
                'year_books',
                'year_books.id',
                '=',
                'users_year_books.yearbook_id'
            )
            ->orderBy('year_books.year_to', 'DESC')
            ->first();

        if ($yearbookUser) {
            return $yearbookUser->avatar;
        } else {
            return null;
        }
    }

    /**
     * @return mixed|string
     */
    public function getUserImage()
    {
        if ($this->avatar == null) {
            return asset('images/no-avatar.png');
        }

        return $this->avatar;
    }

    /**
     * @param $password
     * @return bool
     */
    public function checkPassword($password)
    {
        if (Hash::check($password, $this->password)) {
            return true;
        }

        return false;
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if ($value != null) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = null;
        }
    }

    /**
     * @param $child_id
     * @param null $school_id
     * @return Feed|\Illuminate\Database\Eloquent\Builder|null
     */
    public function getNewsFeeds($child_id, $school_id = null)
    {
        $userType = $this->user_type;

        $feeds = Feed::with('attachments')
            ->leftJoin('feed_views',function ($j){
                $j->on('feed_views.feed_id','=','feeds.id');
                $j->where('feed_views.user_id','=',\auth()->id());
            })
        ->select(
            'feeds.*',
            DB::raw('(feed_views.id is not null) as is_view')
        );

        switch ($userType) {
            case 'student':
                $yearbook = $this->getActualYearBook();
                $userYearbook = $this->users_yearbooks()
                    ->where('yearbook_id', $yearbook->id)->first();
                $gradeLevel = $userYearbook->grade_level;
                if ($school_id) {
                    $feeds->where('school_id', '=', $school_id)
                        ->where(function ($q) use ($gradeLevel) {
                            $q->whereIn('recipients', ['everyone', 'students'])
                                ->where(function ($qqq) use ($gradeLevel) {
                                    $qqq->whereHas('grades',
                                        function ($qqqq) use ($gradeLevel) {
                                            $qqqq->where('grade', $gradeLevel);
                                        });
                                    $qqq->orWhereHas('grades', function ($qqqq) {
                                        $qqqq->where('grade', 'All');
                                    });
                                });
                        });

                } else {
                    $feeds->where('school_id', '=', $yearbook->school_id)
                        ->where(function ($q) use ($gradeLevel) {
                            $q->whereIn('recipients', ['everyone', 'students'])
                                ->where(function ($qqq) use ($gradeLevel) {
                                    $qqq->whereHas('grades',
                                        function ($qqqq) use ($gradeLevel) {
                                            $qqqq->where('grade', $gradeLevel);
                                        });
                                    $qqq->orWhereHas('grades', function ($qqqq) {
                                        $qqqq->where('grade', 'All');
                                    });
                                });
                        });

                }
                break;

            case 'parent':
                if ($child_id != null) {
                    /** @var User $user */
                    $user = User::find($child_id);
                    $yearbook = $user->getActualYearBook();
                    $userYearbook = $user->users_yearbooks()
                        ->where('yearbook_id', $yearbook->id)->first();
                    $gradeLevel = $userYearbook->grade_level;
                    $feeds->where('school_id', '=', $yearbook->school_id)
                        ->where(function ($q) use ($gradeLevel) {
                            $q->whereIn('recipients', ['everyone', 'parents'])
                                ->where(function ($qqq) use ($gradeLevel) {
                                    $qqq->whereHas('grades',
                                        function ($qqqq) use ($gradeLevel) {
                                            $qqqq->where('grade',
                                                $gradeLevel);
                                        });
                                    $qqq->orWhereHas('grades',
                                        function ($qqqq) {
                                            $qqqq->where('grade', 'All');
                                        });
                                });
                        });
                } else {
                    $feeds->where('id', '<', 0);
                }
                break;

            default:
                $feeds = null;
                break;
        }

        return $feeds;
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @return bool
     */
    public function isStudent()
    {
        return $this->user_type == 'student';
    }

    /**
     * @return bool
     */
    public function isParent()
    {
        return $this->user_type == 'parent';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function childes()
    {
        return $this->belongsToMany(User::class,
            'child_parent', 'parent_id', 'child_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parents()
    {
        return $this->belongsToMany(User::class,
            'child_parent', 'child_id', 'parent_id');
    }

    /**
     * @param $child_id
     */
    public function removeChild($child_id)
    {
        DB::transaction(function () use ($child_id) {
            DB::table('child_parent')
                ->where('parent_id', '=', $this->id)
                ->where('child_id', '=', $child_id)
                ->delete();
        });
    }

    /**
     * @param $child_id
     */
    public function addChild($child_id)
    {
        DB::transaction(function () use ($child_id) {
            DB::table('child_parent')
                ->insert([
                    'parent_id' => $this->id,
                    'child_id' => $child_id,
                ]);
        });
    }

    /**
     * @param $yearbook_id
     * @return bool
     */
    public function isPresentInYearBook($yearbook_id)
    {
        return $this->yearbook()->find($yearbook_id) != null;
    }

    /**
     * @param $yearbook_id
     * @param array $data
     */
    public function assignToYearBook($yearbook_id, $data = [])
    {
        $insertData = [
            'user_id' => $this->id,
            'yearbook_id' => $yearbook_id,
        ];
        if (key_exists('grade_level', $data)) {
            $insertData['grade_level'] = $data['grade_level'];
        }
        if (key_exists('confirmation_code', $data)) {
            $insertData['confirmation_code'] = $data['confirmation_code'];
        }
        if (key_exists('status', $data)) {
            $insertData['status'] = $data['status'];
        }

        if (key_exists('is_faculty', $data)) {
            $insertData['is_faculty'] = $data['is_faculty'];
        }

        DB::table('users_year_books')
            ->insert($insertData);
    }

    /**
     * @param $query
     * @param $status
     */
    public function scopeStatus($query, $status)
    {
        $status = strtolower($status);
        $query->whereHas('users_yearbooks', function ($q) use ($status) {
            $q->where('app_status', '=', $status);
        });
    }

    /**
     * @param $query
     * @param $grade
     */
    public function scopeGrade($query, $grade)
    {
        $query->whereHas('users_yearbooks', function ($q) use ($grade) {
            $q->where('grade_level', '=', $grade);
        });
    }

    /**
     * @param $query
     * @param $user_type
     */
    public function scopeType($query, $user_type)
    {
        $query->where('user_type', '=', strtolower($user_type));
    }

    /**
     * @param Builder $query
     * @param         $search
     */
    public function scopeSearch($query, $search)
    {
        $query->where(function ($sQuery) use ($search) {
            /** @var Builder $sQuery */
            $sQuery->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhereHas('users_yearbooks', function ($q) use ($search) {
                    $q->where('confirmation_code', 'LIKE', '%' . $search . '%');
                    $q->orWhere('id', 'LIKE', '%' . $search . '%');
                });

        });
    }

    /**
     * @param $yearbookId
     * @return mixed|string
     */
    public function getGradeLevel($yearbookId)
    {
        $usersYearbook = $this->users_yearbooks()
            ->where('yearbook_id', $yearbookId)->first();

        return $usersYearbook ? $usersYearbook->grade_level : '';
    }

    /**
     * @param $yearbookId
     * @return mixed|string
     */
    public function getPhotoVideo($yearbookId)
    {
        $usersYearbook = $this->users_yearbooks()
            ->where('yearbook_id', $yearbookId)->first();

//        dd($usersYearbook);

        return $usersYearbook ? $usersYearbook->photo_video : '[]';
    }

    /**
     * @param $yearbookId
     * @return mixed|string
     */
    public function getAvatar($yearbookId)
    {
        $usersYearbook = $this->users_yearbooks()
            ->where('yearbook_id', $yearbookId)->first();

        return $usersYearbook ? $usersYearbook->avatar : '';
    }

    /**
     * @param $yearbookId
     * @return mixed|string
     */
    public function getAppStatus($yearbookId)
    {
        $usersYearbook = $this->users_yearbooks()
            ->where('yearbook_id', $yearbookId)->first();

        return $usersYearbook ? $usersYearbook->app_status : '';
    }

    /**
     * @param $yearbookId
     * @return mixed|string
     */
    public function getStatus($yearbookId)
    {
        $usersYearbook = $this->users_yearbooks()
            ->where('yearbook_id', $yearbookId)->first();

        return $usersYearbook ? $usersYearbook->status : '';
    }

    /**
     * @param $yearbookId
     * @return mixed|string
     */
    public function getConfirmationCode($yearbookId)
    {
        $usersYearbook = $this->users_yearbooks()
            ->where('yearbook_id', $yearbookId)->first();

        return $usersYearbook ? $usersYearbook->confirmation_code : '';
    }

    /**
     * @param $query
     * @param array $filter
     * @return mixed
     */
    public function scopeFilter($query, array $filter)
    {

        if (isset($filter['search']) && $filter['search'] !== null) {
            $query->search($filter['search']);
        }
        if (isset($filter['status']) && $filter['status'] !== null) {
            $query->status($filter['status']);
        }
        if (isset($filter['grade']) && $filter['grade'] !== null) {
            $query->grade($filter['grade']);
        }
        if (isset($filter['user_type']) && $filter['user_type'] !== null) {
            $query->type($filter['user_type']);
        }

        return $query;
    }

    /**
     * @param array $filter
     * @return bool
     */
    public function acceptFilter(array $filter)
    {

        if (strtolower($filter['status']) === "unpaid") {
            $filter['status'] = "not_paid";
        } else {
            $filter['status'] = strtolower($filter['status']);
        }

        if ($filter['status'] !== null) {
            if ($this->status !== $filter['status']) {
                return false;
            }
        }
        if ($filter['grade'] !== null) {
            if ($this->grade !== $filter['grade']) {
                return false;
            }
        }
        if ($filter['user_type'] !== null) {
            if ($this->user_type !== strtolower($filter['user_type'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function blocked()
    {
        return $this->blocked;
//        if ($this->user_type == 'user_type') {
//            $yearbook = $this->getActualYearBook();
//            if ($yearbook) {
//                $userYearbook = $this->users_yearbooks()
//                    ->where('yearbook_id', $yearbook->id)->first();
//                Log::info('User blocked func, app_status: ' . $userYearbook->app_status);
//                if ($userYearbook->app_status == UserAppStatus::BLOCKED) {
//                    return true;
//                }
//            }
//        }
//        return false;
    }

    /**
     * @param $user_id
     * @return bool
     */
    public static function block($user_id)
    {
        try {
//            $users_yearbook = UsersYearBook::where('user_id', $user_id)->where('yearbook_id', $yearbook_id)
//                                            ->whereHas('yearbook', function ($q) use ($school_id) {
//                                                $q->where('school_id', $school_id);
//                                            })->first();
            $users_yearbook = UsersYearBook::find($user_id);
            $user = User::find($users_yearbook->user_id);
            if ($user) {
                $user->blocked = !$user->blocked;
                $user->save();
                return $user;
            }
        } catch (\Exception $exception) {
            Log::error($exception);

            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getSchoolAttribute()
    {
        return $this->getActualYearBook()->school;
    }

    /**
     * @param $data
     * @return User|bool|null
     */
    public static function register($data)
    {
        /** @var User $user */
        $user = self::whereHas('users_yearbooks',
            function ($q) use ($data) {
                $q->where('users_year_books.id', $data['uuid']);
            })->first();
        $school = School::findOrFail($data['school_id']);
        $yearbook = YearBook::where('school_id', $school->id)
            ->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })->orderByDesc('year_to')->first();
        if ($user && $school && $yearbook) {
            if ($user->password == null) {
                //not registered
                $password = User::generatePassword();
                $email = $data['email'];
                $user->password = $password;
                $user->name = $data['name'];
                $user->email = $email;
                $user->city = $data['city'];
                $user->state = $data['state'];
                $user->save();

                $user->users_yearbooks()->where('yearbook_id', $yearbook->id)
                    ->first()->update([
                        'app_status' => 'active',
                        'grade_level' => $data['grade_level'],
                    ]);

                $mailData = [
                    'email' => $email,
                    'password' => $password,
                ];
                Mail::send('mail.mail', $mailData,
                    function ($m) use ($password, $email) {
                        $m->to($email)
                            ->subject('Username & Password');
                    });

                $user->is_tmp = false;
                $user->save();

                return $user;
            } else {
                //registered
                return false;
            }
        } else {
            return null;
        }

    }

    /**
     * @param $data
     * @return bool
     */
    public static function checkChild($data)
    {
        $user = User::where([
            'user_type' => 'student',
            'name' => $data['name'],
        ])
            ->whereHas('users_yearbooks',
                function ($q) use ($data) {
                    $q->where('id', $data['uuid']);
                    $q->where('grade_level', $data['grade_level']);
                    $q->whereHas('yearbook', function ($qq) use ($data) {
                        $qq->where('school_id', $data['school_id']);
                    });
                })->first();
//        $child = self::where('name', '=', $data['name'])
//            ->where('uuid', '=', $data['uuid'])
//            ->where('school_id', '=', $data['school_id'])
//            ->where('grade_level', '=', $data['grade_level'])
//            ->where('user_type', '=', 'student')
//            ->get();
        if ($user) {
            return $user->id;
        } else {
            return false;
        }
    }

    /**
     * @param $data
     * @return array|bool
     */
    public static function registerParent($data)
    {
        if (count($data['childes']) > 0) {
            $parentEmail = $data['email'];
            $parentName = $data['name'];
            $password = User::generatePassword();

            $data['status'] = 'not_paid';
            $data['password'] = $password;

            try {
                DB::beginTransaction();
                $parent = User::create($data);
                foreach ($data['childes'] as $child) {
                    DB::table('child_parent')
                        ->insert([
                            'parent_id' => $parent->id,
                            'child_id' => $child['user_id'],
                        ]);
                }

                $mailData = [
                    'email' => $parentEmail,
                    'password' => $password,
                ];

                DB::commit();

                Mail::send('mail.mail', $mailData,
                    function ($m) use ($password, $parentEmail) {
                        $m->to($parentEmail)
                            ->subject('Username & Password');
                    });

                return $parent;
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error($exception);
                $error = [
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                ];

                return $error;
            }
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public static function getRegistered()
    {
        return self::select(DB::raw("COUNT(*) as users_count"),
            DB::raw('month(updated_at) as month'))
            ->where('user_type', '=', 'student')
            ->where('password', '!=', 'null')
            ->groupBy(DB::raw("month(updated_at)"));
    }

    /**
     * @return mixed
     */
    public static function getBuyed()
    {
        return self::select(DB::raw("COUNT(*) as users_count"),
            DB::raw('month(updated_at) as month'))
            ->where('user_type', '=', 'student')
            ->where('password', '!=', 'null')
//            ->where('confirmation_code', '!=', 'null')
            ->groupBy(DB::raw("month(updated_at)"));
    }

    public static function pushNewsFeed(Feed $feed, int $school_id = null, $isPush = true)
    {
        $yearbook = YearBook::query()
            ->where('school_id', '=', $feed->school_id)
            ->orderBy('year_to', 'desc')
            ->first();
        $recepients = self::query()->where(function ($q) use ($yearbook) {
            $q->whereHas('yearbook', function ($qq) use ($yearbook) {
                $qq->where('year_books.id', '=', $yearbook->id);
            });
            $q->orWhereHas('childes', function ($qq) use ($yearbook) {
                $qq->whereHas('yearbook', function ($qqq) use ($yearbook) {
                    $qqq->where('year_books.id', '=', $yearbook->id);
                });
            });
        });
        $levels = $feed->grades()->pluck('grade')->toArray();
        switch (strtolower($feed->recipients)) {
            case 'everyone':
                if (count($levels) && (!in_array('All', $levels))) {
                    $recepients = $recepients
                        ->where(function ($qq) {
                            $qq->where('user_type', '=', 'student')
                                ->orWhere('user_type', '=', 'parent');
                        })
                        ->where(function ($q) use ($levels) {
                            $q->whereHas('childes',
                                function ($qq) use ($levels) {
                                    $qq->whereHas('users_yearbooks',
                                        function ($qqq) use ($levels) {
                                            $qqq->whereIn('grade_level',
                                                $levels);
                                        });

                                });
                            $q->orWhereHas('users_yearbooks',
                                function ($qq) use ($levels) {
                                    $qq->orWhereIn('grade_level', $levels);
                                });

                        })->get();;

                } else {
                    $recepients = $recepients
                        ->where(function ($qq) {
                            $qq->where('user_type', '=', 'student')
                                ->orWhere('user_type', '=', 'parent');
                        })->get();
                }

                break;

            case 'students':
                if (count($levels) && (!in_array('All', $levels))) {
                    $recepients = $recepients
                        ->where('user_type', 'student')
                        ->whereHas('users_yearbooks',
                            function ($q) use ($levels) {
                                $q->whereIn('grade_level', $levels);
                            })
                        ->get();
                } else {
                    $recepients = $recepients
                        ->where('user_type', 'student')
                        ->get();
                }

                break;

            case 'parents':
                if (count($levels) && (!in_array('All', $levels))) {
                    $recepients = $recepients
                        ->where('user_type', '=', 'parent')
                        ->whereHas('childes', function ($qq) use ($levels) {
                            $qq->whereHas('users_yearbooks',
                                function ($qqq) use ($levels) {
                                    $qqq->whereIn('grade_level',
                                        $levels);
                                });
                        })
                        ->get();

                } else {
                    $recepients = $recepients
                        ->where('user_type', '=', 'parent')
                        ->get();
                }

                break;
        }
        $data = [
            'title' => $feed->title,
            'custom' => ['type' => 'feed'],
            'image' => null,
        ];
        if ($feed->attachments()->count() > 0) {
            $attaches = $feed->attachments()->get();
            foreach ($attaches as $attach) {
                if ($attach->image()) {
                    $data['image'] = $attach->full_path;
                    break;
                }
            }
        }
        if (!$recepients->count()) {
            return false;
        }

        event(new PushEvent(
            $recepients,
            $feed->title,
            $data['image'],
            ['type' => 'feed'],
            $school_id,
            AlumniPushType::Standart,
            null,
            $isPush
        ));
    }

    /**
     * @param AlumniEvent $event
     */
    public static function pushEvent(AlumniEvent $event)
    {

    }

    /**
     * @param $device
     * @param $token
     * @return bool|\Exception
     */
    public function setToken($device, $token)
    {
        $deviceObj = $this->devices()->where(['token' => $token])->first();
        if (!$deviceObj) {
            $this->devices()->create(['device' => $device, 'token' => $token]);
        }

        return true;
    }

    /**
     * @param $data
     * @return bool|\Exception
     */
    public function resetToken($data)
    {
        $this->devices()->where('token', $data['token'])->delete();
        return true;
    }

    /**
     * @param $data
     * @return bool|\Exception
     */
    public function setTokens($data)
    {
        try {
            $this->devices()->updateOrCreate(['token' => $data['token']], $data);
            return true;
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * @param $device
     * @return bool|\Exception
     */
    public function removeToken($device)
    {
        try {
            switch ($device) {
                case 'ios':
                    $this->ios_token = null;
                    break;

                case 'android':
                    $this->android_token = null;
                    break;
            }
            $this->save();

            return true;
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * @param $type
     * @param string $target
     * @param $message
     * @param $school_id
     * @param array $levels
     * @return bool
     */
    public static function pushNotification(
        $type,
        $target,
        $message,
        $school_id,
        $levels = []
    )
    {
        $yearbook = YearBook::query()
            ->where('school_id', '=', $school_id)
            ->orderBy('year_to', 'desc')
            ->first();
        switch ($target) {
            case 'students':
                $receivers = self::where('user_type', '=', 'student')
                    ->notAlumni()
                    ->where(function ($q) use ($levels, $yearbook) {
                        $q->whereHas('users_yearbooks',
                            function ($qq) use ($levels, $yearbook) {
                                if ($levels && count($levels)) {
                                    $qq->whereIn('grade_level', $levels);
                                }
                                $qq->where('yearbook_id', $yearbook->id);
                            });
                        return $q;
                    })
                    ->get();
                break;

            case 'everyone':
                $receivers = self::whereIn('user_type',
                    ['student', 'parent'])->notAlumni()
                    ->where(function ($q) use ($levels, $yearbook) {
                        $q->whereHas('childes',
                            function ($qq) use ($levels, $yearbook) {
                                $qq->whereHas('users_yearbooks',
                                    function ($qqq) use ($levels, $yearbook) {
                                        if ($levels && count($levels)) {
                                            $qqq->whereIn('grade_level', $levels);
                                        }
                                        $qqq->where('yearbook_id', $yearbook->id);
                                    });
                            });
                        $q->orWhereHas('users_yearbooks',
                            function ($qq) use ($levels, $yearbook) {
                                if ($levels && count($levels)) {
                                    $qq->whereIn('grade_level', $levels);
                                }
                                $qq->where('yearbook_id', $yearbook->id);
                            });
                    })->get();
                break;

            case 'parents':
                $receivers = self::where('user_type', '=', 'parent')->notAlumni($school_id);
                $receivers->whereHas('childes', function ($qq) use ($levels, $yearbook) {
                    $qq->whereHas('users_yearbooks',
                        function ($qqq) use ($levels, $yearbook) {
                            if ($levels && count($levels)) {
                                $qqq->whereIn('grade_level', $levels);
                            }
                            $qqq->where('yearbook_id', $yearbook->id);
                        });
                });

                $receivers = $receivers->get();
                break;
        }
        event(new PushEvent($receivers, $message, null, ['type' => 'direct'], $school_id, AlumniPushType::Standart, 'direct'));

        return true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(PushHistory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(AlumniPushHistory::class);
    }

    /**
     * @return int
     */
    public function getCountNoReadNotification()
    {
        return PushHistory::query()
            ->where('push_histories.type', 'direct')
            ->where('push_histories.user_id', $this->id)
            ->leftJoin('notification_reads', function ($j) {
                $j->on('notification_reads.notification_id', '=', 'push_histories.id');
                $j->where('notification_reads.user_id', Auth::id());
            })
            ->whereRaw(DB::raw('notification_reads.id is null'))
            ->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany(Page::class);

    }

    /**
     * @param $userId
     * @return array
     */
    public function getPurchasedYearbooks($userId)
    {
        $userType = $this->user_type;

        switch ($userType) {
            case 'student':
                $list = YearBook::query()->whereHas('yearbook_users', function ($q) {
                    $q->where('user_id', $this->id);
                    $q->where('is_buy', true);
                })
                    ->orderBy('year_books.year_to', 'desc')
                    ->with([
                        'yearbook_users' => function ($q) {
                            $q->where('user_id', $this->id);
                            $q->where('is_buy', true);
                        },
                        'yearbook_users.user' => function ($q) {
                            $q->where('users.id', $this->id);
                        },
                    ])->get();
                break;

            case 'parent':
                if ($userId != null) {
                    $list = YearBook::query()->whereHas('yearbook_users',
                        function ($q) use ($userId) {
                            $q->where('user_id', $userId);
                            $q->where('is_buy', true);
                        })
                        ->orderBy('year_books.year_to', 'desc')
                        ->with([
                            'yearbook_users' => function ($q) use ($userId) {
                                $q->where('user_id', $userId);
                                $q->where('is_buy', true);
                            },
                            'yearbook_users.user' => function ($q) use ($userId) {
                                $q->where('users.id', $userId);
                            },
                        ])->get();
                } else {
                    $list = [];
                }
                break;

            default:
                $list = [];
                break;
        }

        return $list;
    }

    /**
     * @param $userId
     * @return array
     */
    public function getAvailableYearbooks($userId)
    {
        $userType = $this->user_type;

        switch ($userType) {
            case 'student':
                $list = $this->getActualYearBook()->school()->first()
                    ->yearbooks()
                    ->select(
                        'year_books.*',
                        DB::raw("((SELECT COUNT(*) as cnt from pages
                            join content_categories on content_categories.id = pages.category_id
                            where is_app_publish=1 and content_categories.year_book_id = year_books.id)>0) is_publish")
                    )
                    ->whereHas('yearbook_users', function ($q) {
                        $q->where('user_id', $this->id);
                        $q->where('is_buy', false);
                    })->with([
                        'yearbook_users' => function ($q) {
                            $q->where('user_id', $this->id);
                            $q->where('is_buy', false);
                        },
                        'yearbook_users.user' => function ($q) {
                            $q->where('users.id', $this->id);
                        },
                    ])->get();
                break;

            case 'parent':
                if ($userId != null) {
                    /** @var User $user */
                    $user = self::find($userId);


                    $list = $user->getActualYearBook()->school()->first()
                        ->yearbooks()
                        ->select(
                            'year_books.*',
                            DB::raw("((SELECT COUNT(*) as cnt from pages
                            join content_categories on content_categories.id = pages.category_id
                            where is_app_publish=1 and content_categories.year_book_id = year_books.id)>0) is_publish")
                        )
                        ->whereHas('yearbook_users',
                            function ($q) use ($userId) {
                                $q->where('user_id', $userId);
                                $q->where('is_buy', false);
                            })->with([
                            'yearbook_users' => function ($q) use ($userId
                            ) {
                                $q->where('user_id', $userId);
                                $q->where('is_buy', false);
                            },
                            'yearbook_users.user' => function ($q) use ($userId
                            ) {
                                $q->where('users.id', $userId);
                            },
                        ])->get();
                } else {
                    $list = [];
                }
                break;

            default:
                $list = [];
                break;
        }

        return $list;
    }

    /**
     * @param $yearbookId
     * @return Wall[]|\Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function getWall($yearbookId)
    {
        $wall = Wall::with('user')->where([
            'user_id' => $this->id,
            'yearbook_id' => $yearbookId,
            'status' => 'approve',
        ])->get();

        foreach ($wall as &$value) {
            $value->user->grade = $value->user->getGradeLevel($yearbookId);
            $value->user->avatarImage = $value->user->getImage($yearbookId);
        }

        return $wall;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function getUserFromTmp(User $user)
    {
        $id = $this->id;
        DB::table('admins')->where(['user_id' => $user->id])
            ->update(['user_id' => $id]);
        DB::table('child_parent')->where(['child_id' => $user->id])
            ->update(['child_id' => $id]);
        DB::table('contacts')->where(['user_id' => $user->id])
            ->update(['user_id' => $id]);
        DB::table('pages')->where(['user_id' => $user->id])
            ->update(['user_id' => $id]);
        DB::table('push_histories')->where(['user_id' => $user->id])
            ->update(['user_id' => $id]);
        DB::table('users_year_books')->where(['user_id' => $user->id])
            ->update([
                'user_id' => $id,
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
            ]);
        DB::table('walls')->where(['user_id' => $user->id])
            ->update(['user_id' => $id]);
        DB::table('yearbook_notifications')->where(['user_id' => $user->id])
            ->update(['user_id' => $id]);

        $user->delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * @param $child_id
     * @return \Illuminate\Database\Eloquent\Builder|null
     */
    public function getEvents($child_id)
    {
        $userType = $this->user_type;

        $events = AlumniEvent::query();

        switch ($userType) {
            case 'student':
                $classOf = $this->getClassOf();
                $yearbook = $this->getActualYearBook();
                $events->where('school_id', '=', $yearbook->school_id)
                    ->where(function ($q) use ($classOf) {
                        $q->whereIn('recipients', ['everyone', 'students'])
                            ->where(function ($qqq) use ($classOf) {
                                $qqq->whereHas('grades',
                                    function ($qqqq) use ($classOf) {
                                        $qqqq->where('grade', $classOf);
                                    });
                                $qqq->orWhereHas('grades', function ($qqqq) {
                                    $qqqq->where('grade', 'All');
                                });
                            });
                    });
                break;

            case 'parent':
                if ($child_id != null) {
                    /** @var User $user */
                    $user = User::find($child_id);
                    $classOf = $user->getClassOf();
                    $yearbook = $user->getActualYearBook();
                    $events->where('school_id', '=', $yearbook->school_id)
                        ->where(function ($q) use ($classOf) {
                            $q->whereIn('recipients', ['everyone', 'parents'])
                                ->where(function ($qqq) use ($classOf) {
                                    $qqq->whereHas('grades',
                                        function ($qqqq) use ($classOf) {
                                            $qqqq->where('grade',
                                                $classOf);
                                        });
                                    $qqq->orWhereHas('grades',
                                        function ($qqqq) {
                                            $qqqq->where('grade', 'All');
                                        });
                                });
                        });
                } else {
                    $events->where('id', '<', 0);
                }
                break;

            default:
                $events = null;
                break;
        }
        return $events;
    }

    /**
     * @param null $schoolId
     * @return bool
     */
    public function isAlumni($schoolId = null)
    {
        $alumni = $this->users_yearbooks()->where('is_alumni', 1);


        return $alumni->count() > 0;
    }

    /**
     * @param $query
     * @param null $schoolId
     * @return mixed
     */
    public function scopeAlumni($query, $schoolId = null)
    {
        $query->select('users.*')
            ->join('users_year_books', 'users_year_books.user_id', '=', 'users.id')
            ->where('users_year_books.is_alumni', true);
        if ($schoolId) {
            $query->join('year_books', 'year_books.id', '=', 'users_year_books.yearbook_id')
                ->where('year_books.school_id', $schoolId);
        }

        return $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param null $schoolId
     * @param null $yearbook_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotAlumni(\Illuminate\Database\Eloquent\Builder $query, $schoolId = null, $yearbook_id = null)
    {
        $builder = $query->whereHas('childes', function ($childes) use ($schoolId) {
            $childes->whereHas('users_yearbooks', function ($q) use ($schoolId) {
                if ($schoolId) {
                    $q->whereHas('yearbook', function ($qq) use ($schoolId) {
                        $qq->where('year_books.school_id', $schoolId);
                    });
                }
                $q->where('is_alumni', false);
            });
        })
            ->doesntHave('childes', 'or');

        return $builder;
    }

    /**
     * @param $query
     * @param null $schoolId
     * @return mixed
     */
    public function scopeNotAlumniStudent($query, $schoolId = null)
    {
        return $query->whereHas('users_yearbooks', function ($q) use ($schoolId) {
            if ($schoolId) {
                $q->whereHas('yearbook', function ($qq) use ($schoolId) {
                    $qq->where('year_books.school_id', $schoolId);
                });
            }
            $q->where('is_alumni', false);
        });
    }

    /**
     * @return mixed|string
     */
    public function getClassOf()
    {
        $alumniUser = $this->users_yearbooks()
            ->selectRaw('users_year_books.*, year_books.year_to as yearbook_year_to')
            ->orderBy('yearbook_year_to', 'desc')
            ->where('users_year_books.is_alumni', true)
            ->join('year_books', 'users_year_books.yearbook_id', '=', 'year_books.id')
            ->first();

        if ($alumniUser) {
            return $alumniUser->yearbook_year_to;
        } else {
            return '';
        }
    }

    /**
     * @return array
     */
    public function getAlumniAvatars()
    {
        $yearbookUsers = $this->users_yearbooks()->get();
        $res = [];
        foreach ($yearbookUsers as $yearbookUser) {
            if ($yearbookUser->avatar) {
                $res[] = $yearbookUser->avatar;
            } else {
                $res[] = asset('images/no-avatar.png');
            }

            if ($yearbookUser->grade_level == '12') {
                $profilePage = $yearbookUser->getProfilePage();
                if ($profilePage) {
                    $content = $profilePage->contents()->whereHas('field', function ($q) {
                        $q->where('name', 'additional_photos');
                    })->first();//
                } else {
                    $content = null;
                }

                if ($content) {
                    $contents = json_decode($content->value);
                    if (is_array($contents)) {
                        foreach ($contents as $value) {
                            if (optional($value->path)->path) {
                                $res[] = optional($value->path)->path;
                            }
                        }
                    }
                }
            }
        }
        return $res;
    }

    /**
     * @return array
     */
    public function listAlumniSchools()
    {
        $yearbooks = $this->yearbook()->has('school')->orderBy('year_to', 'desc')->get();

        $res = [];
        foreach ($yearbooks as $yearbook) {
            //Check for no replace schools
            if ((count($res) > 0) && ($res[count($res) - 1]['schoolId'] == $yearbook->school_id)) {
                continue;
            }

            $res[] = [
                'name' => $yearbook->school->name,
                'year' => $yearbook->year_to,
                'schoolId' => $yearbook->school_id,
                'avatar' => $yearbook->image
            ];
        }

        return $res;
    }

    /**
     * @param $yearbookId
     * @return bool|mixed
     */
    public function getIsAlumni($yearbookId)
    {
        $usersYearbook = $this->users_yearbooks()
            ->where('yearbook_id', $yearbookId)->first();

        return $usersYearbook ? $usersYearbook->is_alumni : false;
    }

    /**
     * @param $query
     * @param $selectedYear
     * @param $search
     * @return mixed
     */
    public function scopeAlumniFilter($query, $selectedYear, $search)
    {
        if ($selectedYear) {
            $query = $query->whereHas('users_yearbooks', function ($q) use ($selectedYear) {
                $q->where('is_alumni', true);
                $q->whereHas('yearbook', function ($qq) use ($selectedYear) {
                    $qq->where('year_to', $selectedYear);
                });
            });
        }
        if ($search) {
            $query = $query->search($search);
        }

        return $query;
    }

    public static function alumniPushNotification(
        $message,
        $custom,
        $schoolId,
        $years = [],
        int $messageType = AlumniPushType::Standart
    )
    {
        try {
            $receivers = self::query()->whereHas('users_yearbooks', function ($q) use ($schoolId, $years) {
                $q->whereHas('yearbook', function ($qq) use ($schoolId, $years) {
                    $qq->where('year_books.school_id', $schoolId);
                    if (count($years) && !in_array('All', $years)) {
                        $qq->whereIn('year_to', $years);
                    }
                });
                $q->where('is_alumni', true);
            })->get();
            if ($receivers->count() > 0) {
                event(new AlumniPushEvent($receivers, new AlumniPushMessage($message, $custom, null, $messageType), $schoolId));
            }
        } catch (\Exception $e) {
            Log::error($e);

            return false;
        }

        return true;
    }

    public static function generatePassword()
    {
        return substr(
            str_replace(
                ['I', 'l', 'O', '0'],
                '',
                str_random(36)
            ),
            0,
            8
        );
    }
}
