<?php
/**
 * Created by PhpStorm.
 * User: tabbakka
 * Date: 7/11/18
 * Time: 4:15 PM
 */

namespace App\Http\Controllers\Api;


use App\Helpers\ApiResponseGenerator;
use App\Http\Controllers\Controller;
use App\Repositories\FeedRepository;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class NewsFeedController extends Controller
{
    protected $feedRepository;

    public function __construct(FeedRepository $feedRepository)
    {
        $this->feedRepository = $feedRepository;
    }

    public function get(Request $request, $child_id = null)
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
        $feeds = $user->getNewsFeeds($child_id);
        $feeds = $feeds->orderBy('created_at', 'desc')->get();

        if ($feeds != null) {
            return ApiResponseGenerator::responseTrue($feeds);
        } else {
            return ApiResponseGenerator::responseFail([
                'error' => 'User type not found',
                'code' => 404,
            ]);
        }
    }

    private function checkUser(){
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

        return $user;
    }

    public function get2($child_id = null)
    {
        $user = $this->checkUser();
        $feeds = $user->getNewsFeeds($child_id);
        $feeds = $feeds->orderBy('created_at', 'desc')->paginate(15);

        return $feeds;
    }

    public function view($id)
    {
        $this->feedRepository->view($id, \auth()->id());

        return ['status' => true];
    }

    public function getAlumni(Request $request, $school_id)
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
        $feeds = $user->getNewsFeeds(null, $school_id);
        $feeds = $feeds->orderBy('created_at', 'desc')->get();

        if ($feeds != null) {
            return ApiResponseGenerator::responseTrue($feeds);
        } else {
            return ApiResponseGenerator::responseFail([
                'error' => 'User type not found',
                'code' => 404,
            ]);
        }
    }

}
