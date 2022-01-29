<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Ot;
use App\Komputer;
use App\Dzial;

class OtController extends Controller
{
    public function index(Request $request) {
        $tab = $request->validate([
            'tab' => 'sometimes|in:st,ot,fw,dealer',
        ]);
        $sortable = ['nr_ot', 'nr_inwent', 'data_ot','nazwa_ot', 'id_dz',];
        $order='data_ot';
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
        $otki = DB::table('intranet.ot as ot')
            ->leftJoin('intranet.dzialy as dzialy', 'ot.id_dz', '=', 'dzialy.id_dz')
                ->select('ot.*', 'dzialy.symbol_d')
            ->orderBy($order, $direction)
            ->where([['ot.status_ot', '=', $active],])
            ->get();

        return $otki;
    }
    
    public function show($id, Request $request) {
        $edit = $request->validate([
            'e' => 'sometimes|in:numer,inwent,data,nazwa,dzial,faktura'
            ]);
        $tab = $request->validate([
            'tab' => 'sometimes|in:ot',
            ]);
        $ot = DB::table('intranet.ot as ot')
            ->leftJoin('intranet.dzialy as dzialy', 'ot.id_dz', '=', 'dzialy.id_dz')
            ->leftJoin('intranet.fw as fw', 'ot.id_fw', '=', 'fw.id_fw')
            ->where([['ot.id_ot', '=', $id],])
            ->select('ot.*','dzialy.id_dz','dzialy.symbol_d', 'fw.id_fw', 'fw.nr_fw', 'fw.dok_fw')
            ->first();
        $dzialy = DB::table('intranet.dzialy as dzialy')
            ->get();
        $faktury = DB::table('intranet.fw as fw')
            ->orderBy('nr_fw')
            ->where([['fw.status_fw', '=', '1'],])
            ->get();
        //return $faktura;
        //return $otki;
        return view('ot.show', [
            'ot' => $ot,
            'dzialy' => $dzialy,
            'faktury' => $faktury,
            'tab' => $tab,
            'e' => $edit,
            ]);
    }

    public function updateOneCol($id, Request $request) {
        $validatedData = $request->validate([
            'id_ot' => 'required|numeric|exists:sqlsrv.intranet.ot',
            'nr_ot' => 'sometimes|required|string|max:100',
            'data_ot' => 'sometimes|required|date|before:today',
            'nazwa_ot' => 'sometimes|required|string|max:100',
            'nr_inwent' => 'sometimes|required|numeric|digits:4|unique:sqlsrv.intranet.ot',
            'id_dz' => 'sometimes|required|exists:sqlsrv.intranet.dzialy',
            'id_fw' => 'sometimes|required|exists:sqlsrv.intranet.fw',
            'oldProperty' => 'required|in:nr_ot,data_ot,nazwa_ot,nr_inwent,id_dz,id_fw',
        ]);
        
        $affected = DB::table('intranet.ot')
                ->where('id_ot', $validatedData['id_ot'])
                ->update([$validatedData['oldProperty'] => $validatedData[$validatedData['oldProperty']]]);

        $ot = DB::table('intranet.ot as ot')
            ->leftJoin('intranet.dzialy as dzialy', 'ot.id_dz', '=', 'dzialy.id_dz')
            ->leftJoin('intranet.fw as fw', 'ot.id_fw', '=', 'fw.id_fw')
            ->select('ot.*','dzialy.symbol_d','fw.nr_fw', 'fw.dok_fw')
            ->where([['ot.id_ot', '=', $id],])
            ->first();
        
        $faktury = DB::table('intranet.fw as fw')
            ->orderBy('nr_fw')
            ->where([['fw.status_fw', '=', '1'],])
            ->get();

        return view('ot.show', [
            'ot' => $ot,
            'faktury' => $faktury,
        //        'tab' => $tab,
        //        'e' => $edit,
                ]);
    }    

    public function add() {
        $faktury = DB::table('intranet.fw as fw')
            ->where([['fw.status_fw', '=', '1'],])
            ->get();
        $dzialy = DB::table('intranet.dzialy as dzialy')
            ->where([['dzialy.status_dz', '=', '1'],])
            ->get();
        return view('ot.add', [
            'faktury' => $faktury,
            'dzialy' => $dzialy,
            ]);
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nr_ot' => 'required|string|unique:sqlsrv.intranet.ot|max:100',
            'data_ot' => 'required|date|before:today',
            'nazwa_ot' => 'required|string|max:100',
            'nr_inwent' => 'required|numeric|digits:4|unique:sqlsrv.intranet.ot',
            'id_dz' => 'required|exists:sqlsrv.intranet.dzialy',
            'id_fw' => 'required|exists:sqlsrv.intranet.fw',
            'dok_ot' => 'required|mimes:pdf|between:1,10000'
        ]);
        
        if ($path = $request->file('dok_ot')->store('/ot')) {
        
            $ot = new ot();
            $ot->nr_ot = $validatedData['nr_ot'];
            $ot->data_ot = $validatedData['data_ot'];
            $ot->nazwa_ot = $validatedData['nazwa_ot'];
            $ot->nr_inwent = $validatedData['nr_inwent'];
            $ot->id_dz = $validatedData['id_dz'];
            $ot->id_fw = $validatedData['id_fw'];
            $ot->status_ot = '1';
            $ot->dok_ot = $path;
            
            
            if($ot->save()) {
                $ot = DB::table('intranet.ot as ot')
                    ->leftJoin('intranet.dzialy as dzialy', 'ot.id_dz', '=', 'dzialy.id_dz')
                    ->leftJoin('intranet.fw as fw', 'ot.id_fw', '=', 'fw.id_fw')
                    ->where([['ot.id_ot', '=', $ot->id_ot],])
                    ->select('ot.*','dzialy.id_dz','dzialy.symbol_d', 'fw.id_fw', 'fw.nr_fw', 'fw.dok_fw')
                    ->first();
                return view('ot.show', ['ot' => $ot, 'active'=>'1']);
            }
        }
    }

    public function get($id) {
        $ot = DB::table('intranet.ot as ot')
            ->select('ot.*')
            ->where([
            ['ot.id_ot', '=', $id],
            ])
        ->get()
        ->first();
        return $ot;
    }

    public function downloadOtFile($id) {
        $plik = Ot::findOrFail($id);
        if (Storage::disk('local')->exists($plik->dok_ot)) {
            return Storage::download($plik->dok_ot);
        }
        else {
            return redirect()->back();
        }
    }
}
