<?php


namespace App\Repositories;


use App\Models\FeedView;

class FeedRepository
{
    public function view($feedId, $userId)
    {
        FeedView::query()->firstOrCreate(['user_id' => $userId, 'feed_id' => $feedId]);
    }

}