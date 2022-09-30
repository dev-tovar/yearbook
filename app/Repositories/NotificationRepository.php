<?php


namespace App\Repositories;


use App\Models\NotificationRead;
use App\Models\PushHistory;
use Illuminate\Support\Facades\DB;

class NotificationRepository
{
    public function getDirectNotifications($userId, $loginUserId)
    {
        return PushHistory::query()
            ->select(
                'push_histories.id',
                'push_histories.user_id',
                'push_histories.title',
                'push_histories.image',
                'push_histories.created_at',
                'push_histories.updated_at',
                DB::raw('notification_reads.id is not null as is_read'),
                'push_histories.type'
            )
            ->where('push_histories.type', 'direct')
            ->where('push_histories.user_id', $userId)
            ->leftJoin('notification_reads', function ($j) use ($loginUserId) {
                $j->on('notification_reads.notification_id', '=', 'push_histories.id');
                $j->where('notification_reads.user_id', $loginUserId);
            })
            ->get();
    }

    public function read($notificationId, $userId)
    {
        try {
            $read = new NotificationRead;
            $read->notification_id = $notificationId;
            $read->user_id = $userId;
            $read->save();
            return true;
        } catch (\Exception $exception) {
        }
        return false;
    }
}