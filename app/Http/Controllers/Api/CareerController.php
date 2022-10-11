<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseGenerator;
use App\Models\Career;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CareerController extends Controller
{
    public function get(Request $request)
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

        $data = Career::orderBy('name')->get();

        return ApiResponseGenerator::responseTrue($data);
    }

    public function attach(Request $request)
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

        $data = $request->careers ?? [];

        try {
            $user->careers()->sync($data);
            return ApiResponseGenerator::responseTrue(null);
        } catch (\Exception $exception) {
            return ApiResponseGenerator::responseFail([
                'error' => 'Wrong careers data',
                'code'    => 400,
            ]);
        }
    }
}
