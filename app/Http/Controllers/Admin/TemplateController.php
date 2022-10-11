<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContentCategory;
use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{

    public function getList(Request $request)
    {
        try {
            $category = ContentCategory::find($request->category_id);
            if ($category) {
                if ($category->parentCategory
                    && $category->parentCategory->name == 'Student Tribute'
                ) {
                    $templates = Template::where('category_name',
                        'Student Tribute '.$category->name)
                        ->with('fields')->get();
                    if (count($templates)) {
                        return $templates;
                    }
                } else {
                    $templates = Template::where('category_name',
                        $category->name)
                        ->with('fields')->get();
                    if (count($templates)) {
                        return $templates;
                    }
                }

            }
            $templates = Template::whereNull('category_name')->with('fields')
                ->get();

            return $templates;
        } catch (\Exception $e) {
            Log::error($e);
            return response($e->getMessage(), '500');
        }
    }

}
