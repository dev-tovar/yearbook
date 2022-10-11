<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseGenerator;
use App\Http\Requests\BankApiRequest;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class BankController extends Controller
{
    public function get(BankApiRequest $request)
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

        $id = $request->school_id;

        try {
            $data = BankAccount::whereSchoolId($id)->firstOrFail();
        } catch (\Exception $e) {
            return ApiResponseGenerator::responseFail([
                'code'    => 404,
                'message' => 'School not found',
            ]);
        }

        return ApiResponseGenerator::responseTrue($data);
    }
}
