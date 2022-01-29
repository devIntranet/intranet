<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Dealer;
use app\Fw;
use Auth;

class StController extends Controller
{
    public function index(Request $request) {
        $tab = $request->validate([
            'tab' => 'sometimes|in:st,fw,dealer',
        ]);
        
        if ($tab && $tab['tab'] == 'dealer') {
            $dealerzy = app('App\Http\Controllers\DealerController')->index($request);
            return view('st.index',[
                'tab' => $tab,
                'dealerzy' => $dealerzy,
            ]);
        }
        elseif ($tab && $tab['tab'] == 'fw') {
            $fw = app('App\Http\Controllers\FwController')->index($request);
            return view('st.index',[
                'tab' => $tab,
                'faktury' => $fw,
            ]);
        }
        else {
            $otki = app('App\Http\Controllers\OtController')->index($request);
            return view('st.index',[
                'tab' => $tab,
                'otki' => $otki,
                'order' => session('order'),
                'direction' => session('direction'),
            ]);
        }
    }
}

