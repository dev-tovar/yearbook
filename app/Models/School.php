<?php

namespace App\Models;

use App\Helpers\CMHelper;
use App\Helpers\Yearbook AS YBHelper;
use App\Models\BankAccount;
use App\Models\SocialGrades;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class School extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable
    = [
        'name',
        'grade',
        'students_number',
        'country',
        'state',
        'city',
        'address',
        'zip',
        'advisor',
        'contract_years',
        'contract_start_date',
        'is_fb',
        'is_twitter',
        'is_inst',
        'is_linkedin',
    ];

    protected $appends = ['date_create', 'contract_status'];

    public function getDateCreateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('M d, Y');
    }
    public function getContractStatusAttribute()
    {
        return YBHelper::displayElapsedTime(\Carbon\Carbon::parse($this->contract_start_date)->addYears($this->contract_years));
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        $disk = app('filesystem')->disk(config('mediaManager.storage_disk'));

        static::created(function ($model) use ($disk) {
            $disk->makeDirectory('schools/' . $model->id);
        });

        static::deleted(function ($model) use ($disk) {
            $disk->deleteDirectory('schools/' . $model->id);
        });
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function account()
    {
        return $this->hasOne(BankAccount::class);
    }

    public function setContractStartDateAttribute($value)
    {
        $this->attributes['contract_start_date'] = Carbon::parse($value)
            ->format('Y-m-d');
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function yearbooks()
    {
        return $this->hasMany(YearBook::class);
    }

    public function countUsers()
    {
        return User::query()->join('users_year_books as uyb', 'users.id', '=', 'uyb.user_id')
            ->join('year_books as yb', 'yb.id', '=', 'uyb.yearbook_id')
            ->where('yb.school_id', $this->id)->count();
    }

    public function totalUsers()
    {
        return $this->hasManyThrough(UsersYearBook::class, YearBook::class, 'id', 'yearbook_id', 'id', 'id');
    }

    public static function createWithYearBook($data)
    {
        $school = self::create($data);

        if (Carbon::now()->month > 5) {
            $year_from = Carbon::now()->year;
            $year_to = $year_from + 1;
        } else {
            $year_to = Carbon::now()->year;
            $year_from = $year_to - 1;
        }

        $yearbook = YearBook::createWithFolder([
            'school_id' => $school->id,
            'year_from' => $year_from,
            'year_to' => $year_to,
        ]);

        return $school;
    }

    public function hasFolder($storageDisk)
    {
        if ($storageDisk->exists('schools/' . $this->id)) {
            return true;
        } else {
            return false;
        }
    }

    public function createFolder($storageDisk)
    {
        try {
            $storageDisk->makeDirectory($this->id);

            return true;
        } catch (\Exception $exception) {
            Log::error($exception);

            return $exception->getMessage();
        }
    }

    public function scopeDateFrom($query, $from)
    {
        $fromCarbon = Carbon::parse($from)->format('Y-m-d');

        return $query->whereDate('created_at', '>=', $fromCarbon)
            ->orderBy('created_at', 'desc');
    }

    public function scopeDateTo($query, $to)
    {
        $toCarbon = Carbon::parse($to)->format('Y-m-d');

        return $query->whereDate('created_at', '<=', $toCarbon)
            ->orderBy('created_at', 'desc');
    }

    public function scopeSearch($query, $search)
    {
        $query->where(function ($sQuery) use ($search) {
            /** @var Builder $sQuery */
            $sQuery->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case 'expired':
                $query->where(function ($qq) {
                    $qq->whereRaw('id in 
					(SELECT id from (select id, DATE_ADD(contract_start_date,INTERVAL contract_years YEAR) 
					as ex_date, NOW() as cur_date from schools HAVING ex_date < cur_date) as D)');
                });
                break;
            case 1:
                $query->where(function ($qq) {
                    $qq->whereRaw("id in 
					(SELECT id from (select id, 
					DATE_ADD(contract_start_date,INTERVAL contract_years YEAR) as ex_date, 
					DATE_ADD(NOW(),INTERVAL 1 YEAR) as cur_date_1
					from schools HAVING ex_date < cur_date_1) as D)");
                });
                break;
            case 2:
                $query->where(function ($qq) {
                    $qq->whereRaw("id in 
					(SELECT id from (select id, 
					DATE_ADD(contract_start_date,INTERVAL contract_years YEAR) as ex_date, 
					DATE_ADD(NOW(),INTERVAL 1 YEAR) as cur_date_1, 
					DATE_ADD(NOW(),INTERVAL 2 YEAR) as cur_date_2 
					from schools HAVING ex_date > cur_date_1 AND ex_date < cur_date_2) as D)");
                });
                break;
            case 3:
                $query->where(function ($qq) {
                    $qq->whereRaw("id in 
					(SELECT id from (select id, 
					DATE_ADD(contract_start_date,INTERVAL contract_years YEAR) as ex_date, 
					DATE_ADD(NOW(),INTERVAL 2 YEAR) as cur_date_1, 
					DATE_ADD(NOW(),INTERVAL 5 YEAR) as cur_date_2 
					from schools HAVING ex_date > cur_date_1 AND ex_date < cur_date_2) as D)");
                });
                break;
            case 4:
                $query->where(function ($qq) {
                    $qq->whereRaw("id in 
					(SELECT id from (select id, 
					DATE_ADD(contract_start_date,INTERVAL contract_years YEAR) as ex_date, 
					DATE_ADD(NOW(),INTERVAL 5 YEAR) as cur_date_1, 
					DATE_ADD(NOW(),INTERVAL 10 YEAR) as cur_date_2 
					from schools HAVING ex_date > cur_date_1 AND ex_date < cur_date_2) as D)");
                });
                break;
            case 5:
                $query->where(function ($qq) {
                    $qq->whereRaw("id in 
					(SELECT id from (select id, 
					DATE_ADD(contract_start_date,INTERVAL contract_years YEAR) as ex_date, 
					DATE_ADD(NOW(),INTERVAL 10 YEAR) as cur_date_1
					from schools HAVING ex_date > cur_date_1) as D)");
                });
                break;
        }
    }

    public function scopeOrder($query, $order)
    {
        switch ($order) {
            case 1:
                $query->orderBy('students_number', 'desc');
                break;

            case 2:
                $query->orderBy('students_number', 'asc');
                break;
        }
    }

    public function scopeState($query, $state)
    {
        $query->where('state', 'LIKE', "%$state%");
    }

    public function scopeOnlyGrade($query, $grade)
    {
        return $query->where('grade', $grade);
    }

    public function scopeFilter($query, array $filter)
    {
        if (isset($filter['search']) && $filter['search'] !== null) {
            $query->search($filter['search']);
        }
        if (isset($filter['status']) && $filter['status'] !== null) {
            $query->status($filter['status']);
        }
        if (isset($filter['state']) && $filter['state'] !== null) {
            $query->state($filter['state']);
        }
        if (
            isset($filter['number_of_students'])
            && $filter['number_of_students'] !== null
        ) {
            $query->order($filter['number_of_students']);
        }
        if (isset($filter['grade']) && $filter['grade'] !== null) {
            $query->onlyGrade($filter['grade']);
        }
        if (isset($filter['from']) && $filter['from'] !== null) {
            $query->dateFrom($filter['from']);
        }
        if (isset($filter['to']) && $filter['to'] !== null) {
            $query->dateTo($filter['to']);
        }

        return $query;
    }

    //  месяц/день/год АМ-РМ

    /**
     * Content manager
     */

    public static function createSchoolWithData($data)
    {
        DB::beginTransaction();
        try {
            $school = self::create($data);

            if (Carbon::now()->month > 5) {
                $year_from = Carbon::now()->year;
                $year_to = $year_from + 1;
            } else {
                $year_to = Carbon::now()->year;
                $year_from = $year_to - 1;
            }

            $yearbook = YearBook::createWithFolder([
                'school_id' => $school->id,
                'year_from' => $year_from,
                'year_to' => $year_to,
            ]);
            //create default categories and pages
            $cmHalper = new CMHelper($yearbook);

            $admData = [
                'name' => $data['advisor'],
                'password' => $data['admin_password'],
                'email' => $data['admin_email'],
                'school_id' => $school->id,
                'yearbook_id' => $yearbook->id,
            ];

            $admin = User::createSchoolAdmin($admData);
            if (!$admin) {
                DB::rollBack();

                return false;
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);

            return false;
        }
        DB::commit();

        return $school;
    }

    public function createYearbookYearly()
    {
        DB::beginTransaction();
        try {
            $year_from = Carbon::now()->year;
            $year_to = $year_from + 1;

            $yearbook = YearBook::createWithFolder([
                'school_id' => $this->id,
                'year_from' => $year_from,
                'year_to' => $year_to,
            ]);
            $cmHalper = new CMHelper($yearbook);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);

            return false;
        }
        DB::commit();
    }

    public function getAlumniYears()
    {
        return $this->yearbooks()->whereHas('yearbook_users', function ($q) {
            $q->where('is_alumni', true);
        })->pluck('year_books.year_to');
    }

    public function socialGrades()
    {
        return $this->hasMany(SocialGrades::class, 'school_id');
    }
}
