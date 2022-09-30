<?php
/**
 * Created by PhpStorm.
 * User: tabbakka
 * Date: 7/10/18
 * Time: 6:43 PM
 */

namespace App\Helpers;


class ApiResponseGenerator
{

    public static function blocked() {
        return response('User blocked', '403');
    }

    public static function responseTrue($data) {
        return response()->json([
            'ok' => true,
            'data' => $data,
            'error' => null
        ]);
    }

    public static function responseFail($error) {
        return response([
            'ok' => false,
            'data' => null,
            'error' => $error
        ], $error['code']);
    }

}