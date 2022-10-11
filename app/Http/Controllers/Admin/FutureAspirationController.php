<?php

namespace App\Http\Controllers\Admin;

use App\FutureAspiration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FutureAspirationController extends Controller
{
    public function index()
    {
        $this->authorize('yearbook.publish');
        $list = FutureAspiration::orderBy('name')->get();

        return view('admin.future_aspiration.index', ['list' => $list]);
    }

    public function store(Request $request)
    {
        $slide = $request->data ?? [];
        FutureAspiration::where('id', '>', 0)->delete();
        foreach ($slide as $value) {
            if ($value['name']) {
                FutureAspiration::create($value);
            }
        }

        return redirect()->back();
    }
}
