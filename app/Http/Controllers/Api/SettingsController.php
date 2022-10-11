<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseGenerator;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DeviceTokenRequest;
use App\Http\Requests\DeviceTokensRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\NotificationRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class SettingsController extends Controller
{
    //
    public function password(ChangePasswordRequest $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return ApiResponseGenerator::responseFail([
                'message' => 'User not found',
                'code' => 404,
            ]);
        }
        /** @var User $user */
        if ($user->blocked()) {
            return ApiResponseGenerator::blocked();
        }
        $data = $request->validated();
        try {
            if ($user->checkPassword($data['old_password'])) {
                $user->password = $data['password'];
                $user->save();

                return ApiResponseGenerator::responseTrue(null);
            } else {
                return ApiResponseGenerator::responseFail([
                    'message' => 'Wrong old password',
                    'code' => '422',
                ]);
            }
        } catch (\Exception $exception) {
            return ApiResponseGenerator::responseFail([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
        }
    }

    public function forgot(ForgotPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            /** @var User $user */
            $user = User::where('email', '=', $data['email'])->get();
            if ($user->count() > 0) {
                $user = $user->first();
                if ($user->blocked()) {
                    return ApiResponseGenerator::blocked();
                }
                $new_password = User::generatePassword();
                $user->password = $new_password;
                $user->save();
                $mailData = [
                    'email' => $data['email'],
                    'password' => $new_password,
                ];
                $email = $data['email'];
                Mail::send('mail.mail', $mailData,
                    function ($m) use ($new_password, $email) {
                        $m->to($email)
                            ->subject('New Password');
                    });

                return ApiResponseGenerator::responseTrue(null);
            } else {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code' => 404,
                ]);
            }
        } catch (\Exception $exception) {
            return ApiResponseGenerator::responseFail([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
        }
    }

    public function setDeviceToken(DeviceTokenRequest $request)
    {
        try {
            /** @var  User $user */
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code' => 404,
                ]);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token expired',
            ]);
        } catch (TokenInvalidException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token invalid',
            ]);
        } catch (JWTException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token absent',
            ]);
        }

        if ($user->blocked()) {
            return ApiResponseGenerator::blocked();
        }
        $data = $request->all();
        $result = $user->setToken($data['device'], $data['token']);
        if ($result === true) {
            return ApiResponseGenerator::responseTrue(null);
        } else {
            return ApiResponseGenerator::responseFail([
                'code' => $result->getCode(),
                'message' => $result->getMessage(),
            ]);
        }
    }

    public function deleteDeviceToken(DeviceTokenRequest $request)
    {
        try {
            /** @var  User $user */
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code' => 404,
                ]);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token expired',
            ]);
        } catch (TokenInvalidException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token invalid',
            ]);
        } catch (JWTException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token absent',
            ]);
        }

        if ($user->blocked()) {
            return ApiResponseGenerator::blocked();
        }
        $data = $request->all();
        $result = $user->resetToken($data);
        if ($result === true) {
            return ApiResponseGenerator::responseTrue(null);
        } else {
            return ApiResponseGenerator::responseFail([
                'code' => $result->getCode(),
                'message' => $result->getMessage(),
            ]);
        }
    }

    public function notification(NotificationRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->blocked()) {
            return ApiResponseGenerator::blocked();
        }
        $data = $request->validated();
        $user->update($data);
        try {
            return ApiResponseGenerator::responseTrue($user);

        } catch (\Exception $exception) {
            return ApiResponseGenerator::responseFail([
                'code' => 422,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function changeEmail(ChangeEmailRequest $request)
    {
        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return ['status' => true];
    }

    public function setDeviceTokens(DeviceTokensRequest $request)
    {
        try {
            /** @var  User $user */
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code' => 404,
                ]);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token expired',
            ]);
        } catch (TokenInvalidException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token invalid',
            ]);
        } catch (JWTException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token absent',
            ]);
        }

        if ($user->blocked()) {
            return ApiResponseGenerator::blocked();
        }
        $data = $request->validated();
        $result = $user->setTokens($data);
        if ($result === true) {
            return ApiResponseGenerator::responseTrue(null);
        } else {
            return ApiResponseGenerator::responseFail([
                'code' => $result->getCode(),
                'message' => $result->getMessage(),
            ]);
        }
    }

    public function removeDeviceToken(DeviceTokenRequest $request)
    {
        try {
            /** @var  User $user */
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponseGenerator::responseFail([
                    'message' => 'User not found',
                    'code' => 404,
                ]);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token expired',
            ]);
        } catch (TokenInvalidException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token invalid',
            ]);
        } catch (JWTException $e) {
            return ApiResponseGenerator::responseFail([
                'code' => $e->getStatusCode(),
                'message' => 'Token absent',
            ]);
        }

        if ($user->blocked()) {
            return ApiResponseGenerator::blocked();
        }
        $data = $request->validated();
        $result = $user->removeToken($data['device']);
        if ($result === true) {
            return ApiResponseGenerator::responseTrue(null);
        } else {
            return ApiResponseGenerator::responseFail([
                'code' => $result->getCode(),
                'message' => $result->getMessage(),
            ]);
        }
    }
}
