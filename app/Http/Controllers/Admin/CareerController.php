<?php

namespace App\Http\Controllers\Admin;

use App\Models\Career;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CareerController extends Controller
{
    public function index()
    {
        $list = Career::orderBy('name')->get()->toArray();

        return view('admin.career.index', ['list' => $list]);

    }

    public function store(Request $request)
    {
        $data = $request->all()['data'];
        foreach ($data as $item) {
            Career::updateOrCreate(['id' => $item['id']], ['name' => $item['name']]);
        }

        return redirect()->back();
    }
}
