<?php
/**
 * Created by PhpStorm.
 * User: tabbakka
 * Date: 7/17/18
 * Time: 2:36 PM
 */

namespace App\Helpers;


use Illuminate\Support\Facades\Auth;

class MediaRoutes
{

    public static function routes()
    {
        $controller = array_get(config('mediaManager'), 'controller',
            'Admin\MediaManage\MediaController');

        app('router')->group([
            'middleware' => 'auth:admin'
        ], function () use($controller) {
            app('router')->group([
                'prefix'    => 'media',
                'as'        => 'media.',
            ], function () use ($controller) {

                app('router')->get('/', ['uses' => "$controller@index", 'as' => 'index']);
                app('router')->post('upload', ['uses' => "$controller@upload", 'as' => 'upload']);
                app('router')->post('upload-cropped', ['uses' => "$controller@uploadEditedImage", 'as' => 'uploadCropped']);
                app('router')->post('upload-link', ['uses' => "$controller@uploadLink", 'as' => 'uploadLink']);

                app('router')->post('files', ['uses' => "$controller@getFiles", 'as' => 'files']);
                app('router')->post('directories', ['uses' => "$controller@getFolders", 'as' => 'directories']);
                app('router')->post('new-folder', ['uses' => "$controller@createNewFolder", 'as' => 'new_folder']);
                app('router')->post('delete-file', ['uses' => "$controller@deleteItem", 'as' => 'delete_file']);
                app('router')->post('move-file', ['uses' => "$controller@moveItem", 'as' => 'move_file']);
                app('router')->post('rename-file', ['uses' => "$controller@renameItem", 'as' => 'rename_file']);
                app('router')->post('change-vis', ['uses' => "$controller@changeItemVisibility", 'as' => 'change_vis']);
                app('router')->post('lock-file', ['uses' => "$controller@lockItem", 'as' => 'lock_file']);

                app('router')->get('global-search', ['uses' => "$controller@globalSearch", 'as' => 'global_search']);

                app('router')->post('folder-download', ['uses' => "$controller@downloadFolder", 'as' => 'folder_download']);
                app('router')->post('files-download', ['uses' => "$controller@downloadFiles", 'as' => 'files_download']);
            });
        });
    }

}