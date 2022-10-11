<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseGenerator;
use App\PushHistory;
use App\Repositories\NotificationRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function index(Request $request, $id = null)
    {
        try {
            if (!$id) {
                $id = Auth::id();
            }

            $notifications = $this->notificationRepository->getDirectNotifications($id, Auth::id());

            return ApiResponseGenerator::responseTrue($notifications);
        } catch (\Exception $exception) {
            Log::error($exception);

            return ApiResponseGenerator::responseFail([
                'code' => 500,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function read($id)
    {
        $status = $this->notificationRepository->read($id, Auth::id());
        return [
            'status' => $status
        ];
    }

    public function destroy(Request $request, $id)
    {
        try {
            /** @var User $user */
            $user = Auth::user();
            $notification = PushHistory::find($id);
            if ($notification) {
                $notification->delete();

                return ['status' => true];
            }

            return ['status' => false];
        } catch (\Exception $exception) {
            Log::error($exception);

            return ['status' => false];
        }
    }
}
