<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DonateStatus;
use App\Http\Requests\UpdateDonate;
use App\Models\Donate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DonateController extends Controller
{
    public function index(Request $request)
    {
        $school = Auth::user()->getSchool();
        $order = $request->has('status') ? $request->status : 'desc';
        $donates = Donate::with('users')
            ->search($request->search ?? '')
            ->where('school_id', $school->id)
            ->where('status', '>', DonateStatus::Start)
            ->orderBy('created_at', $order)
            ->paginate(50);

        return view('admin.donate.index', compact('donates', 'school', 'order', 'request'));

    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            Donate::findOrFail($id)->delete();
        } catch (\Exception $exception) {
            redirect()->back()->with('error-message', 'Donate was not found');
        }

        return redirect()->back()->with('success-message', 'Donation was successfully deleted');
    }

    public function update(UpdateDonate $request)
    {
        $validatedData = $request->validated();
        try {
            $donate = Donate::findOrFail($request->id);
            $donate->update($validatedData);
        } catch (\Exception $exception) {

        }

        return redirect()->back()->with('success-message', 'Donation was successfully updated');
    }
}
