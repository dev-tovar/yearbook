<?php

namespace App\Http\Controllers\Api;

use App\Enums\DonateStatus;
use App\Helpers\ApiResponseGenerator;
use App\Models\Donate;
use App\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class DonateController extends Controller
{
    public function openLending(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
        ]);

        $school_id = $request->school_id;
        $user = Auth::user();

        try {
            $account = School::findorFail($school_id)->account()->first();
            Donate::updateOrCreate([
                'school_id' => $school_id,
                'user_id'   => $user->id,
                'status'    => DonateStatus::Start,
            ],[
                'amount'    => 0,
            ]);
        } catch (\Exception $exception) {
            return ApiResponseGenerator::responseFail([
                'code'    => '422',
                'message' => $exception->getMessage(),
            ]);
        }

        return ApiResponseGenerator::responseTrue($account);

    }

    public function pay(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'status' => 'numeric|required|digits_between:1,1'
        ]);

        $school_id = $request->school_id;
        $user = Auth::user();
        $status = $request->status === DonateStatus::Pay ? DonateStatus::Pay : DonateStatus::Cancel;
        $amount  = isset($request->amount) ? $request->amount : 0;


//        Log::error('---- Message response, status: ' . $status . '; user_id: ' . $user->id);

        try {
            Donate::whereSchoolId($school_id)
                ->whereUserId($user->id)
                ->whereStatus(DonateStatus::Start)
                ->update([
                    'amount'    => $amount,
                    'status'    => $status,
                ]);
        } catch (\Exception $exception) {
            return ApiResponseGenerator::responseFail([
                'code'    => '422',
                'message' => $exception->getMessage(),
            ]);
        }

        return ApiResponseGenerator::responseTrue([
            'payed'
        ]);
    }
}
