<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseGenerator;
use App\Http\Requests\MarkImageConfirmRequest;
use App\Http\Requests\MarkImageMakeRequest;
use App\Http\Resources\UserMarkResourse;
use App\Services\MarkImage\MarkImageService;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarkImageController extends Controller
{
    /**
     * @var MarkImageService
     */
    public $markImageService;

    /**
     * YearbookController constructor.
     * @param MarkImageService $markImageService
     */
    public function __construct(MarkImageService $markImageService)
    {
        $this->markImageService = $markImageService;
    }

    /**
     * @param MarkImageMakeRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function make(MarkImageMakeRequest $request)
    {
        try {
            return $this->markImageService->save($request->all());
        } catch (\Exception $ex) {
            Log::error($ex);

            return ApiResponseGenerator::responseFail(
                [
                    'message' => $ex->getMessage(),
                    'code' => 400
                ]
            );
        }
    }

    /**
     * @param MarkImageConfirmRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function confirm(MarkImageConfirmRequest $request, $id)
    {
        try {
            return $this->markImageService->confirm($request->all(), $id);
        } catch (\Exception $ex) {
            Log::error($ex);

            return ApiResponseGenerator::responseFail(
                [
                    'message' => $ex->getMessage(),
                    'code' => 400
                ]
            );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function getMark(Request $request)
    {
        try {
            return $this->markImageService->getMark($request->patch,$request->yearbook_id);
        } catch (\Exception $ex) {
            Log::error($ex);

            return ApiResponseGenerator::responseFail(
                [
                    'message' => $ex->getMessage(),
                    'code' => 400
                ]
            );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function userList(Request $request)
    {
        /** @var Collection $list */
        $list = $this->markImageService->userList($request);
        return UserMarkResourse::collection($list);
    }
}
