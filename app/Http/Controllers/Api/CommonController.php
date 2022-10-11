<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function getCurrentVersion()
    {
        return ['data' => ['version' => env('CURRENT_APP_VERSION', '0.4')]];
    }
}
