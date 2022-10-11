<?php
/**
 * Created by PhpStorm.
 * User: tabbakka
 * Date: 7/19/18
 * Time: 2:35 PM
 */

namespace App\Helpers;


use App\RekognitionStack;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PhotoProfileHandler
{

    public static function onUploadStundentAvatar($data)
    {
        /**@var \App\School $school */
        $school = Auth::guard('admin')->user()->getSchool();

        $uuid = explode('.', $data['file_name'])[0];


        $reg    = '/^\/schools\/\d+\/[\d]{4}-[\d]{4}\/profiles\/[\d]+.*/';
        $string = $data['destination'];

        Log::info('destination: '.$string);

        if (preg_match($reg, $string, $matches)) {
            $regBook = '/[\d]{4}-[\d]{4}/';

            preg_match($regBook, $string, $matches);

            $bookYear = explode('-', $matches[0]);

            /** @var \App\YearBook $yearBook */
            $yearBook = $school->yearbooks()->where([
                'year_from' => $bookYear[0],
                'year_to'   => $bookYear[1],
            ])->first();
            if ($yearBook) {
                $yearBook->yearbook_users()->where('id', $uuid)->update([
//                    'avatar' => asset('storage'.$data['destination']),
//                    'avatar' => 'https://pocketyearbook.s3.amazonaws.com' . $data['destination'],
                    'avatar' => Storage::disk('s3')->url(ltrim($data['destination'],'/')),
                ]);
            } else {
                Log::info('no yearBook');
            }
        } else {

            $regBook = '/[\d]{4}-[\d]{4}/';
            preg_match($regBook, $string, $matches);
            if (count($matches) == 0) {
                return true;
            }
            $bookYear = explode('-', $matches[0]);
            /** @var \App\YearBook $yearBook */
            $yearBook = $school->yearbooks()->where([
                'year_from' => $bookYear[0],
                'year_to'   => $bookYear[1],
            ])->first();
            if ($yearBook) {
                $users = $yearBook->yearbook_users()->whereNotNull('avatar')
                    ->get();
                foreach ($users as $user) {
                    RekognitionStack::create([
                        'source'             => storage_path('app/public'
                            .str_replace(asset('storage'), '', $user->avatar)),
                        'target'             => storage_path('app/public'
                            .$data['destination']),
                        'users_year_book_id' => $user->id,
                    ]);
                }
            }
        }

        return true;
    }

    public static function onDeleteStudentAvatr($data)
    {
        /**@var \App\School $school */
        $school = Auth::guard('admin')->user()->getSchool();

        $uuid = explode('.', $data['file_name'])[0];


        $reg    = '/^\/schools\/\d+\/[\d]{4}-[\d]{4}\/profiles\/[\d]+.*/';
        $string = $data['destination'];

        if (preg_match($reg, $string, $matches)) {
            $regBook = '/[\d]{4}-[\d]{4}/';

            preg_match($regBook, $string, $matches);

            $bookYear = explode('-', $matches[0]);

            /** @var \App\YearBook $yearBook */
            $yearBook = $school->yearbooks()->where([
                'year_from' => $bookYear[0],
                'year_to'   => $bookYear[1],
            ])->first();
            if ($yearBook) {
                $yearBook->yearbook_users()->where('id', $uuid)->update([
                    'avatar' => null,
                ]);
            }
        }

        return true;
    }
}
