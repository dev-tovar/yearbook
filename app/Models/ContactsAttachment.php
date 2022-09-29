<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ContactsAttachment extends Model
{
    protected $fillable = [
        'contact_id', 'file_path'
    ];

    protected $appends = [
        'full_path'
    ];

    public function getFullPathAttribute() {
        return asset($this->file_path);
    }

    public function uploadAndCreate($files, Contact $contact, $schoolId, $userId) {
        try {
            File::makeDirectory(public_path('uploads/contacts/schools/' . $schoolId . '/users/' . $userId . '/feeds/'), 0775, true, true);
            if (!is_null($files)) {
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $originalName = $file->getClientOriginalName();
                        $extention = $file->getClientOriginalExtension();
                        $size = $file->getClientSize();
                        $mimeType = $file->getClientMimeType();
                        $hashFileName = str_random(50);
                        $newFileName = sprintf('%s.%s', $hashFileName, $extention);

                        $file->move(public_path('uploads/contacts/schools/' . $schoolId . '/users/' . $userId . '/feeds'), $newFileName);

                        $contact->attachments()->create(
                            [
                                'contact_id' => $contact->id,
                                'file_path' => 'uploads/contacts/schools/' . $schoolId . '/users/' . $userId . '/feeds/' . $newFileName,
                            ]);
                    }
                } else {
                    $file = $files;
                    $originalName = $file->getClientOriginalName();
                    $extention = $file->getClientOriginalExtension();
                    $size = $file->getClientSize();
                    $mimeType = $file->getClientMimeType();
                    $hashFileName = str_random(50);
                    $newFileName = sprintf('%s.%s', $hashFileName, $extention);

                    $file->move(public_path('uploads/contacts/schools/' . $schoolId . '/users/' . $userId . '/feeds'), $newFileName);

                    $contact->attachments()->create(
                        [
                            'contact_id' => $contact->id,
                            'file_path' => 'uploads/contacts/schools/' . $schoolId . '/users/' . $userId . '/feeds/' . $newFileName,
                        ]);
                }
            }
        }
        catch (\Exception $e) {
            Log::error($e);
            return response($e->getMessage(), 500);
        }
    }
}
