<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdController extends Controller
{
    public static function getAdUserName() {
         $ADremoteUser = explode('\\', $_SERVER['REMOTE_USER'], 50);
         return $ADusername[0];
;    }
}
