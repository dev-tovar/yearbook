<?php

namespace App\Models;

use App\Feed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class EventAttachment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'feed_id', 'original_name', 'size', 'mime', 'path'
    ];

    protected $appends = [
        'full_path'
    ];

    public function getFullPathAttribute() {
        return asset($this->path);
    }

    public function image() {
        return $this->mime === 'image/jpeg' || $this->mime === 'image/png' || $this->mime === 'image/pjpeg';
    }

    public function video() {

    }

    public function uploadAndCreate($files, AlumniEvent $event, $schoolId) {
        File::makeDirectory(public_path('uploads/schools/' . $schoolId . '/events/'), 0775, true, true);
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $extention = $file->getClientOriginalExtension();
            $size = $file->getClientSize();
            $mimeType = $file->getClientMimeType();
            $hashFileName = str_random(50);
            $newFileName = sprintf('%s.%s', $hashFileName, $extention);

            $file->move(public_path('uploads/schools/' . $schoolId . '/events'), $newFileName);

            $event->attachments()->create(
                [
                    'original_name' => $originalName,
                    'path' => 'uploads/schools/' . $schoolId . '/events/' . $newFileName,
                    'size' => $size,
                    'mime' => $mimeType
                ]);
        }
    }
}
