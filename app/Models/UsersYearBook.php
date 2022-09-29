<?php

namespace App\Models;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersYearBook extends Model
{
    protected $fillable
        = [
            'grade_level',
            'confirmation_code',
            'status',
            'avatar',
            'buyed_yearbook_at',
            'app_status',
            'yearbook_id',
            'user_id',
            'is_buy',
            'facebook_link',
            'linkedin_link',
            'twitter_link',
            'instagram_link',
            'is_alumni',
            'is_faculty'
        ];

    protected $hidden
        = [
            'confirmation_code',
        ];

    public function yearbook()
    {
        return $this->belongsTo(YearBook::class, 'yearbook_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMyorder($query)
    {

        return $query->select('users_year_books.*', DB::raw('gradePosition(grade_level) as grade_position'),
            'users.name as name_position')
            ->leftJoin('users', 'users_year_books.user_id', '=', 'users.id')
            ->orderBy('grade_position', 'asc')->orderBy('name_position', 'asc');
    }

    public function getImageAttribute()
    {
        if ($this->avatar == null) {
            return asset('images/no-avatar.png');
        }

        return $this->avatar;
    }

    public function getAvatarAttribute($value)
    {
        if ($value == null) {
            return asset('images/no-avatar.png');
        } else {
            return $value;
        }
    }

    public function getPhotoVideoAttribute($value)
    {
        if (!$value) {
            return '[]';
        }

        return $value;
    }

    public function getProfilePage()
    {
        return Page::whereHas('category',
            function ($q) {
                $q->where('year_book_id', $this->yearbook_id);
                $q->whereHas('parentCategory', function ($qq) {
                    $qq->where('name', 'Students Profile');
                });
            })->where('user_id', $this->user_id)->first();
    }
}
