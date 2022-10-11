<?php

namespace App\Http\Controllers\Api;

use App\Events\YearbookNotificationEvent;
use App\Http\Requests\StoreWallRequest;
use App\Http\Requests\WallActionRequest;
use App\Invite;
use App\User;
use App\Wall;
use App\Http\Controllers\Controller;
use App\YearBook;
use App\YearbookNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class WallController extends Controller
{
    public function store(StoreWallRequest $request)
    {
        $data = $request->all();
        if (isset($data['yearbook_notification_id'])) {
            $notification = YearbookNotification::query()->find($data['yearbook_notification_id']);
            if ($notification) {
                try {
                    $notification->is_action = true;
                    $notification->save();
                } catch (\Exception $exception) {
                    Log::error($exception);
                }
            }
        }

        $wall = $this->storeToWall($request);

        if ($wall instanceof JsonResponse) {
            return $wall;
        }

        /** @var User $fromUser */
        $fromUser = Auth::user();
        $message = "{$fromUser->name} wrote in your yearbook!";
        $type = 'wrote_in_wall';

        $user = User::query()->find($request->user_id);
        /** @var YearBook $yearbook */
        $yearbook = YearBook::query()->find($request->yearbook_id);

        event(new YearbookNotificationEvent($message, $type, $user,
            $fromUser, $yearbook, $wall));

        return ['status' => true];
    }

    public function storeWallInvite(StoreWallRequest $request)
    {
        $data = $request->all();
        if (isset($data['yearbook_notification_id'])) {
            $notification = YearbookNotification::query()->find($data['yearbook_notification_id']);
            if ($notification) {
                try {
                    $notification->is_action = true;
                    $notification->save();
                } catch (\Exception $exception) {
                    Log::error($exception);
                }
            }
        }

        $wall = $this->storeToWall($request);
        if ($wall instanceof JsonResponse) {
            return $wall;
        }
        $invite = $this->storeToInvite($request);
        if ($invite instanceof JsonResponse) {
            return $invite;
        }

        /** @var User $fromUser */
        $fromUser = Auth::user();
        $message = "{$fromUser->name} wrote in your yearbook & invited you to write in theirs!";
        $type = 'wrote_wall_invite';

        $user = User::query()->find($request->user_id);
        /** @var YearBook $yearbook */
        $yearbook = YearBook::query()->find($request->yearbook_id);

        event(new YearbookNotificationEvent($message, $type, $user,
            $fromUser, $yearbook, $wall, true, false));

        event(new YearbookNotificationEvent(
            "{$fromUser->name} wrote in your yearbook!",
            'wrote_in_wall',
            $user,
            $fromUser,
            $yearbook,
            $wall,
            false,
            true
        ));
        event(new YearbookNotificationEvent(
            "{$fromUser->name} invited you to write in their yearbook!",
            'wall_invite',
            $user,
            $fromUser,
            $yearbook,
            $wall,
            false,
            true
        ));

        return ['status' => true];
    }

    public function approve(WallActionRequest $request, $id)
    {
        $data = $request->all();
        if (isset($data['yearbook_notification_id'])) {
            $notification = YearbookNotification::query()->find($data['yearbook_notification_id']);
            if ($notification) {
                try {
                    $notification->is_action = true;
                    $notification->save();
                } catch (\Exception $exception) {
                    Log::error($exception);
                }
            }
        }

        $wall = Wall::find($id);
        if (!$wall) {
            abort(404);
        }

        $wall->status = 'approve';
        $wall->approve_date = (new \DateTime())->format('Y-m-d h:i:s');
        $wall->save();

//        foreach ($wall->notifications()->get() as $notification) {
//            $notification->delete();
//        }

        return ['status' => true];
    }

    public function decline(WallActionRequest $request, $id)
    {
        $data = $request->all();
        if (isset($data['yearbook_notification_id'])) {
            $notification = YearbookNotification::query()->find($data['yearbook_notification_id']);
            if ($notification) {
                try {
                    $notification->is_action = true;
                    $notification->save();
                } catch (\Exception $exception) {
                    Log::error($exception);
                }
            }
        }

        /** @var Wall $wall */
        $wall = Wall::find($id);
        if (!$wall) {
            abort(404);
        }

        $wall->status = 'decline';
        $wall->save();

//        foreach ($wall->notifications()->get() as $notification) {
//            $notification->delete();
//        }

        return ['status' => true];
    }

    private function storeToWall($request)
    {
        $data = [];
        $data['user_id'] = $request->user_id;
        $data['from_user_id'] = Auth::id();
        $data['yearbook_id'] = $request->yearbook_id;

        if (Wall::where($data)->first() !== null) {
            return response()->json(['error' => 'Already write'], 409);
        }

        $data['message'] = $request->message;

        /** @var Wall $wall */
        $wall = Wall::create($data);

        return $wall;
    }

    private function storeToInvite($request)
    {
        $data = [];
        $data['from_user_id'] = Auth::id();
        $data['to_user_id'] = $request->user_id;
        $data['yearbook_id'] = $request->yearbook_id;

        if (Invite::where($data)->first() !== null) {
            return response()->json(['error' => 'Already invited'], 409);
        }

        return Invite::create($data);
    }

    public function delete($id)
    {
        $wall = Wall::query()->where('user_id', Auth::id())->find($id);
        if ($wall) {
            $wall->delete();
            return ['status' => true];
        } else {
            return ['status' => false];
        }
    }
}
