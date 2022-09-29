<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class FeedAttachment extends Model
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
    	if ($this->mime == "image/jpeg" || $this->mime == "image/png" || $this->mime == "image/pjpeg") {
    		return true;
	    }
	    return false;
    }

    public function video() {

    }

    /**
     * @param $files
     * @param Feed $feed
     * @param $schoolId
     */
    public function uploadAndCreate($files, Feed $feed, $schoolId)
    {
        File::makeDirectory(public_path('uploads/schools/' . $schoolId . '/feeds/'), 0775, true, true);

        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $newFileName = sprintf('%s.%s', str_random(50), $file->getClientOriginalExtension());
            $file->move(public_path('uploads/schools/' . $schoolId . '/feeds'), $newFileName);

            $feed->attachments()->create([
                'original_name' => $file->getClientOriginalName(),
                'path' => 'uploads/schools/' . $schoolId . '/feeds/' . $newFileName,
                'size' => $file->getClientSize(),
                'mime' => $file->getClientMimeType()
            ]);
        }
    }
}
