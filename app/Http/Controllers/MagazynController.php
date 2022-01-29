<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Magazyn;

class MagazynController extends Controller
{
    public function index(Request $request) {
        $magazyny = DB::table('Tychy1.dbo.MS_MAGAZ as magazyny')
            ->select('magazyny.MAGAZYN', 'magazyny.TYP', 'magazyny.NAZWA')
            ->get();
        dd($magazyny);
    }
    public static function getMagazyny() {
        return DB::table('Tychy1.dbo.MS_MAGAZ as magazyny')
            ->select('magazyny.MAGAZYN', 'magazyny.TYP', 'magazyny.NAZWA')
            ->get();
    }
}
