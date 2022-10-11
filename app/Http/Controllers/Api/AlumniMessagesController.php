<?php

namespace App\Http\Controllers\Api;

use App\Enums\AlumniPushType;
use App\Helpers\ApiResponseGenerator;
use App\Models\AlumniPushHistory;
use App\User;
use App\YearbookNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AlumniMessagesController extends Controller
{
    public function get($school_id)
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

        return ApiResponseGenerator::responseTrue(AlumniPushHistory::where('school_id', $school_id)
            ->where('user_id', $user->id)
            ->where('message_type', '<>', AlumniPushType::Event)
            ->orderBy('id', 'DESC')
            ->get());
    }

    public function read($id)
    {
        try {
            AlumniPushHistory::where('id', $id)->update(['is_read' => true]);
        } catch (\Exception $exception) {
            Log::error($exception);

            return ['status' => false];
        }

        return ['status' => true];
    }

    public function destroy($id)
    {
        try {
            $notification = AlumniPushHistory::find($id);
            $notification->delete();
        } catch (\Exception $exception) {
            Log::error($exception);

            return ['status' => false];
        }

        return ['status' => true];
    }

}
