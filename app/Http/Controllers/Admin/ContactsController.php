<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\ContactsAttachment;
use App\Http\Requests\ContactReplyRequest;
use App\Http\Requests\StoreContactRequest;
use App\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ContactsController extends Controller
{

    public function index(Request $request) {
        if (Gate::allows('super-admin')) {
//            return $this->indexSuperAdmin($request->id);
            return $this->list();
        }
        else {
            return $this->indexAdmin();
        }
    }

    public function indexAdmin() {
        $school = Auth::user()->user->school;
        return view('admin.contacts.form', [
            'school' => $school
        ]);
    }

    public function indexSuperAdmin($schoolId) {
        try {
            $school = School::findOrFail($schoolId);
            return view('admin.contacts.form', [
                'school' => $school
            ]);
        }
        catch (\Exception $exception) {
            Log::error($exception);
            return response($exception->getMessage(), 404);
        }
    }

    public function store(StoreContactRequest $request) {
        $data = $request->all();
        $data['isAdmin'] = true;
        $file = $request->file('image');
        $contact = Contact::store(Auth::user(), $data);
        $contactAttachment = new ContactsAttachment();
        $contactAttachment->uploadAndCreate($file, $contact, Auth::user()->user->school->id, Auth::user()->user->id);

        return redirect()
            ->action('Admin\ContactsController@index')
            ->with('success-message', 'Your message was successfully sent');
    }

    public function list() {
        $messages = Contact::paginate(50);

        return view('admin.contacts.index', [
            'messages' => $messages
        ]);
    }

    public function show($id) {
        return view('admin.contacts.view', [
            'message' => Contact::find($id)
        ]);
    }

    public function destroy($id) {
        Contact::find($id)->delete();

        return redirect()->action('Admin\ContactsController@index')->with('success-message', 'Message successfully deleted');
    }

    public function reply(ContactReplyRequest $request) {
        $data = $request->validated();
        if (Contact::reply($data['id'], $data['message'])) {
            return redirect()->action('Admin\ContactsController@index')->with('success-message', 'reply was successfully sent to e-mail');
        }
        else {
            return redirect()->action('Admin\ContactsController@index')->with('error-message', 'there are some errors with sending your reply');
        }
    }
}
