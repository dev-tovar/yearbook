<?php
/**
 * Created by PhpStorm.
 * User: tabbakka
 * Date: 7/18/18
 * Time: 11:42 AM
 */

namespace App\Http\Controllers\Admin\MediaManage;


use App\Helpers\PhotoProfileHandler;
use App\Services\Image\ImageDelete;
use App\Services\Image\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use ctf0\MediaManager\Events\MediaFileOpsNotifications;
use Exception;
use Pbmedia\LaravelFFMpeg\FFMpegFacade;
use Pbmedia\LaravelFFMpeg\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaLoader extends \ctf0\MediaManager\Controllers\MediaController
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

    protected function getRandomString()
    {
        return Str::random();
    }

    public function getFiles(Request $request)
    {
        $schoolId = Auth::guard('admin')->user()->user->school->id;
        $folder = $request->folder != '/' ? $request->folder : '';
        $folder = "/schools/$schoolId" . $folder;

        if ($folder && !$this->storageDisk->exists($folder)) {
            return response()->json([
                'error' => trans('MediaManager::messages.error_doesnt_exist',
                    ['attr' => $folder]),
            ]);
        }

        return response()->json([
            'locked' => [],//$this->db->pluck('path'),
            'dirs' => $this->getDirectoriesList("/schools/$schoolId"),
            'files' => [
                'path' => $folder,
                'items' => $this->getData($folder)
            ],
        ]);
    }

    public function editVideo(Request $request)
    {
        $storage = config('mediaManager.storage_disk');
        try {
//            dd(Storage::disk($storage)->path());
//            $url = str_replace(Storage::disk($storage)->url('storage'), '', $request->url);
//            $url = str_replace(Storage::disk($storage)->url('/'), '', $request->url);
            $url = parse_url($request->url)['path'];

//            dd($url);

            $name = $request->name;
            $time = rand(1000, 9999);

            $newUrl = str_replace($name, "{$time}_{$name}", $url);
//            $file = Storage::disk($storage)->url('app/public' . $url);
//            $newFile = Storage::disk($storage)->url('app/public' . $newUrl);
            $file = Storage::disk($storage)->url($url);
            $newFile = Storage::disk($storage)->url($newUrl);

            $videoFile = FFMpegFacade::fromDisk($storage)
                ->open($file);

            $timeMark = intval($request->data['cover']);

            $videoFile->getFrameFromSeconds($timeMark)
                ->export()
                ->toDisk($storage)
                ->save('cover_video/' . $newUrl . '.png');
            $this->addWatermark('cover_video/'
                . $newUrl . '.png');


            $start = intval($request->data['start']);
            $end = intval($request->data['end']);


            $command
                = "ffmpeg -ss $start -i \"$file\" -f mp4 -vcodec libx264 -c copy -t $end \"$newFile\"";

            Log::info("----- " . $command);
            exec($command);

            return ['success' => true, 'message' => "{$time}_{$name} added!"];
        } catch (Exception $exception) {
            return ['success' => false, 'message' => $exception->getMessage()];
        }


    }

    /**
     * get files list.
     *
     * @param mixed $dir
     */
    protected function getData($dir)
    {
        $list = [];
        $dirList = $this->getFolderContent($dir);
        $storageFiles = $this->getFolderListByType($dirList, 'file');
        $storageFolders = $this->getFolderListByType($dirList, 'dir');
        $pattern = $this->ignoreFiles;

        foreach ($storageFolders as $folder) {
            $path = $folder['path'];
            $time = 0; //$folder['timestamp'];

            if (!preg_grep($pattern, [$path])) {
                if ($this->GFI) {
                    $info = $this->getFolderInfo($path);
                }

                $list[] = [
                    'name' => $folder['basename'],
                    'type' => 'folder',
                    'path' => $this->resolveUrl($path),
                    'size' => isset($info) ? $info['size']
                        : 0,
                    'count' => isset($info) ? $info['count']
                        : 0,
                    'last_modified' => $time,
                    'last_modified_formated' => $this->getItemTime($time),
                ];
            }
        }

        foreach ($storageFiles as $file) {
            $path = $file['path'];
            $time = $file['timestamp'];

           // if (!preg_grep($pattern, [$path])) {
                if (in_array($file['mimetype'], self::$videoMimeTypes)) {
                    $list[] = [
                        'name' => $file['basename'],
                        'type' => 'video/mp4',
                        'path' => $this->resolveUrl($path),
                        'cover' => $this->resolveUrl('cover_video/'
                            . $path . '.png'),
                        'size' => $file['size'],
                        //'visibility' => $file['visibility'],
                        'last_modified' => $time,
                        'last_modified_formated' => $this->getItemTime($time),
                    ];
                } else {
                    $list[] = [
                        'name' => $file['basename'],
                        'type' => $file['mimetype'],
                        'path' => $this->resolveUrl($path),
                        'size' => $file['size'],
                        //'visibility' => $file['visibility'],
                        'last_modified' => $time,
                        'last_modified_formated' => $this->getItemTime($time),
                    ];
                }

            //}
        }

        return $list;
    }

    private function addWatermark($path)
    {
        $storage = config('mediaManager.storage_disk');
        $watermark = Image::make(public_path('images/play-large.png'));
//        $watermark = Image::make(Storage::disk($storage)->get('app/public/images/play-large.png'));
//        $img = Image::make(Storage::disk($storage)->get('app/public/' . $path));
        $img = Image::make(Storage::disk($storage)->get($path));
        $watermarkSize = $img->width() / 2;
        $watermark->resize($watermarkSize, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->insert($watermark, 'center');
//        $img->save();

        $basename = last(explode('/', $path));
        $img->save(storage_path('app/public/' . $basename));
        $img = Storage::disk('public')->get($basename);
        Storage::disk($storage)->put($path, $img);
        Storage::disk('public')->delete($basename);
    }

    public function moveItem(Request $request)
    {
        $schoolId = Auth::guard('admin')->user()->user->school->id;
        $path = $request->path;
        $copy = $request->use_copy;
        $result = [];
        $broadcast = true;
        $toBroadCast = [];

        foreach ($request->moved_files as $one) {
            $file_name = $one['name'];
            $new_file_name = $one['new_name'];
            $file_type = $one['type'];
            $defaults = [
                'name' => $new_file_name,
                'type' => $file_type,
                'size' => $one['size'],
                'items' => $one['items'] ?? 0,
            ];

            $destination = "{$request->destination}/$new_file_name";
            $old_path = !$path ? $file_name
                : $this->clearDblSlash("$path/$file_name");
            $new_path = "/schools/$schoolId" . $destination;

            $pattern = [
                '/[[:alnum:]]+\/\.\.\/\//' => '',
                '/\/\//' => '/',
            ];
            $new_path = preg_replace(array_keys($pattern),
                array_values($pattern), $new_path);

            try {
                if (!file_exists($new_path)) {
                    // copy
                    if ($copy) {
                        // folders
                        if ($file_type == 'folder') {
                            $old = $this->getItemPath($old_path);
                            $new = $this->getItemPath($new_path);

                            if (app('files')->copyDirectory($old, $new)) {
                                $result[] = array_merge($defaults,
                                    ['success' => true]);
                            } else {
                                $exc = array_get($this->storageDiskInfo, 'root')
                                    ? trans('MediaManager::messages.error_moving')
                                    : trans('MediaManager::messages.error_moving_cloud');

                                throw new Exception($exc);
                            }
                        } // files
                        else {
                            if ($this->storageDisk->copy($old_path,
                                $new_path)
                            ) {
                                $result[] = array_merge($defaults,
                                    ['success' => true]);
                            } else {
                                throw new Exception(
                                    trans('MediaManager::messages.error_moving')
                                );
                            }
                        }
                    } // move
                    else {
                        if ($this->storageDisk->move($old_path, $new_path)) {
                            $result[] = array_merge($defaults,
                                ['success' => true]);

                            $toBroadCast[] = $defaults;

                            // fire event
                            event('MMFileMoved', [
                                'old_path' => $this->getItemPath($old_path),
                                'new_path' => $this->getItemPath($new_path),
                            ]);
                        } else {
                            $exc = trans('MediaManager::messages.error_moving');

                            if ($file_type == 'folder'
                                && !array_get($this->storageDiskInfo, 'root')
                            ) {
                                $exc
                                    = trans('MediaManager::messages.error_moving_cloud');
                            }

                            throw new Exception($exc);
                        }
                    }
                } else {
                    throw new Exception(
                        trans('MediaManager::messages.error_already_exists')
                    );
                }
                ImageResize::makeS3($new_path)->resize();
                ImageDelete::make($this->getItemPath($old_path))->delete();
            } catch (Exception $e) {
                Log::error($e);
                $broadcast = false;
                $result[] = [
                    'success' => false,
                    'message' => "\"$old_path\" " . $e->getMessage(),
                ];
            }
        }

        // broadcast
        if ($broadcast) {
            broadcast(new MediaFileOpsNotifications([
                'op' => 'move',
                'items' => $toBroadCast,
                'path' => [
                    'current' => $path,
                    'old' => pathinfo($old_path, PATHINFO_DIRNAME),
                    'new' => pathinfo($new_path, PATHINFO_DIRNAME),
                ],
            ]))->toOthers();
        }

        return response()->json($result);
    }

    protected function getDirectoriesList($location)
    {
        if (is_array($location)) {
            $location = rtrim(implode('/', $location), '/');
        }

        $dirs = $this->storageDisk->allDirectories($location);

        return str_replace(trim($location, '/'), '', $dirs);
    }

    public function deleteItem(Request $request)
    {
        $path = $request->path;
        $result = [];
        $toBroadCast = [];

        foreach ($request->deleted_files as $one) {

            $name = $one['name'];
            $type = $one['type'];
            $item_path = !$path ? $name : $this->clearDblSlash("$path/$name");
            $defaults = [
                'name' => $name,
                'type' => $type,
            ];

            // folder
            if ($type == 'folder') {
                if ($this->storageDisk->deleteDirectory($item_path)) {
                    $result[] = array_merge($defaults, ['success' => true]);

                    $toBroadCast[] = array_merge($defaults, [
                        'path' => $item_path,
                        'url' => null,
                    ]);

                    // fire event
                    event('MMFileDeleted', [
                        'file_path' => $this->getItemPath($item_path),
                        'is_folder' => true,
                    ]);
                } else {
                    $result[] = array_merge($defaults, [
                        'success' => false,
                        'message' => trans('MediaManager::messages.error_deleting_file'),
                    ]);
                }
            } // file
            else {
                if ($this->storageDisk->delete($item_path)) {
                    $result[] = array_merge($defaults, [
                        'success' => true,
                        'url' => $this->resolveUrl($item_path),
                    ]);

                    $toBroadCast[] = array_merge($defaults, [
                        'path' => $path,
                        'url' => $this->resolveUrl($item_path),
                    ]);

                    // fire event
                    PhotoProfileHandler::onDeleteStudentAvatr([
                        'file_name' => $name,
                        'destination' => $item_path,
                    ]);
                    event('MMFileDeleted', [
                        'file_path' => $this->getItemPath($item_path),
                        'is_folder' => false,
                    ]);
                } else {
                    $result[] = [
                        'success' => false,
                        'name' => $item_path,
                        'type' => $type,
                        'message' => trans('MediaManager::messages.error_deleting_file'),
                    ];
                }
            }
        }

        // broadcast
        broadcast(new MediaFileOpsNotifications([
            'op' => 'delete',
            'items' => $toBroadCast,
        ]))->toOthers();

        return response()->json($result);
    }

    protected function optimizeUpload(UploadedFile $file)
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

    public function upload(Request $request)
    {
        $upload_path = $request->upload_path;
        $random_name = $request->random_names;
        $result = [];
        $broadcast = false;
        $storage = config('mediaManager.storage_disk');

        foreach ($request->file as $one) {
            if ($this->allowUpload($one)) {
                $one = $this->optimizeUpload($one);

                $original = $one->getClientOriginalName();
                $name_only = pathinfo($original, PATHINFO_FILENAME);
                $ext_only = pathinfo($original, PATHINFO_EXTENSION);
                if (in_array($one->getMimeType(), self::$videoMimeTypes)) {
                    $ext_only = 'mp4';
                }
                $file_name = $random_name
                    ? $this->sanitizedText . ".$ext_only"
                    : $this->cleanName($name_only, null) . ".$ext_only";

                $file_type = $one->getMimeType();
                $destination = !$upload_path ? $file_name
                    : $this->clearDblSlash("$upload_path/$file_name");

//                Log::error('Upload Destination: ' . $destination);
//                Log::error('Upload File ext: ' . $ext_only);

                try {
                    // check for mime type
                    if (str_contains($file_type, $this->unallowedMimes)) {
                        throw new Exception(
                            trans('MediaManager::messages.not_allowed_file_ext',
                                ['attr' => $file_type])
                        );
                    }

                    // check existence
                    if ($this->storageDisk->exists($destination)) {
                        throw new Exception(
                            trans('MediaManager::messages.error_already_exists')
                        );
                    }

                    // save file
                    $saved_name = $this->storeFile($one, $upload_path,
                        $file_name);

                    // fire event
                    event('MMFileUploaded', $this->getItemPath($saved_name));

                    if (in_array($one->getMimeType(), static::$videoMimeTypes)) {
                        /** @var Media $videoFile */
                        $videoFile = FFMpegFacade::fromDisk($storage)
                            ->open($destination);

                        $timeMark = (int)($videoFile->getDurationInSeconds() / 2);

                        $videoFile->getFrameFromSeconds($timeMark)
                            ->export()
                            ->toDisk($storage)
                            ->save('cover_video/' . $destination . '.png');
                        $this->addWatermark('cover_video/'
                            . $destination . '.png');
                    } else {
                        event('MMFileSaved', $this->getItemPath($saved_name));

                        PhotoProfileHandler::onUploadStundentAvatar([
                            'destination' => $destination,
                            'file_name' => $file_name,
                        ]);
                    }

                    $broadcast = true;

                    $result[] = [
                        'success' => true,
                        'file_name' => $file_name,
                    ];
                } catch (Exception $e) {
                    Log::error($e);
                    $result[] = [
                        'success' => false,
                        'message' => "\"$file_name\" " . $e->getMessage(),
                    ];
                }
            } else {
                $result[] = [
                    'success' => false,
                    'message' => trans('MediaManager::messages.error_cant_upload'),
                ];
            }
        }

        // broadcast
        if ($broadcast) {
            broadcast(new MediaFileOpsNotifications([
                'op' => 'upload',
                'path' => $upload_path,
            ]))->toOthers();
        }

        return response()->json($result);
    }
}
