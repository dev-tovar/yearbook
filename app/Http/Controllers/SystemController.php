<?php

namespace App\Http\Controllers;

class SystemController extends Controller
{
    public function updateServer(){
        exec("git pull");
        exec("composer install");
        exec("php artisan migrate");
        echo "done";die();
    }
}
