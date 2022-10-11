<?php

namespace App\Http\Controllers\Api;

use App\YearbookNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class YearbookNotificationController extends Controller
{
    public function index($yearbookId)
    {
        $notifications = YearbookNotification::with('user', 'wall')
            ->where([
                'yearbook_id' => $yearbookId,
                'user_id'     => Auth::id(),
            ])
            ->orderByDesc('created_at')
            ->paginate('25');

        foreach ($notifications as $value) {
            $value->user->grade = $value->user->getGradeLevel($yearbookId);
            $value->user->avatarImage = $value->user->getAvatar($yearbookId);
            $value->user->avatar = $value->user->getUserImage();
        }

        return $notifications;
    }

    public function destroy($id)
    {
        $notification = YearbookNotification::find($id);

        if ($notification) {
            $notification->delete();
        }

        return ['status' => true];
    }

    public function read(Request $request)
    {
        $ids = $request->ids;

        YearbookNotification::whereIn('id', $ids)
            ->update(['is_read' => 1]);

        return ['status' => true];
    }

    public function count($yearbookId)
    {
        return YearbookNotification::where([
            'yearbook_id' => $yearbookId,
            'user_id'     => Auth::id(),
            'is_read'     => false,
        ])->count();
    }
}
