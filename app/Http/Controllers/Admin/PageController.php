<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PageCreateRequest;
use App\Models\ContentCategory;
use App\Models\Page;
use App\Models\Template;
use App\User;
use App\UsersYearBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    //
    public function store(PageCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            /** @var Page $page */
            $page = Page::create([
                'template_id' => $data['template_id'],
                'category_id' => $data['category_id'],
                'is_publish' => key_exists('publish', $data),
            ]);

            if ($page->realCategory()->name == 'Cover') {
                if (Page::where('category_id', $data['category_id'])->count()
                    > 1
                ) {
                    return $this->update($request,
                        Page::where('category_id', $data['category_id'])
                            ->first()->id);
                }
            }

            if ($page->realCategory()->name == 'Grades') {
                $id = $page->template->fields()->first()->id;
                foreach ($data['grade_user'] as $value) {
                    if ($value['user_id']) {
                        $student = $page->category->yearbook->yearbook_users()
                            ->find($value['user_id']);
                        if (!$student) {
                            $value['user_id'] = '';
                        }
                    }
                    $page->contents()->create([
                        'field_id' => $id,
                        'value' => json_encode($value),
                    ]);
                }
            } elseif ($page->realCategory()->name == 'Cover'
                && $page->is_publish
            ) {
                foreach ($page->template->fields as $field) {
                    if ($field->name == 'image') {
                        $yearbook = $page->realCategory()->yearbook;
                        $yearbook->image
                            = key_exists($field->name, $data) ? json_decode($data[$field->name])->path : '';
                        $yearbook->save();
                    }
                    if ($field->name == 'title') {
                        $yearbook = $page->realCategory()->yearbook;
                        $yearbook->title = key_exists($field->name, $data) ? $data[$field->name] : '';
                        $yearbook->save();
                    }

                    $page->contents()->create([
                        'field_id' => $field->id,
                        'value' => key_exists($field->name, $data) ? $data[$field->name] : '',
                    ]);
                }
            } else {
                foreach ($page->template->fields as $field) {
                    $page->contents()->create([
                        'field_id' => $field->id,
                        'value' => key_exists($field->name, $data) ? $data[$field->name] : '',
                    ]);
                }
            }

            $redirectData = [];
            $redirectData['name'] = $page->realCategory()->name;
            $redirectData['yearbook_id'] = $page->realCategory()->year_book_id;
            $redirectData['id']
                = $page->realCategory()->yearbook->school_id;
            if ($page->category->parentCategory) {
                $redirectData['sub_category_id'] = $page->category->id;
            }

            DB::commit();

            if (!$request->ajax()) {
                return redirect()->action('Admin\ContentManagerController@index',
                    $redirectData);
            } else {
                return ['status' => true];
            }


        } catch (\Exception $exception) {
            DB::rollBack();
            if (isset($page)) {
                try {
                    $page->delete();
                } catch (\Exception $ex) {

                }

            }
            Log::error($exception);

            return redirect()->back();
        }

    }

    public function destroy($id)
    {
        $page = Page::find($id);
        if (!$page) {
            abort(404);
        }
        $page->delete();

        return redirect()->back();
    }

    public function edit($id)
    {
        /** @var Page $page */
        $page = Page::find($id);
        $category = $page->realCategory();
        $templates = Template::get();
        $subCategory = $page->subCategory();

        $page->resolveImageJson();

        $view = $category->name == 'Grades' ? 'admin.content_manager.edit_grade' : 'admin.content_manager.edit_template';

        return view($view, [
            'category' => $category,
            'sub_category' => $subCategory,
            'templates' => $templates,
            'page' => $page,
        ]);
    }

    public function markProfilesReady(Request $request)
    {
        $yearbookId = $request->yearbook_id;
        $category = ContentCategory::query()->where('name', 'Students Profile')->where('year_book_id', $yearbookId)
            ->first();
        $template = Template::where('category_name', 'Students Profile')
            ->first();
        foreach ($category->subCategories as $gradeCategory) {
            $grade = $gradeCategory->name;
            if ($gradeCategory->name == 'PK') {
                $grade = 'Pre-Kindergarten';
            } elseif ($gradeCategory->name == 'K') {
                $grade = 'Kindergarten';
            }
            $createPage = [];
            $updatePage = [];
            $users = User::query()
                ->select('users.*', 'p.is_app_publish', 'p.is_publish', 'p.id as page_id')
                ->join('users_year_books as uyb', 'users.id', '=', 'uyb.user_id')
                ->leftJoin('pages as p', function ($q) use ($gradeCategory) {
                    $q->on('users.id', '=', 'p.user_id')
                        ->where('p.category_id', $gradeCategory->id);
                })
                ->where('grade_level', $grade)
                ->where('uyb.yearbook_id', $yearbookId)
                ->get();
            foreach ($users as $user) {
                if (!$user->page_id) {
                    $page = Page::create([
                        'template_id' => $template->id,
                        'category_id' => $gradeCategory->id,
                        'is_publish' => true,
                        'user_id' => $user->id,
                        'is_app_publish' => true,
                    ]);
                    foreach ($page->template->fields as $field) {
                        $page->contents()->create([
                            'field_id' => $field->id,
                            'value' => '',
                        ]);
                    }
                } elseif (!$user->is_publish || $user->is_app_publish) {
                    $updatePage[] = $user->page_id;
                }
            }
            Page::query()->whereIn('id', $updatePage)->update(['is_app_publish' => true, 'is_publish' => true]);
        }

        return redirect()->back();
    }

    public function editProfile($categoryId, $userId)
    {
        $user = User::find($userId);
        $category = ContentCategory::find($categoryId);
        if (!$user || !$category) {
            abort(404);
        }
        $page = Page::where([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ])->with('template', 'template.fields', 'user', 'category', 'contents')
            ->first();
        $template = Template::where('category_name', 'Students Profile')
            ->first();

        if (!$page) {
            $page = Page::create([
                'template_id' => $template->id,
                'category_id' => $categoryId,
                'is_publish' => false,
                'user_id' => $userId,
            ]);
            foreach ($page->template->fields as $field) {
                $page->contents()->create([
                    'field_id' => $field->id,
                    'value' => '',
                ]);
            }

            $page = Page::where([
                'category_id' => $category->id,
                'user_id' => $user->id,
            ])->with('template', 'user', 'template.fields', 'category',
                'contents')->first();
        }
        $page->user->avatar1 = $page->user->getImage($category->year_book_id);
        $page->user->grade_level
            = $page->user->getGradeLevel($category->year_book_id);

        $page->user->photo_video
            = $page->user->getPhotoVideo($category->year_book_id);

        return view('admin.content_manager.edit_profile_template', [
            'category' => $category->parentCategory,
            'sub_category' => $category,
            'templates' => [$template],
            'page' => $page,
        ]);
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            /** @var Page $page */
            $page = Page::find($id);


            $page->update([
                'template_id' => $data['template_id'],
                'category_id' => $data['category_id'],
                'is_publish' => key_exists('publish', $data),
            ]);

            $page->contents()->delete();

            if ($page->realCategory()->name == 'Grades') {
                $id = $page->template->fields()->first()->id;
                foreach ($data['grade_user'] as $value) {
                    if ($value['user_id']) {
                        $student = $page->category->yearbook->yearbook_users()
                            ->find($value['user_id']);
                        if (!$student) {
                            $value['user_id'] = '';
                        }
                    }
                    $page->contents()->create([
                        'field_id' => $id,
                        'value' => json_encode($value),
                    ]);
                }
            } elseif ($page->realCategory()->name == 'Cover'
                && $page->is_publish
            ) {
                $yearbook = $page->realCategory()->yearbook;
                $yearbook->title = '';
                $yearbook->save();
                foreach ($page->template->fields as $field) {
//                    if ( ! key_exists($field->name, $data)) {
//                        continue;
//                    }
                    if ($field->name == 'image') {
                        $yearbook->image
                            = key_exists($field->name, $data) ? json_decode($data[$field->name])->path : '';
                        $yearbook->save();
                    }
                    if ($field->name == 'title') {
                        $yearbook->title = key_exists($field->name, $data) ? $data[$field->name] : '';
                        $yearbook->save();
                    }
                    $page->contents()->create([
                        'field_id' => $field->id,
                        'value' => key_exists($field->name, $data) ? $data[$field->name] : '',
                    ]);
                }
            } else {
                foreach ($page->template->fields as $field) {
//                    if ( ! key_exists($field->name, $data)) {
//                        throw new \Exception();
//                    }
                    $page->contents()->create([
                        'field_id' => $field->id,
                        'value' => key_exists($field->name, $data) ? $data[$field->name] : '',
                    ]);
                }
            }

            if ($page->realCategory()->name == 'Students Profile') {
                $yearbook = $page->realCategory()->yearbook;
                $usersYearbooks = $page->user->users_yearbooks()
                    ->where('yearbook_id', $yearbook->id)->first();
                $usersYearbooks->photo_video = $request->photo_video_section;

                $usersYearbooks->save();
            }

            $redirectData = [];
            $redirectData['name'] = $page->realCategory()->name;
            $redirectData['yearbook_id'] = $page->realCategory()->year_book_id;
            $redirectData['id']
                = $page->realCategory()->yearbook->school_id;
            if ($page->category->parentCategory) {
                $redirectData['sub_category_id'] = $page->category->id;
            }

            DB::commit();

            if (!$request->ajax()) {
                return redirect()->action('Admin\ContentManagerController@show',
                    ['id' => $page->category->id]);
            } else {
                return ['status' => true];
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);

            return redirect()->back();
        }
    }

    public function sort(Request $request)
    {
        $data = $request->all();
        foreach ($data as $value) {
            $page = Page::find($value['id']);
            $page->position = $value['index'];
            $page->save();
        }

        return ['status' => true];
    }
}
