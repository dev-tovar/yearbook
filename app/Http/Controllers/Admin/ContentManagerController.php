<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContentManagerCreateRequest;
use App\Http\Requests\ContentManagerDeleteSubRequest;
use App\Http\Requests\TemplatePageRequest;
use App\Models\ContentCategory;
use App\Models\Page;
use App\Models\PageContent;
use App\Models\Template;
use App\Models\TemplateFields;
use App\School;
use App\User;
use App\YearBook;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContentManagerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $yearbook = YearBook::findOrFail($request->yearbook_id);
            $categoryOpened = $yearbook->contentCategories()
                ->where('name', '=', ucwords($request->name))
                ->get()
                ->first();

            $subCategoryOpened = null;

            if (($request->has('sub_category_id'))
                && (isset($request->sub_category_id))
            ) {
                $subCategoryOpened
                    = ContentCategory::findOrFail($request->sub_category_id);
            } else {
                $subCategoryOpened = $categoryOpened->subCategories()->get()
                    ->first();
            }

            $redirectId = $subCategoryOpened ? $subCategoryOpened->id
                : $categoryOpened->id;

            return redirect()->action('Admin\ContentManagerController@show',
                ['id' => $redirectId]);
        } catch (\Exception $e) {
            Log::error($e);

            return response($e->getMessage(), 404);
        }
    }

    public function show($id)
    {
        /** @var ContentCategory $categoryOpened */
        $categoryOpened = ContentCategory::find($id);
        $subCategoryOpened = null;
        if ($categoryOpened->parent_category_id) {
            $subCategoryOpened = $categoryOpened;
            $categoryOpened = $subCategoryOpened->parentCategory;
        } else {
            $subCategoryOpened = $categoryOpened->subCategories()->get()
                ->first();
        }


        $userList = [];
        if ($categoryOpened->name == 'Students Profile') {
            $grade = $subCategoryOpened->name;
            if ($subCategoryOpened->name == 'PK') {
                $grade = 'Pre-Kindergarten';
            } elseif ($subCategoryOpened->name == 'K') {
                $grade = 'Kindergarten';
            }

            /** @var ContentCategory $categoryOpened */
            $userList = $categoryOpened->yearbook->users()
                ->where('grade_level', $grade)
                ->orderBy('name')
                ->with([
                    'pages' => function ($query) use ($subCategoryOpened) {
                        $query->where('category_id', $subCategoryOpened->id);
                    },
                ]);
            $filter = \request()->get('filter', []);
            if (isset($filter['search'])) {
                $q = strtolower($filter['search']);
                $userList->where('name', 'like', "%$q%");
            }
            if (isset($filter['status'])) {
                switch ((int)$filter['status']) {
                    case 1:
                        $userList->whereDoesntHave('pages', function ($query) use ($subCategoryOpened) {
                            $query->where('category_id', $subCategoryOpened->id);
                        });
                        break;
                    case 2:
                        $userList->whereHas('pages', function ($query) use ($subCategoryOpened) {
                            $query->where('category_id', $subCategoryOpened->id);
                            $query->where('is_publish', '!=', 1);
                        });
                        break;
                    case 3:
                        $userList->whereHas('pages', function ($query) use ($subCategoryOpened) {
                            $query->where('category_id', $subCategoryOpened->id);
                            $query->where('is_publish', '=', 1);
                        });
                        break;
                }

            }
            $userList = $userList->paginate(25);
            foreach ($userList as &$user) {
                $user->avatar1 = $user->getImage($categoryOpened->year_book_id);
            }
        } elseif ($categoryOpened->name == 'Student Tribute') {

        }

//        dd($subCategoryOpened->pages()->with('user','user.parents','category')->get());

        $rootIndex = Page::whereHas('category',
            function ($q) use ($categoryOpened, $subCategoryOpened) {
                $q->where(function ($qq) use ($categoryOpened) {
                    $qq->where('year_book_id', $categoryOpened->year_book_id);
                    $qq->where('parent_category_id', null);
                    $qq->where('position', '<', $categoryOpened->position);
                });
                $q->orWhere(function ($qq) use ($categoryOpened) {
                    $qq->whereHas('parentCategory',
                        function ($qqq) use ($categoryOpened) {
                            $qqq->where('year_book_id', $categoryOpened->year_book_id);
                            $qqq->where('parent_category_id', null);
                            $qqq->where('position', '<',
                                $categoryOpened->position);
                        });
                });
                if ($subCategoryOpened) {
                    $q->orWhere(function ($qq) use (
                        $categoryOpened,
                        $subCategoryOpened
                    ) {
                        $qq->where('year_book_id', $categoryOpened->year_book_id);
                        $qq->where('parent_category_id',
                            $categoryOpened->id);
                        $qq->where('position', '<',
                            $subCategoryOpened->position);
                    });
                }

            })->count();


        $viewData = [
            'school' => $categoryOpened->yearbook->school,
            'yearbook' => $categoryOpened->yearbook,
            'filter' => \request()->get('filter', []),
            'categoryOpened' => $categoryOpened,
            'subCategoryOpened' => $subCategoryOpened,
            'userList' => $userList,
            'rootPageIndex' => $rootIndex,
        ];

        return view('admin.content_manager.category', $viewData);
    }

    public function delete(ContentManagerDeleteSubRequest $request)
    {
        try {
            $data = $request->validated();
            $sub = SubCategory::findOrFail($data['sub_category_id']);
            $sub->delete();

            return response(json_encode([
                'success' => true,
            ]), '200');
        } catch (\Exception $exception) {
            Log::error($exception);

            return response($exception->getMessage(), '500');
        }
    }

    public function create(ContentManagerCreateRequest $request)
    {
        try {
            $data = $request->validated();
            switch ($data['create']) {
                case 'page':
                    if (isset($data['sub_category'])
                        && isset($data['sub_category_id'])
                    ) {
                        $data['sub'] = true;
                        $data['category_id'] = $data['sub_category_id'];
                        $page = Page::create($data);
                    }
                    break;
                case 'sub_category':
                    $category = ContentCategory::find($data['category_id']);
                    $position = $category->subCategories()->max('position')
                        + 1;
                    $subCategory = $category->subCategories()->create([
                        'name' => $data['name'],
                        'year_book_id' => $category->year_book_id,
                        'position' => $position,
                    ]);
                    $category->pages()
                        ->update(['category_id' => $subCategory->id]);
                    break;
            }

            return redirect()->back()
                ->with('success-message', 'Created Succesfully');
        } catch (\Exception $exception) {
            Log::error($exception);

            return response($exception->getMessage(), '500');
        }
    }

    public function template(TemplatePageRequest $request)
    {
        try {
            $data = $request->validated();
            $category = ContentCategory::findOrFail($data['category_id']);
            $templates = Template::get();
            $subCategory = null;
            if (isset($data['sub_category_id'])) {
                $subCategory
                    = ContentCategory::findOrFail($data['sub_category_id']);
            }

            $checkCategory = $category->parentCategory
                ? $category->parentCategory : $category;

            if ($category->parentCategory) {
                $sendCategory = $category->parentCategory;
                $sendSubCategory = $category;
            } else {
                $sendCategory = $category;
                $sendSubCategory = null;
                if ($sendCategory->subCategories()->count() > 0) {
                    $sendSubCategory = $sendCategory->subCategories()->first();
                }
            }

            if ($checkCategory->name == 'Grades') {
                return view('admin.content_manager.add_grade', [
                    'category' => $sendCategory,
                    'sub_category' => $sendSubCategory,
                    'templates' => $templates,
                ]);
            }

            return view('admin.content_manager.add_template', [
                'category' => $sendCategory,
                'sub_category' => $sendSubCategory,
                'templates' => $templates,
            ]);
        } catch (\Exception $e) {
            Log::error($e);

            return response($e->getMessage(), '500');
        }
    }

    public function cover()
    {
        $category = Auth::user()->user->school->yearbooks()->first()
            ->contentCategories()->where('name', 'Cover')->first();

        return view('admin.content_manager.cover',
            ['category' => $category, 'sub_category' => null]);
    }

    public function studentsProfile()
    {
        $category = Auth::user()->user->school->yearbooks()->first()
            ->contentCategories()->where('name', 'Students Profile')->first();
        $subCategoryOpened = $category->subCategories()->get()->first();

        return view('admin.content_manager.students_profile',
            ['category' => $category, 'sub_category' => $subCategoryOpened]);
    }

    public function studentsTribute()
    {
        $category = Auth::user()->user->school->yearbooks()->first()
            ->contentCategories()->where('name', 'Student Tribute')->first();
        $subCategoryOpened = $category->subCategories()->get()->first();

        return view('admin.content_manager.students_tribute',
            ['category' => $category, 'sub_category' => $subCategoryOpened]);
    }

    public function grades()
    {
        $category = Auth::user()->user->school->yearbooks()->first()
            ->contentCategories()->where('name', 'Grades')->first();
        $subCategoryOpened = $category->subCategories()->get()->first();

        return view('admin.content_manager.grades_inner',
            ['category' => $category, 'sub_category' => $subCategoryOpened]);
    }

    public function sort(Request $request)
    {
        $data = $request->menu;
        foreach ($data as $value) {
            $category = ContentCategory::find($value['id']);
            $category->position = $value['index'];
            $category->save();
        }

        $categoryOpened = ContentCategory::find($request->categoryId);
        $subCategoryOpened = null;

        if ($categoryOpened->parent_category_id) {
            $subCategoryOpened = $categoryOpened;
            $categoryOpened = $categoryOpened->parentCategory;
        }

        $rootIndex = Page::whereHas('category',
            function ($q) use ($categoryOpened, $subCategoryOpened) {
                $q->where(function ($qq) use ($categoryOpened) {
                    $qq->where('year_book_id', $categoryOpened->year_book_id);
                    $qq->where('parent_category_id', null);
                    $qq->where('position', '<', $categoryOpened->position);
                });
                $q->orWhere(function ($qq) use ($categoryOpened) {
                    $qq->whereHas('parentCategory',
                        function ($qqq) use ($categoryOpened) {
                            $qqq->where('year_book_id', $categoryOpened->year_book_id);
                            $qqq->where('parent_category_id', null);
                            $qqq->where('position', '<',
                                $categoryOpened->position);
                        });
                });
                if ($subCategoryOpened) {
                    $q->orWhere(function ($qq) use (
                        $categoryOpened,
                        $subCategoryOpened
                    ) {
                        $qq->where('year_book_id', $categoryOpened->year_book_id);
                        $qq->where('parent_category_id',
                            $categoryOpened->id);
                        $qq->where('position', '<',
                            $subCategoryOpened->position);
                    });
                }


            })->count();

        return ['status' => true, 'rootPageIndex' => $rootIndex,];
    }

    public function rename($id, Request $request)
    {
        $name = $request->name;
        $category = ContentCategory::find($id);
        $category->name = $name;
        $category->save();

        return redirect()->action('Admin\ContentManagerController@show',
            ['id' => $id])->with('success-message', 'Renamed Succesfully');

    }

    public function deleteCategory($id, Request $request)
    {
        /** @var ContentCategory $category */
        $category = ContentCategory::find($id);

        if ($categoryId = $request->category_id) {
            $category->pages()->update(['category_id' => $categoryId]);
        }

        if ($category->parent_category_id) {
            $newId = $category->parentCategory->id;
        } else {
            $newId = $category->yearbook->contentCategories()
                ->whereNull('parent_category_id')->get()[0]->id;
        }

        $category->delete();


        return redirect()->action('Admin\ContentManagerController@show',
            ['id' => $newId])->with('success-message', 'Deleted Succesfully');

    }

    public function createCategory($yearbookId, Request $request)
    {

        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($yearbookId);

        $position = (int)$yearbook->contentCategories()
            ->where(['parent_category_id' => null, 'can_edit' => true])
            ->max('position');

        ContentCategory::create([
            'name' => $request->name,
            'year_book_id' => $yearbookId,
            'can_edit' => true,
            'position' => $position,
        ]);

        return redirect()->back()
            ->with('success-message', 'Created Succesfully');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function preview(int $id)
    {
        /** @var Page $page */
        $page = Page::with(['contents.field'])->where('id', $id)->first();
        $page->resolveImageJson();
        $attach = $page->contents->filter(function ($page) {
            if ($page->field->type == TemplateFields::IMAGE) {
                return $page;
            };
        });

        $imageUrls = '';
        foreach ($attach as $attachment) {
            $attachment = json_decode($attachment->value);

            $image = "background-image: url(" . $attachment->path . ")";
            $imageUrls .= "<div class=\"image main-image\" style=\"height: 140px; margin-bottom: 5px; background-size: contain;background-repeat: no-repeat;background-position: center;"
                . $image . "\"></div>";
        }

        return [
            'imageUrls' => $imageUrls,
        ];
    }
}
