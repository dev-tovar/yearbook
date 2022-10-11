<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BankAccountRequest;
use App\Models\BankAccount;
use App\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($school_id = null)
    {
        if ($school_id) {
            $school = School::find($school_id);
        } else {
            $school = optional(Auth::user()->user)->school;
        }
        if (! $school) {
            return redirect()->back();
        }
        $data = BankAccount::whereSchoolId($school->id)->first();

        return view('admin.bank.form', compact('school', 'data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankAccountRequest $request)
    {
        $data = BankAccount::updateOrCreate(['school_id' => Auth::user()->user->school->id], $request->except('_token'));

        return redirect()->action('Admin\BankAccountController@index');
    }

    public function destroy(Request $request)
    {
        $id = $request->has('school_id') ? $request->school_id : '';
        BankAccount::whereSchoolId($id)->delete();

        return redirect()->action('Admin\BankAccountController@index');
    }
}
