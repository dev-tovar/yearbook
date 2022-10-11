<?php
/**
 * Created by PhpStorm.
 * User: tabbakka
 * Date: 7/10/18
 * Time: 6:24 PM
 */

namespace App\Http\Controllers\Api;


use App\Helpers\ApiResponseGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddChildRequest;
use App\Http\Requests\ApiRegistrationRequest;
use App\Http\Requests\AttachIdUserRequest;
use App\Http\Requests\CheckChildRequest;
use App\Http\Requests\DeleteChildeRequest;
use App\Http\Requests\StorePrivacyRequest;
use App\Transformers\UserTransformer;
use App\User;
use App\UsersYearBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function get(Request $request, $child_id = null)
    {
        try {
            /** @var User $user */
            if ( ! $user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code'    => 404,
                ]);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token expired',
            ]);
        } catch (TokenInvalidException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token invalid',
            ]);
        } catch (JWTException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token absent',
            ]);
        }
        if ($user->user_type == 'parent') {
            $childes = $user->childes()->get();
            $childesRes = [];
            /** @var User $value */
            foreach ($childes as $value) {
                $yb           = $value->users_yearbooks()->orderByDesc('id')
                    ->first();
//                $value->grade = $value->getGradeLevel(optional($yb)->yearbook_id);
                $value = App::make(UserTransformer::class)->transform($value, $yb);
                $childesRes[] = $value;
            }
            $user['childes'] = $childesRes;
        }
        if ($user->blocked()) {
            return ApiResponseGenerator::blocked();
        }

        if ($child_id != null) {
            try {
                /** @var User $child */
                $child         = User::findOrFail($child_id);
                $child->avatar = $child->getUserImage();
                $child->notifications_count
                               = $child->getCountNoReadNotification();
                $child = App::make(UserTransformer::class)->transform($child);

                return ApiResponseGenerator::responseTrue([
                    'user' => $child,
                ]);
            } catch (\Exception $e) {
                return ApiResponseGenerator::responseFail([
                    'code'    => '404',
                    'message' => 'Child not found',
                ]);
            }
        } else {

            $user->avatar              = $user->getUserImage();
            $user->school_name         = $user->school_name;
            $user->notifications_count = $user->getCountNoReadNotification();

            $user = App::make(UserTransformer::class)->transform($user);

            return ApiResponseGenerator::responseTrue([
                'user' => $user,
            ]);
        }
    }

    public function getMessagesCount()
    {
        try {
            /** @var User $user */
            if ( ! $user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code'    => 404,
                ]);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token expired',
            ]);
        } catch (TokenInvalidException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token invalid',
            ]);
        } catch (JWTException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token absent',
            ]);
        }

        return $user->getCountNoReadNotification();
    }

    public function getIds($userId = null)
    {
        if ($userId) {
            $user = Auth::user()->childes()->find($userId);

            if ($user) {
                return $user->users_yearbooks()->with('yearbook')
                    ->orderBy('created_at', 'DESC')->get();
            }
        } else {
            /** @var User $user */
            $user = Auth::user();

            return $user->users_yearbooks()->orderBy('created_at', 'DESC')
                ->with('yearbook')->get();
        }

        return [];
    }

    public function attachId($userId = null, AttachIdUserRequest $request)
    {
        if ($userId) {
            /** @var User $user */
            $user = Auth::user()->childes()->find($userId);
        } else {
            /** @var User $user */
            $user = Auth::user();
        }
        if ( ! $user) {
            abort(404);
        }

        $usersYearBook = UsersYearBook::find($request->id);

        if ( ! $usersYearBook->user->is_tmp) {
            return response()->json(['error' => ['id' => 'Already attach']],
                422);
        }

        $user->getUserFromTmp($usersYearBook->user);

        return ['status' => true];
    }

    public function deleteChild(DeleteChildeRequest $request)
    {
        try {
            if ( ! $user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code'    => 404,
                ]);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token expired',
            ]);
        } catch (TokenInvalidException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token invalid',
            ]);
        } catch (JWTException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token absent',
            ]);
        }
        if ($user->isParent()) {
            try {
                $user->removeChild($request->child_id);

                return ApiResponseGenerator::responseTrue([
                    'childes' => $user->childes()->get(),
                ]);
            } catch (\Exception $exception) {
                return ApiResponseGenerator::responseFail([
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ]);
            }
        } else {
            return ApiResponseGenerator::responseFail([
                'code'    => 403,
                'message' => 'User type is not equal to parent',
            ]);
        }
    }

    public function addChild(CheckChildRequest $request)
    {
        try {
            if ( ! $user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code'    => 404,
                ]);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token expired',
            ]);
        } catch (TokenInvalidException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token invalid',
            ]);
        } catch (JWTException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token absent',
            ]);
        }
        if ($user->isParent()) {
            $check = User::checkChild($request->all());
            if ( ! $check) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'Child not found',
                    'code'    => 404,
                ]);
            }
            try {
                $user->addChild($check);

                return ApiResponseGenerator::responseTrue([
                    'childes' => $user->childes()->get(),
                ]);
            } catch (\Exception $exception) {
                return ApiResponseGenerator::responseFail([
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ]);
            }
        } else {
            return ApiResponseGenerator::responseFail([
                'code'    => 403,
                'message' => 'User type is not equal to parent',
            ]);
        }
    }

    public function savePrivacy(StorePrivacyRequest $request)
    {
        try {
            /** @var  User $user */
            if ( ! $user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code'    => 404,
                ]);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token expired',
            ]);
        } catch (TokenInvalidException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token invalid',
            ]);
        } catch (JWTException $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => $e->getStatusCode(),
                'message' => 'Token absent',
            ]);
        }
        if ($user->blocked()) {
            return ApiResponseGenerator::blocked();
        }
        $data = $request->all();
        try {
            $user->update($data);
            return ApiResponseGenerator::responseTrue(null);
        } catch (\Exception $exception) {
            return ApiResponseGenerator::responseFail([
                'message' => $exception->getMessage(),
                'code'    => $exception->getCode(),
            ]);
        }
    }
}
