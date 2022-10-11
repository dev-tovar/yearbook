<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MediaManage\MediaLoader;
use Illuminate\Http\Request;

class GalleryController extends MediaLoader
{
    public function index()
    {
        $this->authorize('yearbook.publish');
        return view('admin.gallery.index');
    }

    public function content(){
        $this->authorize('yearbook.publish');
        return view('admin.gallery.content');
    }
}
