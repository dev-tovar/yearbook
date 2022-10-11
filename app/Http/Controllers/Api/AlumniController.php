<?php

namespace App\Http\Controllers\Api;

use App\Enums\AlumniPushType;
use App\Enums\EventsVisitStatus;
use App\Helpers\ApiResponseGenerator;
use App\Http\Requests\AlumniStoreRequest;
use App\Models\AlumniEvent;
use App\Models\AlumniPushHistory;
use App\Models\EventVisit;
use App\Transformers\AlumniListTransformer;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Spatie\Fractal\Facades\Fractal;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AlumniController extends Controller
{
    public function store(AlumniStoreRequest $request)
    {
        try {
            /** @var  User $user */
            if (!$user = JWTAuth::parseToken()->authenticate()) {
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

        if ($request->has('attending')) {
            $user->future_attending()->sync($data['attending']);
        }

        if ($request->has('careers')) {
            $user->future_aspirations()->sync($data['careers']);
        }

        if ($user->update($data)) {
            return ApiResponseGenerator::responseTrue(true);
        } else {
            return ApiResponseGenerator::responseFail(true);
        }
    }

    public function index(Request $request)
    {
        try {
            /** @var  User $user */
            if (!$user = JWTAuth::parseToken()->authenticate()) {
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

        $users = User::whereHas('users_yearbooks', function ($q) {
            $q->where('is_alumni', 1);
        })
            ->orderBy('name', 'asc')
            ->paginate(25);

        $users_clear_paginator = $users->getCollection();

        return Fractal::create()
            ->collection($users_clear_paginator, new AlumniListTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($users))
            ->toArray();

    }

    public function getMessagesCount($school_id)
    {
        try {
            /** @var  User $user */
            if (!$user = JWTAuth::parseToken()->authenticate()) {
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

        $messages = AlumniPushHistory::whereUserId($user->id)
            ->whereSchoolId($school_id)
            ->where('message_type', '<>', AlumniPushType::Event)
            ->notRead()
            ->get()
            ->unique()
            ->count();

        $events = EventVisit::where('user_id', $user->id)->where('status', EventsVisitStatus::NEW)->count();

        $data = [
            'messages' => $messages,
            'events' => $events
        ];

        return ApiResponseGenerator::responseTrue($data);
    }
}
