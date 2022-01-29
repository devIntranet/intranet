<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Fw;


class FwController extends Controller
{
    public function index(Request $request) {
        $tab = $request->validate([
            'tab' => 'sometimes|in:st,fw,fw',
        ]);
        $sortable = ['nr_fw', 'data_fw', 'id_dea', 'info_fw'];
        $order='data_fw';
        $direction = 'desc';
        $active = request('active');
        if (in_array(request('sort'), $sortable)) {$order = request('sort');}
        if ($active == '0') {
            session(['active'=>$active]);
            }
        else {
            $active = '1';
            session(['active'=>$active]);
            }
        if (request('direction') == 'asc') {$direction = request('direction');}
        session(['order'=>$order]);
        session(['direction'=>$direction]); 
        $fw = DB::table('intranet.fw as fw')
            ->leftJoin('intranet.dealerzy as dealerzy', 'fw.id_dea', '=', 'dealerzy.id_dea')
            ->select('fw.*','dealerzy.nazwa_dea')
            ->orderBy($order, $direction)
            ->where([['fw.status_fw', '=', $active],])
            ->get();

        return $fw;
    }
    
    public function show($id, Request $request) {
        $edit = $request->validate([
            'e' => 'sometimes|in:numer,data,dealer,opis'
            ]);
        $tab = $request->validate([
            'tab' => 'sometimes|in:ot',
            ]);
        $faktura = DB::table('intranet.fw as fw')
            ->leftJoin('intranet.dealerzy as dealerzy','fw.id_dea', '=', 'dealerzy.id_dea')
            ->select('fw.*', 'dealerzy.id_dea', 'dealerzy.nazwa_dea')
            ->where([['fw.id_fw', '=', $id],])
            ->first();
        $otki = DB::table('intranet.ot as ot')
            ->leftJoin('intranet.fw as fw','fw.id_fw', '=', 'ot.id_fw')
            ->leftJoin('intranet.dzialy as dzialy','ot.id_dz', '=', 'dzialy.id_dz')
            ->where([['ot.id_fw', '=', $id],])
            ->get();
        $dealerzy = DB::table('intranet.dealerzy as dealerzy')
            ->where([['dealerzy.status_dea', '=', '1'],])
            ->get();
        //return $faktura;
        //return $otki;
        return view('fw.show', [
            'fw' => $faktura,
            'otki' => $otki,
            'dealerzy' => $dealerzy,
            'tab' => $tab,
            'e' => $edit,
            ]);
    }

    public function updateOneCol($id, Request $request) {
        $validatedData = $request->validate([
            'id_fw' => 'required|numeric|exists:sqlsrv.intranet.fw',
            'nr_fw' => 'sometimes|required|string|max:100',
            'info_fw' => 'sometimes|required|string|max:100',
            'data_fw' => 'sometimes|required|string|max:20',
            'id_dea' => 'sometimes|required|numeric|exists:sqlsrv.intranet.dealerzy',
            'oldProperty' => 'required|in:nr_fw,data_fw,id_dea,info_fw',
        ]);
        
        $affected = DB::table('intranet.fw')
                ->where('id_fw', $validatedData['id_fw'])
                ->update([$validatedData['oldProperty'] => $validatedData[$validatedData['oldProperty']]]);

        $faktura = DB::table('intranet.fw as fw')
            ->leftJoin('intranet.dealerzy as dealerzy', 'fw.id_dea', '=', 'dealerzy.id_dea')
            ->select('fw.*','dealerzy.id_dea','dealerzy.nazwa_dea')
            ->where([['fw.id_fw', '=', $id],])
            ->first();
        return view('fw.show', [
                'fw' => $faktura,
        //        'otki' => $otki,
        //        'tab' => $tab,
        //        'e' => $edit,
                ]);
    }
    
    public function downloadFwFile($id) {
        $plik = Fw::findOrFail($id);
        if (Storage::disk('local')->exists($plik->dok_fw)) {
            return Storage::download($plik->dok_fw);
        }
        else {
            return redirect()->back();
        }
    }
    
    public function add() {
        $dealerzy = DB::table('intranet.dealerzy as dealerzy')
            ->where([['dealerzy.status_dea', '=', '1'],])
            ->get();
        return view('fw.add', ['dealerzy' => $dealerzy]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'nr_fw' => 'required|unique:sqlsrv.intranet.fw|max:20',
            'info_fw' => 'required|string|max:100',
            'data_fw' => 'required|date|before:tomorrow',
            'id_dea' => 'required|exists:sqlsrv.intranet.dealerzy',
            'dok_fw' => 'required|mimes:pdf|between:1,10000'
        ]);
        
        if ($path = $request->file('dok_fw')->store('/fw')) {
        
            $fw = new fw();
            $fw->nr_fw = $validatedData['nr_fw'];
            $fw->info_fw = $validatedData['info_fw'];
            $fw->data_fw = $validatedData['data_fw'];
            $fw->id_dea = $validatedData['id_dea'];
            $fw->status_fw = '1';
            $fw->dok_fw = $path;
            
            if($fw->save()) {
                return view('fw.show', ['fw' => $fw, 'active'=>'1']);
            }
        }
    }
}
