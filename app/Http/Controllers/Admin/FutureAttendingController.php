<?php

namespace App\Http\Controllers\Admin;

use App\FutureAttending;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FutureAttendingController extends Controller
{
    public function index()
    {
        $this->authorize('yearbook.publish');
        $list = FutureAttending::orderBy('name')->get();

        return view('admin.future_attending.index', ['list' => $list]);
    }

    public function store(Request $request)
    {
        $slide = $request->data ?? [];
        FutureAttending::where('id', '>', 0)->delete();
        foreach ($slide as $value) {
            if ($value['name']) {
                FutureAttending::create($value);
            }
        }

        return redirect()->back();
    }
}
