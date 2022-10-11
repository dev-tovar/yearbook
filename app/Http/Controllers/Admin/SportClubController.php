<?php

namespace App\Http\Controllers\Admin;

use App\SportClub;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportClubController extends Controller
{
    public function index()
    {
        $this->authorize('yearbook.publish');
        $list = SportClub::orderBy('name')->get();

        return view('admin.sport_club.index', ['list' => $list]);
    }

    public function store(Request $request)
    {
        $slide = $request->data ?? [];
        SportClub::where('id', '>', 0)->delete();
        foreach ($slide as $value) {
            if ($value['name']) {
                SportClub::create($value);
            }
        }

        return redirect()->back();
    }
}
