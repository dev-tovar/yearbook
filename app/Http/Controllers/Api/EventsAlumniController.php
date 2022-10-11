<?php

namespace App\Http\Controllers\Api;

use App\Enums\EventsVisitStatus;
use App\Helpers\ApiResponseGenerator;
use App\Models\AlumniEvent;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class EventsAlumniController extends Controller
{
    public function get(Request $request, $child_id = null)
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
        $events = $user->getEvents($child_id);
        $events = optional(
            optional($events)
                ->orderBy('created_at', 'desc'))
            ->get();

        $events->each(function ($event) use ($user) {
            $event->status = $this->getEventStatus($event, $user);
        });

        if ($events != null) {
            return ApiResponseGenerator::responseTrue($events);
        } else {
            return ApiResponseGenerator::responseFail([
                'error' => 'Events not found',
                'code'  => 404,
            ]);
        }
    }

    /**
     * Confirmation event from user
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @property                  $status 1 - confirm, 2- unconfirmed
     *
     * @property                  $event_id
     * @property                  $user_id
     */
    public function confirm(Request $request)
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

        try {
            $data = json_decode($request->getContent(), true);
            $event = AlumniEvent::find($data['event_id']);
            $user->events()->detach($event->id);
            $user->events()->attach($event, ['status' => $data['status']]);
        } catch (\Exception $exception) {
            return ApiResponseGenerator::responseFail([
                'code'    => 400,
                'message' => 'Wrong data in request',
            ]);
        }

        return ApiResponseGenerator::responseTrue('Events visit status updated');
    }

    private function getEventStatus($event, $user)
    {
        return optional($event->users()
                    ->withPivot('status')
                    ->where('user_id', $user->id)
                    ->first())
                ->pivot->status ?? EventsVisitStatus::NEW;
    }
}
