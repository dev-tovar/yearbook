<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\ContactsAttachment;
use App\Helpers\ApiResponseGenerator;
use App\Http\Requests\ContactStoreRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactsController extends Controller
{
    //
    public function store(ContactStoreRequest $request)
    {
        /** @var User $user */
        if ( ! $user = JWTAuth::parseToken()->authenticate()) {
            return ApiResponseGenerator::responseFail([
                'message' => 'User not found',
                'code'    => 404,
            ]);
        }
        if ($user->blocked()) {
            return ApiResponseGenerator::blocked();
        }
        $data = $request->validated();
        try {
            $yearbook = $user->yearbook()->first();
            if($yearbook){
                $schoolId = $yearbook->school_id;
            }else{
                $schoolId = null;
            }
            $contact = Contact::create([
                'school_id' => $schoolId,
                'user_id'   => $user->id,
                'subject'   => $data['reason'],
                'message'   => $data['message'],
                'isAdmin'   => false,
            ]);

            $files             = $request->file('image', []);
            $contactAttachment = new ContactsAttachment();
            $contactAttachment->uploadAndCreate($files, $contact,
                $schoolId, Auth::user()->id);

            $contact = Contact::find($contact->id);

            switch ($user->user_type) {
                case 'student':
                    $this->studentContact($user, $data, $contact);
                    break;
                case 'parent':
                    $this->parentContact($user, $data, $contact);;
                    break;
            }

            return ApiResponseGenerator::responseTrue(null);
        } catch (\Exception $e) {
            Log::error($e);

            return ApiResponseGenerator::responseFail([
                'message' => $e->getMessage(),
                'code'    => 500,
            ]);
        }
    }

    private function parentContact($user, $data, $contact)
    {
        Mail::send('mail.contact.parent',
            ['user' => $user, 'data' => $data, 'contact' => $contact],
            function ($m) use ($user) {
                $m->to('stayconnected@pocketyearbook.com')
                    ->subject('YearBook Contact Us App form Parent');
            });
    }

    private function studentContact($user, $data, $contact)
    {
        Mail::send('mail.contact.student',
            ['user' => $user, 'data' => $data, 'contact' => $contact],
            function ($m) use ($user) {
                $m->to('stayconnected@pocketyearbook.com')
                    ->subject('YearBook Contact Us App form Student');
            });
    }
}
