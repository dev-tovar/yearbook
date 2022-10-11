<?php

namespace App\Http\Controllers\Api;

use App\FutureAspiration;
use App\FutureAttending;
use App\Http\Requests\UpdateYearbookProfileRequest;
use App\Models\Career;
use App\Models\Page;
use App\SportClub;
use App\Transformers\UserTransformer;
use App\User;
use App\YearBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class YearbookProfileController extends Controller
{
    public function my($yearbookId, $childId = null)
    {
        if ($childId) {
            /** @var User $user */
            $user = Auth::user()
                ->childes()
                ->find($childId);
            if (!$user) {
                abort(404);
            }
        } else {
            /** @var User $user */
            $user = Auth::user();
        }
        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($yearbookId);
        if (!$yearbook) {
            abort(404);
        }
        $yearbookUser = $yearbook->yearbook_users()
            ->where('user_id', $user->id)
            ->first();
        if (!$yearbookUser) {
            abort(404);
        }
        $yearbookUser->facebook_link = $yearbook->school->is_fb ? $yearbookUser->user->facebook_link : null;
        $yearbookUser->linkedin_link = $yearbook->school->is_twitter ? $yearbookUser->user->linkedin_link : null;
        $yearbookUser->twitter_link = $yearbook->school->is_inst ? $yearbookUser->user->twitter_link : null;
        $yearbookUser->instagram_link = $yearbook->school->is_linkedin ? $yearbookUser->user->instagram_link : null;


        $allowSocial = $yearbook->school->socialGrades()->where('grade', $yearbookUser->grade_level)->first() != null;


        $profilePage = Page::whereHas('category',
            function ($q) use ($yearbook) {
                $q->where('year_book_id', $yearbook->id);
                $q->whereHas('parentCategory', function ($qq) {
                    $qq->where('name', 'Students Profile');
                });

            })
            ->without('user')
            ->where('user_id', $user->id)
            ->first();

        //$user = $user->load('careers');

        return [
            'profilePage' => $profilePage,
            'wall' => $user->getWall($yearbookId),
            'yearbookUser' => $yearbookUser,
            'allowSocial' => $allowSocial,
            'user' => App::make(UserTransformer::class)->transform($user, $yearbookUser),
            //'careers'      => Career::all()
        ];
    }

    public function sports()
    {
        return SportClub::all();
    }

    public function futureAttending()
    {
        return FutureAttending::all();
    }

    public function futureAspirations()
    {
        return FutureAspiration::all();
    }

    public function show($yearbookId, $userId)
    {
        /** @var User $user */
        $user = User::find($userId);
        if (!$user) {
            abort(404);
        }
        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($yearbookId);
        if (!$yearbook) {
            abort(404);
        }
        $yearbookUser = $yearbook->yearbook_users()->where('user_id', $user->id)
            ->first();
        if (!$yearbookUser) {
            abort(404);
        }
        $profilePage = Page::whereHas('category',
            function ($q) use ($yearbook) {
                $q->where('year_book_id', $yearbook->id);
                $q->whereHas('parentCategory', function ($qq) {
                    $qq->where('name', 'Students Profile');
                });
            })->where('user_id', $user->id)->first();

        $user->grade = $user->getGradeLevel($yearbookId);

        $allowSocial = $yearbook->school->socialGrades()->where('grade', $yearbookUser->grade_level)->first() != null;

        $yearbookUser->facebook_link = $yearbook->school->is_fb ? $yearbookUser->user->facebook_link : null;
        $yearbookUser->linkedin_link = $yearbook->school->is_twitter ? $yearbookUser->user->linkedin_link : null;
        $yearbookUser->twitter_link = $yearbook->school->is_inst ? $yearbookUser->user->twitter_link : null;
        $yearbookUser->instagram_link = $yearbook->school->is_linkedin ? $yearbookUser->user->instagram_link : null;

        $data = [
            'profilePage' => $profilePage,
            'yearbookUser' => $yearbookUser,
            'allowSocial' => $allowSocial,
            'user' => $user,
        ];

        return $data;
    }

    public function update(UpdateYearbookProfileRequest $request)
    {
        $profilePageData = $request->profile_page ?? [];
        $yearbookUserData = $request->yearbook_user ?? [];
        $yearbookId = $request->yearbook_id;

        $user = Auth::user();

        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($yearbookId);
        if (!$yearbook) {
            abort(404);
        }
        $yearbookUser = $yearbook->yearbook_users()->where('user_id', $user->id)
            ->first();
        if (!$yearbookUser) {
            abort(404);
        }

        /** @var Page $profilePage */
        $profilePage = Page::whereHas('category',
            function ($q) use ($yearbook) {
                $q->where('year_book_id', $yearbook->id);
                $q->whereHas('parentCategory', function ($qq) {
                    $qq->where('name', 'Students Profile');
                });
            })->where('user_id', $user->id)->first();

        if (count($profilePageData)) {
            foreach ($profilePageData as $key => $value) {
                $content = $profilePage->contents()
                    ->whereHas('field', function ($q) use ($key) {
                        $q->where('name', $key);
                    })->first();
                if ($content) {
                    $content->value = $value;
                    $content->save();
                }
            }
        }

        if (count($yearbookUserData)) {
            $yearbookUser->update($yearbookUserData);
        }

        return ['status' => true];


    }
}
