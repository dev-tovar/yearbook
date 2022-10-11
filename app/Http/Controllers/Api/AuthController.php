<?php
/**
 * Created by PhpStorm.
 * User: tabbakka
 * Date: 7/10/18
 * Time: 5:21 PM
 */

namespace App\Http\Controllers\Api;


use App\Helpers\ApiResponseGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\APILoginRequest;
use App\Http\Requests\ApiRegistrationRequest;
use App\Http\Requests\CheckChildRequest;
use App\Http\Requests\DeviceTokenRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(APILoginRequest $request) {
//        dd(123);
        $credentials = $request->validated();

        try {
            if(!$token = JWTAuth::attempt($credentials)) {
                return ApiResponseGenerator::responseFail([
                    'code' => 401,
                    'message' => 'Invalid credentials'
                ]);
            }
            if (Auth::user()->blocked()) {
                return ApiResponseGenerator::blocked();
            }
            return ApiResponseGenerator::responseTrue([
                'token' => $token,
                'user_type' => Auth::user()->user_type,
                'is_alumni' => Auth::user()->isAlumni()
            ]);
        }
        catch (JWTException $exception) {
            return ApiResponseGenerator::responseFail([
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function logout(DeviceTokenRequest $request)
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
        $data   = $request->validated();
        $result = $user->resetToken($data);

        try {
            if (JWTAuth::parseToken()->invalidate()) {
                return ApiResponseGenerator::responseTrue(['result' => 'logged_out']);
            }
        }
        catch (JWTException $exception) {
            return ApiResponseGenerator::responseFail([
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function registration(ApiRegistrationRequest $request) {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $user = null;
            if ($request->user_type == "student") {
                $user = User::register($data);
            } elseif ($request->user_type == "parent") {
                $user = User::registerParent($data);
            }
            DB::commit();
            if ($user === false) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User already registered',
                    'code' => 422
                ]);
            } elseif ($user === null) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code' => 404
                ]);
            } elseif($user instanceof User) {
                return ApiResponseGenerator::responseTrue(null);
            } else {
            	return ApiResponseGenerator::responseFail($user);
            }
        }
        catch (JWTException $exception) {
            Log::error($exception);
            DB::rollBack();
            return ApiResponseGenerator::responseFail([
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ]);
        }
        catch (\Exception $ex){
            Log::error($ex);
            DB::rollBack();
            return ApiResponseGenerator::responseFail([
                'code' => 422,
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function checkChild(CheckChildRequest $request) {
        $check = User::checkChild($request->all());
        if (!$check) {
            return ApiResponseGenerator::responseFail([
                'message' => 'Child not found',
                'code' => 404
            ]);
        }
        return ApiResponseGenerator::responseTrue([
            'user_id' => $check
        ]);
    }

}
