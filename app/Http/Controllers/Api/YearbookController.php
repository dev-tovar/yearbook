<?php

namespace App\Http\Controllers\Api;

use App\Models\ContentCategory;
use App\Models\Page;
use App\Services\InAppPurchase;
use App\UsersYearBook;
use App\YearBook;
use App\Http\Requests\BuyYearbookRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class YearbookController extends Controller
{
    public function my($userId = null)
    {
        /** @var User $user */
        $user = Auth::user();

        $list = $user->getPurchasedYearbooks($userId);

        return $list;

    }

    public function available($userId = null)
    {
        /** @var User $user */
        $user = Auth::user();

        $list = $user->getAvailableYearbooks($userId);

        return $list;
    }

    public function buy(BuyYearbookRequest $request)
    {
        Log::error('buy yearbook: '.$request->yearbook_id);
        Log::error('receiptBase64Data: '.$request->receipt_data);
        Log::error('purchaseToken: '.$request->purchase_token);
        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($request->yearbook_id);

        if ($userId = $request->child_id) {
            /** @var User $user */
            $user = User::find($userId);
        } else {
            /** @var User $user */
            $user = Auth::user();
        }

        /** @var UsersYearBook $yearbookUser */
        $yearbookUser = $yearbook->yearbook_users()->where('user_id', $user->id)
            ->first();

        if ($yearbookUser->status == 'paid') {
            $this->addBuyData($yearbookUser);
            return response()->json(['status' => true,]);
        } else {
            if ($receiptBase64Data = $request->receipt_data) {
                if (InAppPurchase::verifyITunes($receiptBase64Data)) {
                    $this->addBuyData($yearbookUser);

                    $this->payEmail($user, $yearbook);

                    return response()->json(['status' => true,]);
                }
            } else if ($purchaseToken = $request->purchase_token) {
                if (InAppPurchase::verifyPlayStore($purchaseToken)) {

                    $this->addBuyData($yearbookUser);

                    $this->payEmail($user, $yearbook);

                    return response()->json(['status' => true,]);
                }
            }

            return response()->json([
                'error' => [
                    'payment' => 'Payment Information is Wrong',
                ],
            ], 422);

        }
    }

    private function payEmail($user, $yearbook)
    {
        try {
            $name = $user->name;
            $school = $yearbook->school->name;
            Mail::send('mail.pay.yearbook',
                ['name' => $name, 'school' => $school],
                function ($m) {
                    $m->to('stayconnected@pocketyearbook.com')
                        ->subject('User In-App Purchase');
                });
        } catch (\Exception $ex) {
        }
    }

    private function addBuyData(UsersYearBook $yearbookUser)
    {
        $yearbookUser->is_buy = true;
        $yearbookUser->buyed_yearbook_at
            = (new \DateTime())->format("Y-m-d H:i:s");
        $yearbookUser->status = 'paid';
        $yearbookUser->save();
    }


    public function show($id)
    {
        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($id);

        $categories = $yearbook->contentCategories()->root()
            ->where('name', '!=', 'Students Profile')->with(
                [
                    'pages' => function ($q) {
                        $q->publishedInAdmin();
                    },
                    'subCategories',
                    'subCategories.pages' => function ($q) {
                        $q->publishedInAdmin();
                    },
                ]
            )->get();

        foreach ($categories as &$category) {
            foreach ($category->subCategories as &$subCategory) {
                foreach ($subCategory->pages as &$page) {
                    if ($page->user) {
                        $page->user->grade = $page->user->getGradeLevel($id);
                    }
                }
            }
        }

        $isPages = Page::publishedInAdmin()->whereHas('category', function ($q) use ($id) {
                $q->where('year_book_id', $id);
            })->count() > 0;

        return ['data' => $categories, 'isPages' => $isPages];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function showV2($id)
    {
        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($id);

        $categories = $yearbook->contentCategories()
            ->root()
            ->where('name', '!=', 'Students Profile')
            ->with(['pages' => function ($q) {
                $q->without(['contents', 'user'])->publishedInAdmin();
            }])
            ->withCount(['pages' => function ($q) {
                $q->publishedInAdmin();
            }])
            ->with(
                [
                    'subCategories' => function ($q) {
                        $q->with(['pages' => function ($q) {
                            $q->without(['contents', 'user'])->publishedInAdmin();
                        }]);
                        $q->withCount(['pages' => function ($q) {
                            $q->publishedInAdmin();
                        }]);
                    },
                ]
            )->get();

//        $isPages = Page::publishedInAdmin()->whereHas('category', function ($q) use ($id) {
//                $q->where('year_book_id', $id);
//            })->count() > 0;
//        $yearbook_pages = Page::publishedInAdmin()->select('pages.id')->whereHas('category', function ($q) use ($id) {
//                $q->where('year_book_id', $id)->where('name', '!=', 'Students Profile')->where('name', '!=', 'Grades');
//            })->without(['contents', 'user'])->get();
//        $page_ids_count = $yearbook_pages->count();
//        $isPages = $page_ids_count > 0;

        return ['data' => $categories];
    }

    public function getPageInfo($page_id)
    {
        $page = Page::without(['user'])->whereId($page_id)->first();

        return ['page' => $page];
    }

    /**
     * Get pages for Category
     *
     * @param $id
     *
     * @return ContentCategory
     */
    public function getPages($id)
    {
        return ContentCategory::whereId($id)
            ->with([
                'pages' => function ($q) {
                    $q->publishedInAdmin();
                },
            ])
            ->get();
    }
}
