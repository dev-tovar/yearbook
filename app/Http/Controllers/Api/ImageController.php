<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TributeFileUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Pbmedia\LaravelFFMpeg\FFMpegFacade;
use Pbmedia\LaravelFFMpeg\Media;

class ImageController extends Controller
{
    private static $videoMimeTypes
        = [
            'video/x-flv',
            'video/mp4',
            'application/x-mpegURL',
            'video/MP2T',
            'video/3gpp',
            'video/quicktime',
            'video/x-msvideo',
            'video/x-ms-wmv',
        ];

    private static $storage;

    public function __construct()
    {
        self::$storage = config('mediaManager.storage_disk');
    }

    public function store(Request $request)
    {
        $image = $request->file('file');
        $image = self::saveImage($image);

        return ['data' => $image];
    }

    public function feeds(Request $request)
    {
        $files = $request->file('files') ?? [];
        $res = [];
        foreach ($files as $file) {
            $res[] = self::saveImage($file);
        }

        return $res;
    }

    public static function saveImage(UploadedFile $file)
    {
        if (in_array($file->getMimeType(), static::$videoMimeTypes)) {
            $file = self::optimizeUpload($file);
        }
        $storage = self::$storage;
        $path = 'uploads/' . time();
        $destination = Storage::disk($storage)->putFileAs($path, $file, $file->getClientOriginalName());

        $originalName = $file->getClientOriginalName();
        $size = $file->getSize();

        if (in_array($file->getMimeType(), static::$videoMimeTypes)) {
            /** @var Media $videoFile */
            $videoFile = FFMpegFacade::fromDisk($storage)
                ->open($destination);

            $timeMark = (int)($videoFile->getDurationInSeconds() / 2);

            $videoFile->getFrameFromSeconds($timeMark)
                ->export()
                ->toDisk($storage)
                ->save('cover_video/' . $destination . '.png');
            static::addWatermark('cover_video/'
                . $destination . '.png');
            event('MMFileSaved', 'cover_video/' . $destination . '.png');
            return [
                'path'          => static::getUrl('cover_video/'
                    . $destination . '.png'),
                'src'           => static::getUrl($destination),
                'original_name' => $originalName,
                'size'          => $size,
                'mime'          => $file->getMimeType(),
            ];
        }

        event('MMFileSaved', $destination);
        return [
            'path'          => static::getUrl($destination),
            'src'           => static::getUrl($destination),
            'original_name' => $originalName,
            'size'          => $size,
            'mime'          => $file->getMimeType(),
        ];

    }

    private static function getUrl($path)
    {
        if (self::$storage === 's3') {
            $result = Storage::disk(self::$storage)->url($path);
        } else {
            $baseUrl = url('storage');
            $result = "{$baseUrl}/{$path}";
        }

        return $result;
    }


    private static function addWatermark($path)
    {
        $watermark = Image::make(public_path('images/play-large.png'));
        $img = Image::make(Storage::disk(self::$storage)->get($path));
        $watermarkSize = $img->width() / 2;
        $watermark->resize($watermarkSize, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->insert($watermark, 'center');
        $basename = last(explode('/', $path));
        $img->save(storage_path('app/tmp/' . $basename));
        $img = Storage::disk('local')->get('tmp/' . $basename);
        Storage::disk(self::$storage)->put($path, $img);
        Storage::disk('local')->delete('tmp/' . $basename);
    }

    protected static function optimizeUpload(UploadedFile $file)
    {
        //SplFileInfo
        /** @var \SplFileInfo $info */
        $info = $file->getFileInfo();
        $command
            = "ffmpeg  -i \"{$info->getRealPath()}\" -f mp4 -vcodec libx264 -c copy \"{$info->getRealPath()}\"";

        Log::info("----- " . $command);
        exec($command);
        return $file;
    }

    public function storeBin(TributeFileUploadRequest $request)
    {
        $type = $request->type === 'image' ? '.jpg' : '.mp4';
        $file = base64_decode($request->image);
        $file_name = str_random(10) . $type;

        $path = 'uploads/' . time();

        if ($request->type === 'video') {
            Storage::disk('local')->put('tmp/' . $file_name, $file);
            $tmp_file = storage_path('tmp/' . $file_name);
            $command = "ffmpeg  -i \"{$tmp_file}\" -f mp4 -vcodec libx264 -c copy \"{$tmp_file}\"";
            exec($command);
            $file = Storage::disk('local')->get('tmp/' . $file_name);
            Storage::disk('local')->delete('tmp/' . $file_name);
        }

        Storage::disk(self::$storage)->put($path . '/' . $file_name, $file);
        $url = Storage::disk(self::$storage)->url($path . '/' . $file_name);
        event('MMFileSaved', $path . '/' . $file_name);

        return [
            'path'          => $url,
            'src'           => $url,
            'original_name' => $file_name,
            'type'          => $request->type,
        ];
    }
}
