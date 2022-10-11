<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\SocialAttachRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Abraham\TwitterOAuth\TwitterOAuth;

class SocialController extends Controller
{
    public static $providers = [
        'facebook',
        'twitter',
        'linkedin',
        'instagram'
    ];

    public function attach($provider, SocialAttachRequest $request)
    {
        if (in_array($provider, self::$providers)) {
            $user = auth()->user();
            $user->{$provider . '_link'} = $request->link;
            $user->save();
        }

        return $this->get();
    }

    public function get()
    {
        $user = auth()->user();
        return [
            'facebook' => $user->facebook_link,
            'twitter' => $user->twitter_link,
            'linkedin' => $user->linkedin_link,
            'instagram' => $user->instagram_link,
        ];
    }

    public function remove($provider)
    {
        if (in_array($provider, self::$providers)) {
            $user = auth()->user();
            $user->{$provider . '_link'} = null;
            $user->save();
        }

        return $this->get();
    }
}
