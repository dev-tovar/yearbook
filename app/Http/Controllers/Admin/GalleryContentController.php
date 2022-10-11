<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MediaManage\MediaLoader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryContentController extends MediaLoader
{
    public function index(){
        $this->authorize('yearbook.publish');
        return view('admin.gallery.content');
    }
}
