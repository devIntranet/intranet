<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Dealer;

class DealerController extends Controller
{
    public function index(Request $request) {
        $tab = $request->validate([
            'tab' => 'sometimes|in:st,fw,dealer',
        ]);
        $sortable = ['nazwa_dea', 'nip_dea', 'miasto_dea',];
       $order='nazwa_dea';
       $direction = 'asc';
       $active = request('active');
       if (in_array(request('sort'), $sortable)) {$order = request('sort');}
       if ($active == '0') {
           session(['active'=>$active]);
        }
       else {
           $active = '1';
           session(['active'=>$active]);
        }
       if (request('direction') == 'desc') {$direction = request('direction');}
       session(['order'=>$order]);
       session(['direction'=>$direction]); 
       $dealerzy = DB::table('intranet.dealerzy as dealerzy')
            ->select('dealerzy.*')
        ->orderBy($order, $direction)
        ->where([['dealerzy.status_dea', '=', $active],])
        ->get();
       return $dealerzy;
    }
    
    public function show($id, Request $request) {
        $edit = $request->validate([
            'e' => 'sometimes|in:nazwa,nip,miasto,ulica,lokal'
            ]);
        $tab = $request->validate([
            'tab' => 'sometimes|in:faktury',
            ]);
        //$dealer = Dealer::find($id);
        $faktury = DB::table('intranet.fw as fw')
            ->where([['fw.id_dea', '=', $id],])
            ->get();
        $dealer = DB::table('intranet.dealerzy as dealerzy')
            ->select('dealerzy.*')
            ->where([['dealerzy.id_dea', '=', $id],])
            ->first();
        
        return view('dealerzy.show', [
            'faktury' => $faktury,
            'dealer' => $dealer,
            'tab' => $tab,
            'e' => $edit,
            ]);
    }

    public function add() {
        return view('dealerzy.add');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'nazwa_dea' => 'required|unique:sqlsrv.intranet.dealerzy|max:100',
            'NIP_dea' => 'required|unique:sqlsrv.intranet.dealerzy|max:20',
            'miasto_dea' => 'required|string|max:50',
            'ulica_dea' => 'required|string|max:50',
            'lokal_dea' => 'required|string|max:20',
        ]);
        
        $dealer = new Dealer();
        $dealer->nazwa_dea = $validatedData['nazwa_dea'];
        $dealer->NIP_dea = $validatedData['NIP_dea'];
        $dealer->miasto_dea = $validatedData['miasto_dea'];
        $dealer->ulica_dea = $validatedData['ulica_dea'];
        $dealer->lokal_dea = $validatedData['lokal_dea'];
        
        if($dealer->save()) {
            return view('dealerzy.show', ['dealer' => $dealer]);
        }
    }

    public function disable($id) {
        $dealer = Dealer::findOrFail($id);
        $affected = DB::table('intranet.dealerzy')
              ->where('id_dea', $id)
              ->update(['status_dea' => 0]);
        
        return redirect('/st?tab=dealer&active=0');;
    }

    public function activate($id) {
        $dealer = Dealer::findOrFail($id);
        $affected = DB::table('intranet.dealerzy')
              ->where('id_dea', $id)
              ->update(['status_dea' => 1]);
        
        return redirect('/st?tab=dealer&active=1');;
    }

    public function updateOneCol($id, Request $request) {
        $validatedData = $request->validate([
            'id_dea' => 'required|numeric|exists:sqlsrv.intranet.dealerzy',
            'nazwa_dea' => 'sometimes|required|string|max:100',
            'NIP_dea' => 'sometimes|required|string|max:20',
            'miasto_dea' => 'sometimes|required|string|max:30',
            'ulica_dea' => 'sometimes|required|string|max:50',
            'lokal_dea' => 'sometimes|required|string|max:10',
            'oldProperty' => 'required|in:nazwa_dea,NIP_dea,miasto_dea,ulica_dea,lokal_dea',
        ]);
        
        $affected = DB::table('intranet.dealerzy')
                ->where('id_dea', $validatedData['id_dea'])
                ->update([$validatedData['oldProperty'] => $validatedData[$validatedData['oldProperty']]]);

        $dealer = DB::table('intranet.dealerzy as dealerzy')
                ->select('dealerzy.*')
                ->where([['dealerzy.id_dea', '=', $id],])
                ->first();
        
        return view('dealerzy.show', [
            'dealer' => $dealer,
        ]);
        
        
    }
}
