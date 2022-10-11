<?php

namespace App\Http\Controllers\Api;

use App\Like;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function make($id)
    {
        try {
            /** @var Like $like */
            $like = Like::where([
                'page_content_id' => $id,
                'user_id'         => Auth::id(),
            ])
                ->first();

            if ($like) {
                $like->delete();

                return [
                    'status' => true,
                    'isLike' => false,
                    'count'  => Like::where(['page_content_id' => $id])
                        ->count(),
                ];
            } else {
                Like::create([
                    'page_content_id' => $id,
                    'user_id'         => Auth::id(),
                ]);

                return [
                    'status' => true,
                    'isLike' => true,
                    'count'  => Like::where(['page_content_id' => $id])
                        ->count(),
                ];
            }
        } catch (\Exception $ex) {
            Log::error($ex);

            return ['status' => true, 'error' => $ex->getMessage()];
        }

    }

    public function index($yearbook, $id)
    {
        $users = User::whereHas('likes', function ($q) use ($id) {
            $q->where(['page_content_id' => $id]);
        })->get();

        /** @var User $user */
        foreach ($users as &$user) {
            $avatar = $user->getImage($yearbook);
            $user->image = $avatar;
//            $user->avatar_by_yearbook = $avatar;
            $user->grade = $user->getGradeLevel($yearbook);
        }

//        $users = $users->map(function ($user, $key) use ($yearbook) {
//            $user->avatar = $user->getImage($yearbook);
//            $user->grade = $user->getGradeLevel($yearbook);
//            return array_merge($user->toArray(), ['avatar' => $user->getImage($yearbook)]);
//
//        });

        return $users;
    }
}
