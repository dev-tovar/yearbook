<?php

namespace App\Http\Controllers\Api;

use App\Events\YearbookNotificationEvent;
use App\Http\Requests\StoreInviteRequest;
use App\Http\Resources\UserInviteResource;
use App\Invite;
use App\Repositories\YearBookRepository;
use App\User;
use App\YearBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    protected $yearBookRepository;

    public function __construct(YearBookRepository $yearBookRepository)
    {
        $this->yearBookRepository = $yearBookRepository;
    }

    public function userList($yearbookId)
    {
            $list = $this->yearBookRepository->getInviteUsers($yearbookId,\auth()->id());

        return UserInviteResource::collection($list)->jsonSerialize();
    }

    public function store(StoreInviteRequest $request)
    {
        $data = [];
        $data['from_user_id'] = Auth::id();
        $data['to_user_id'] = $request->user_id;
        $data['yearbook_id'] = $request->yearbook_id;

        if (Invite::where($data)->first() !== null) {
            return response()->json(['error' => 'Already invited'], 409);
        }

        Invite::create($data);

        /** @var User $fromUser */
        $fromUser = Auth::user();

        $yearbook = YearBook::find($request->yearbook_id);

        $user = User::find($request->user_id);

        $type = 'wall_invite';

        $message = "{$fromUser->name} invited you to write in their yearbook!";

        event(new YearbookNotificationEvent($message, $type, $user,
            $fromUser, $yearbook));

        return ['status' => true];
    }
}
