<?php

namespace App\Http\Controllers\Api;

use App\Events\YearbookNotificationEvent;
use App\Http\Requests\BuyStudentTributeRequest;
use App\Models\ContentCategory;
use App\Models\Page;
use App\Models\Template;
use App\Services\InAppPurchase;
use App\Http\Controllers\Controller;
use App\User;
use App\YearBook;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StudentTributeController extends Controller
{
    public function my($yearbookId, $studentId)
    {
        if ( ! $this->canMy($studentId)) {
            throw new AuthorizationException();
        }
        $pages = Page::with('category')->where('user_id', $studentId)
            ->whereHas('category', function ($q) use ($yearbookId) {
                $q->where('year_book_id', $yearbookId);
                $q->whereHas('parentCategory', function ($qq) {
                    $qq->where('name', 'Student Tribute');
                });
            })->get();

        return $pages;
    }

    public function categories($yearbookId, $studentId)
    {
        $categories = ContentCategory::where('year_book_id', $yearbookId)
            ->whereHas('parentCategory', function ($qq) {
                $qq->where('name', 'Student Tribute');
            })->get();

        foreach ($categories as &$category) {
            $category->templates = Template::where('category_name',
                "Student Tribute {$category->name}")->with('fields')->get();
        }

        return $categories;
    }

    public function buy(BuyStudentTributeRequest $request)
    {
        $data = $request->all();

        if ($receiptBase64Data = $request->receipt_data) {
            if ( ! InAppPurchase::verifyITunes($receiptBase64Data)) {
                return response()->json([
                    'error' => [
                        'payment' => 'Payment Information is Wrong (receipt_data)',
                    ],
                ], 422);
            }
        } elseif ($purchaseToken = $request->purchase_token) {
            if ( ! InAppPurchase::verifyPlayStore($purchaseToken)) {
                return response()->json([
                    'error' => [
                        'payment' => 'Payment Information is Wrong (purchase_token)',
                    ],
                ], 422);
            }
        } else {
            return response()->json([
                'error' => [
                    'payment' => 'Payment Information is Wrong',
                ],
            ], 422);
        }

        /** @var Page $page */
        $page = Page::create([
            'template_id' => $data['template_id'],
            'category_id' => $data['category_id'],
            'user_id'     => $data['user_id'],
            'is_publish'  => false,
        ]);

        foreach ($page->template->fields as $field) {
            $page->contents()->create([
                'field_id' => $field->id,
                'value'    => $data[$field->name],
            ]);
        }

        $message = "Your parent created a Student tribute page for you";
        $type    = "parent_student_tribute";
        $user    = User::find($data['user_id']);
        /** @var User $fromUser */
        $fromUser = Auth::user();
        /** @var YearBook $yearbook */
        $yearbook = YearBook::find($request->yearbook_id);
        event(new YearbookNotificationEvent($message, $type, $user,
            $fromUser, $yearbook));

        $students = $yearbook->users()->where('users.id', '!=', $data['user_id'])
            ->get();

        try{
            $name = Auth::user()->name;
            $school = $yearbook->school->name;
            Mail::send('mail.pay.tribute',
                ['name' => $name, 'school' => $school],
                function ($m) {
                    $m->to('stayconnected@pocketyearbook.com')
                        ->subject('User In-App Purchase');
                });
        }catch (\Exception $ex){

        }


        $type = "some_student_tribute";
        foreach ($students as $student) {
            $message = "A Student tribute was created for {$user->name}";
            event(new YearbookNotificationEvent($message, $type, $student,
                $user, $yearbook));
        }

        return ['status' => true];
    }

    private function canMy($studentId)
    {
        return Auth::user()->user_type == 'parent'
            && Auth::user()->childes()->find($studentId) != null;
    }

    /**
     * @deprecated
     * @param $yearbookId
     * @param $studentId
     *
     * @return bool
     */
    private function canCategories($yearbookId, $studentId)
    {
        $countPages = Page::where('user_id', $studentId)
            ->whereHas('category', function ($q) use ($yearbookId) {
                $q->where('year_book_id', $yearbookId);
                $q->whereHas('parentCategory', function ($qq) {
                    $qq->where('name', 'Student Tribute');
                });
            })->count();

        return $this->canMy($studentId) && $countPages == 0;
    }

    /**
     * @deprecated
     * @param $yearbookId
     * @param $studentId
     *
     * @return bool
     */
    private function canBuy($yearbookId, $studentId)
    {
        return $this->canCategories($yearbookId, $studentId);
    }
}
