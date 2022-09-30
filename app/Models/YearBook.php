<?php

namespace App\Models;

use App\Models\ContentCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;

/**
 * @method Builder where(string $string, int $id)
 * @property Collection users
 */
class YearBook extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable
        = [
            'school_id',
            'year_from',
            'year_to',
            'image',
            'is_student_tribute'
        ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public static function createWithFolder($data)
    {
        $yearbook = self::create($data);
        try {
            $config      = app('config')->get('mediaManager');
            $fileSystem  = Arr::get($config, 'storage_disk');
            $storageDisk = app('filesystem')->disk($fileSystem);
            $storageDisk->makeDirectory('schools/'.
                $data['school_id'].'/'.$data['year_from'].'-'.$data['year_to'].
                '/profiles'
            );

            return $yearbook;
        } catch (\Exception $exception) {
            Log::error($exception);

            return $exception->getMessage();
        }
    }

    /**
     * @deprecated
     *
     * @param $data
     *
     * @return mixed
     */
    public static function getUsers($data)
    {
        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($data['yearbook_id']);
        $users    = $yearbook->users()->filter($data)->get();

        return $users;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_year_books',
            'yearbook_id')->withTimestamps();
    }

    public function yearbook_users()
    {
        return $this->hasMany(UsersYearBook::class, 'yearbook_id');
    }

    public function contentCategories()
    {
        return $this->hasMany(ContentCategory::class);
    }

    public function canPublish()
    {
        $now = new \DateTime();

        $form = new \DateTime('01-08-'.$this->year_from);
        $to   = new \DateTime('15-06-'.$this->year_to);

        if ($now >= $form && $now < $to) {
            return true;
        }

        return false;
    }

    public function canFinalPublish()
    {
        $now = new \DateTime();

        $form = new \DateTime('15-06-'.$this->year_to);
        $to   = new \DateTime('16-06-'.$this->year_to);

        if ($form <= $now && Session::get('customAdmin')) {
            return true;
        }

        if ($now >= $form && $now < $to) {
            return true;
        }

        return false;
    }

    public function getPublishMessage()
    {
        $now = new \DateTime();

        $form = new \DateTime('08-06-'.$this->year_to);
        $to   = new \DateTime('16-06-'.$this->year_to);

        if ($now >= $form && $now < $to) {
            $diff = $to->diff($now,true)->format('%a');

            return "You have $diff days left to publish this Yearbook! After June 15th, admin...";
        }

        return false;

    }
}
