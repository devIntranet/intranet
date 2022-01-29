<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use Auth;

use App\Komputer;
use App\Dzial;
use App\Uzytkownik;
use App\Monitor;
use App\Ot;
use App\Fw;

class MonitorController extends Controller
{
    public function index() {
        $sortable = ['inwent_m', 'model_m', 'dns_k', 'symbol_d', 'nazwa_u', 'inwent_k'];
        $order='inwent_m';
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
        if (in_array(request('sort'), $sortable)) {$order = request('sort');}
        if (request('direction') == 'desc') {$direction = request('direction');}
        session(['order'=>$order]);
        session(['direction'=>$direction]); 
        $monitory = DB::table('intranet.monitory as monitory')
            ->leftJoin('intranet.komputery as komputery', 'komputery.id_k', '=', 'monitory.id_k')
            ->leftJoin('intranet.dzialy as dzialy', 'komputery.id_dz', '=', 'dzialy.id_dz')
            ->leftJoin('intranet.uzytkownicy as uzytkownicy', 'komputery.id_u', '=', 'uzytkownicy.id_u')
            ->select('monitory.*', 
                'komputery.id_k as kompIdK', 'komputery.dns_k', 'komputery.inwent_k',
                'dzialy.id_dz', 'dzialy.symbol_d',
                'uzytkownicy.id_u', 'uzytkownicy.nazwa_u', 'uzytkownicy.imie_u', 'uzytkownicy.id_dz AS userIdDz') 
            ->where([['monitory.status_m', '=', $active],])
            ->orderBy($order, $direction)
            ->get();
        return view('monitory.index', ['monitory' => $monitory]);
    }
    public function show($id, Request $request) {
        $edit = $request->validate([
            'e' => 'sometimes|in:inwent,serial,data,model,komp,dzial',
        ]);
        $tab = $request->validate([
            'tab' => 'sometimes|in:st,log',
        ]);
        $active = request('active');
        if ($active == '0') {
            session(['active'=>$active]);
         }
        else {
            $active = '1';
            session(['active'=>$active]);
        }
        $uzytkownicy = Uzytkownik::orderBy('nazwa_u')->get();
        $dzialy = Dzial::orderBy('symbol_d')->get();
        $usedKomps = Monitor::select('id_k')->orderBy('id_k')->get();
        $komputery = DB::table('intranet.komputery as komputery')
           ->leftJoin('intranet.monitory as monitory', 'monitory.id_k', '=', 'komputery.id_k')
           ->select('komputery.id_k', 'komputery.dns_k')
           ->where('monitory.id_m', NULL)
           ->where('komputery.typ_k', 'K')
           ->orderBy('dns_k')->get();
        $otki = Ot::orderBy('nr_ot')->get();
        $faktury = Fw::orderBy('nr_fw')->get();
                 
        $monitor = DB::table('intranet.monitory as monitory')
        ->leftJoin('intranet.komputery as komputery','monitory.id_k', '=', 'komputery.id_k')
        ->leftJoin('intranet.uzytkownicy as uzytkownicy', 'uzytkownicy.id_u', '=', 'komputery.id_u')
        ->leftJoin('intranet.dzialy as dzialy','dzialy.id_dz', '=', 'monitory.id_dz')
        ->leftJoin('intranet.ot as ot','ot.nr_inwent', '=', 'monitory.inwent_m')
        ->leftJoin('intranet.fw as fw','ot.id_fw', '=', 'fw.id_fw')
        ->select('monitory.*', 'uzytkownicy.nazwa_u', 'uzytkownicy.id_dz AS userIdDz', 'uzytkownicy.imie_u', 
           'dzialy.symbol_d', 'komputery.id_dz AS kompIdDz', 'komputery.dns_k',
           'ot.id_ot', 'ot.nr_ot', 'fw.id_fw', 'fw.nr_fw', )
        ->where('monitory.id_m',$id)
        ->get()
        ->first();
         
        if ($tab && $tab['tab'] == 'log') {
            $logiMonitor = DB::table('intranet.historia as historia')
                ->where([
                    ['historia.id_o', '=', $id],
                    ['tabela', '=', 'monitory'],
                ])
                ->orderBy('id_h', 'desc')
                ->paginate(12);
                 
            $logiMonitor->withPath($id.'?tab=log');
            return view('monitory.show', [
                'tab' => $tab, 
                'monitor' => $monitor,
                'logiMonitor' => $logiMonitor,
                ]);
        }
        elseif ($tab && $tab['tab'] == 'st') {
            //$ot = $this->getOtFile($komp->id_ot);
            return view('monitory.show', [
                'tab' => $tab, 
                'monitor' => $monitor,
                'otki' => $otki,
                'faktury' => $faktury,
                'e' => $edit,
                ]);
        }
        else {
            //return $komp;
            return view('monitory.show', [
                'e' => $edit,
                'tab' => $tab, 
                'monitor' => $monitor,
                'dzialy' => $dzialy,
                'komputery' => $komputery,
                ]);
        }
    }
    public function add() {
        $komputery = DB::table('intranet.komputery as komputery')
            ->leftJoin('intranet.monitory as monitory', 'monitory.id_k', '=', 'komputery.id_k')
            ->select('komputery.id_k', 'komputery.dns_k')
            ->where('monitory.id_k', NULL)
            ->where('komputery.typ_k', 'K')
            ->orderBy('dns_k')->get();
        $dzialy = Dzial::orderBy('symbol_d')->get();
        return view('monitory.add', [
            'komputery' => $komputery,
            'dzialy' => $dzialy,
            ]);
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            'model_m' => 'required|unique:sqlsrv.intranet.monitory|max:20',
            'inwent_m' => 'required|numeric|digits:4|unique:sqlsrv.intranet.monitory',
            'serial_m' => 'required|string|unique:sqlsrv.intranet.monitory',
            'data_m' => 'required|date|before:tomorrow',
            'id_k' => 'nullable|numeric|exists:sqlsrv.intranet.komputery,id_k',
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy,id_dz',
        ]);
        
         
         $monitor = new Monitor();
         $monitor->model_m = request('model_m');
         $monitor->inwent_m = request('inwent_m');
         $monitor->serial_m = request('serial_m');
         $monitor->data_m = request('data_m');
         if (request('id_k') == NULL) $monitor->id_k = 0;
         else $monitor->id_k = request('id_k');
         $monitor->id_dz = request('id_dz');
        
         if($monitor->save()) {
            if ($monitor->id_k > 0) $komputer = Komputer::findOrFail($validatedData['id_k']);
            $dzial = Dzial::findOrFail($validatedData['id_dz']);
            
            $wpis = 'Dodano nowy mnitor: [id_m] => '.$monitor->id_m;
            $wpis .= ', [model_m] => '.$monitor->model_m;
            $wpis .= ', [inwent_m] => '.$monitor->inwent_m;
            $wpis .= ', [serial_m] => '.$monitor->serial_m;
            $wpis .= ', [data_m] => '.$monitor->data_m;
            if ($monitor->id_k > 0) $wpis .= ', [id_k] => '.$monitor->id_k.' ( '.$komputer['dns_k'].' )'; 
            $wpis .= ', [id_dz] => '.$monitor->id_dz.' ( '.$dzial['symbol_d'].' )';
            app('App\Http\Controllers\HistoriaController')->store('monitory', $monitor->id_m, $wpis);

            $wpis = 'Do działu [id_dz] => '.$monitor->id_dz;
            $wpis .= ', [symbol_d] => '.$dzial['symbol_d'];
            $wpis .= ' dodano nowy monitor [id_m] => '.$monitor->id_m;
            $wpis .= ', [model_m] => '.$monitor->model_m;
            $wpis .= ', [inwent_m] => '.$monitor->inwent_m;
            $wpis .= ', [serial_m] => '.$monitor->serial_m;
            $wpis .= ', [data_m] => '.$monitor->data_m;
            app('App\Http\Controllers\HistoriaController')->store('dzialy', $monitor->id_dz, $wpis);

            if ($monitor->id_k > 0) {
                $wpis = 'Do kommputera [id_k] =>'.$monitor->id_k;
                $wpis .= ', [dns_k] => '.$komputer['dns_k'];
                $wpis .= ', [inwent_k] => '.$komputer['inwent_k'];
                $wpis .= ', [serial_k] => '.$komputer['serial_k'];
                $wpis .= ' dodano nowy monitor [id_m] => '.$monitor->id_m;
                $wpis .= ', [model_m] => '.$monitor->model_m;
                $wpis .= ', [inwent_m] => '.$monitor->inwent_m;
                $wpis .= ', [serial_m] => '.$monitor->serial_m;
                $wpis .= ', [data_m] => '.$monitor->data_m;
                app('App\Http\Controllers\HistoriaController')->store('komputery', $monitor->id_k, $wpis);        
            }
         }
         //return $saveResult;
         //return $this->index();
         //return $this->show($monitor->id_m, $request);
         //return view('komputery.show', [
         //    'komputer' => $komputer,
         //    ]);
    }
    public function updateOneCol($id, Request $request) {
         //return $request;
         $validatedData = $request->validate([
             'id_m' => 'required|numeric|exists:sqlsrv.intranet.monitory',
             'id_dz' => 'sometimes|nullable|numeric|exists:sqlsrv.intranet.dzialy',
             'old_id_dz' => 'sometimes|nullable|numeric',
             'id_k' => 'sometimes|nullable|numeric|exists:sqlsrv.intranet.komputery',
             'old_id_k' => 'sometimes|nullable|numeric',
             'inwent_m' => 'sometimes|required|numeric|digits:4|unique:sqlsrv.intranet.monitory',
             'old_inwent_m' => 'sometimes|nullable',
             'serial_m' => 'sometimes|required|string|max:50',
             'old_serial_m' => 'sometimes|nullable',
             'model_m' => 'sometimes|required|string|max:50',
             'old_model_m' => 'sometimes|nullable',
             'data_m' => 'sometimes|required|date|before:tomorrow',
             'old_data_m' => 'sometimes|nullable',
             'oldProperty' => 'required|in:model_m,inwent_m,serial_m,data_m,id_dz,id_k'
         ]);
 
         if ($validatedData['oldProperty'] == 'id_ups') {
             
             $log = new Historia();
             $log->tabela = 'komputery';
             $log->id_o = $validatedData['id_k'];
             $ups = UPS::findOrFail($validatedData['id_ups']);
             $KompUPS =  Komputer::findOrFail($validatedData['id_k']);
 
             if (array_key_exists('old_id_ups',$validatedData)) {
                 $oldUPS = UPS::findOrFail($validatedData['old_id_ups']);
                 $affectedOld = DB::table('intranet.upsy')
                     ->where('id_ups', $validatedData['old_id_ups'])
                     ->update(['id_k' => NULL]);
                 
                 $logUPS = new Historia();
                 $logUPS->tabela = 'upsy';
                 $logUPS->id_o = $validatedData['old_id_ups'];
                 $logUPS->wpis = 'UPS '.$oldUPS['model_ups'].', ';
                 $logUPS->wpis .= 'id_ups => '.$oldUPS['id_ups']. ', ';
                 $logUPS->wpis .= 'inwent_ups => '.$oldUPS['inwent_ups']. ', ';
                 $logUPS->wpis .= 'odłączono od komputera '.$KompUPS['dns_k']. ', ';
                 $logUPS->wpis .= 'id_k => '.$KompUPS['id_k']. ', ';
                 $logUPS->wpis .= 'inwent_k => '.$KompUPS['inwent_k']. ', ';
                 $logUPS->kto = Auth::user()->username;
                 $logUPS->save(); 
 
                 if ($validatedData['id_ups'] == $validatedData['old_id_ups']) {    
                     $log->wpis = 'Od komputera o id '.$validatedData['id_k'];
                     $log->wpis .= ' usunięto ups '.$oldUPS['model_ups']. ', ';
                     $log->wpis .= ' inwent_ups => '.$oldUPS['inwent_ups']. ', ';
                     $log->wpis .= ' id_ups => '.$oldUPS['id_ups']. ', ';
    
                 }
                 else {    
                     $affected = DB::table('intranet.upsy')
                     ->where('id_ups', $validatedData['id_ups'])
                     ->update(['id_k' => $validatedData['id_k']]);
 
                     $logNewUPS = new Historia();
                     $logNewUPS->tabela = 'upsy';
                     $logNewUPS->id_o = $validatedData['id_ups'];
                     $logNewUPS->wpis = 'UPS '.$ups['model_ups'].', ';
                     $logNewUPS->wpis .= 'id_ups => '.$ups['id_ups']. ', ';
                     $logNewUPS->wpis .= 'inwent_ups => '.$ups['inwent_ups']. ' ';
                     $logNewUPS->wpis .= 'został dołączony do komputera '.$KompUPS['dns_k']. ', ';
                     $logNewUPS->wpis .= 'id_k => '.$KompUPS['id_k']. ', ';
                     $logNewUPS->wpis .= 'inwent_k => '.$KompUPS['inwent_k']. ', ';
                     $logNewUPS->kto = Auth::user()->username;
                     $logNewUPS->save(); 
                     
                     $log->wpis = 'Zmieniono UPS przy komputerze id '.$validatedData['id_k'];
                     $log->wpis .= ' id_ups: '.$oldUPS['id_ups']. ' => '.$ups['id_ups']. ', ';
                     $log->wpis .= ' inwent_ups: '.$oldUPS['inwent_ups']. ' => '.$ups['inwent_ups']. ', ';
                     $log->wpis .= ' model_ups: '.$oldUPS['model_ups']. ' => '.$ups['model_ups']. ', ';
                 }
             }
            
             else {
                 $affected = DB::table('intranet.upsy')
                     ->where('id_ups', $validatedData['id_ups'])
                     ->update(['id_k' => $validatedData['id_k']]);
 
                     $logNewUPS = new Historia();
                     $logNewUPS->tabela = 'upsy';
                     $logNewUPS->id_o = $validatedData['id_ups'];
                     $logNewUPS->wpis = 'UPS '.$ups['model_ups'].', ';
                     $logNewUPS->wpis .= 'id_ups => '.$ups['id_ups']. ', ';
                     $logNewUPS->wpis .= 'inwent_ups => '.$ups['inwent_ups']. ' ';
                     $logNewUPS->wpis .= 'został dołączony do komputera '.$KompUPS['dns_k']. ', ';
                     $logNewUPS->wpis .= 'id_k => '.$KompUPS['id_k']. ', ';
                     $logNewUPS->wpis .= 'inwent_k => '.$KompUPS['inwent_k']. ', ';
                     $logNewUPS->kto = Auth::user()->username;
                     $logNewUPS->save(); 
 
                     $log->wpis = 'Do komputera o id '.$validatedData['id_k'];
                     $log->wpis .= ' dodano UPS '.$ups['model_ups']. ', ';
                     $log->wpis .= ' inwent_ups => '.$ups['inwent_ups']. ', ';
                     $log->wpis .= ' id_ups => '.$ups['id_ups']. ', ';
                     
             }
             
             $log->kto = Auth::user()->username;
             $log->save(); 
         }
         elseif ($validatedData['oldProperty'] == 'id_m') {
             
             $log = new Historia();
             $log->tabela = 'komputery';
             $log->id_o = $validatedData['id_k'];
             $monitor = Monitor::findOrFail($validatedData['id_m']);
             $KompM =  Komputer::findOrFail($validatedData['id_k']);
 
             if (array_key_exists('old_id_m',$validatedData)) {
                 $oldMonitor = Monitor::findOrFail($validatedData['old_id_m']);
                 $affectedOld = DB::table('intranet.monitory')
                     ->where('id_m', $validatedData['old_id_m'])
                     ->update(['id_k' => NULL]);
                 
                 $logM = new Historia();
                 $logM->tabela = 'monitory';
                 $logM->id_o = $validatedData['old_id_m'];
                 $logM->wpis = 'Monitor '.$oldMonitor['model_m'].', ';
                 $logM->wpis .= 'id_m => '.$oldMonitor['id_m']. ', ';
                 $logM->wpis .= 'inwent_m => '.$oldMonitor['inwent_m']. ', ';
                 $logM->wpis .= 'odłączono od komputera '.$KompM['dns_k']. ', ';
                 $logM->wpis .= 'id_k => '.$KompM['id_k']. ', ';
                 $logM->wpis .= 'inwent_k => '.$KompM['inwent_k']. ', ';
                 $logM->kto = Auth::user()->username;
                 $logM->save(); 
 
                 if ($validatedData['id_m'] == $validatedData['old_id_m']) {    
                     $log->wpis = 'Od komputera o id '.$validatedData['id_k'];
                     $log->wpis .= ' usunięto monitor '.$oldMonitor['model_m']. ', ';
                     $log->wpis .= ' inwent_m => '.$oldMonitor['inwent_m']. ', ';
                     $log->wpis .= ' id_m => '.$oldMonitor['id_m']. ', ';
                 }
                 else {    
                     $affected = DB::table('intranet.monitor')
                     ->where('id_m', $validatedData['id_m'])
                     ->update(['id_k' => $validatedData['id_k']]);
 
                     $logNewM = new Historia();
                     $logNewM->tabela = 'monitory';
                     $logNewM->id_o = $validatedData['id_m'];
                     $logNewM->wpis = 'Monitor '.$monitor['model_m'].', ';
                     $logNewM->wpis .= 'id_m => '.$monitor['id_m']. ', ';
                     $logNewM->wpis .= 'inwent_m => '.$monitor['inwent_m']. ' ';
                     $logNewM->wpis .= 'został dołączony do komputera '.$KompM['dns_k']. ', ';
                     $logNewM->wpis .= 'id_k => '.$KompM['id_k']. ', ';
                     $logNewM->wpis .= 'inwent_k => '.$KompM['inwent_k']. ', ';
                     $logNewM->kto = Auth::user()->username;
                     $logNewM->save(); 
                     
                     $log->wpis = 'Zmieniono monitor przy komputerze id '.$validatedData['id_k'];
                     $log->wpis .= ' id_m: '.$oldMonitor['id_m']. ' => '.$monitor['id_m']. ', ';
                     $log->wpis .= ' inwent_m: '.$oldMonitor['inwent_m']. ' => '.$monitor['inwent_m']. ', ';
                     $log->wpis .= ' model_m: '.$oldMonitor['model_m']. ' => '.$monitor['model_m']. ', ';
                 }
             }
            
             else {
                 $affected = DB::table('intranet.monitory')
                     ->where('id_m', $validatedData['id_m'])
                     ->update(['id_k' => $validatedData['id_k']]);
 
                     $logNewM = new Historia();
                     $logNewM->tabela = 'monitory';
                     $logNewM->id_o = $validatedData['id_m'];
                     $logNewM->wpis = 'Monitor '.$monitor['model_m'].', ';
                     $logNewM->wpis .= 'id_m => '.$monitor['id_m']. ', ';
                     $logNewM->wpis .= 'inwent_m => '.$monitor['inwent_m']. ' ';
                     $logNewM->wpis .= 'został dołączony do komputera '.$KompM['dns_k']. ', ';
                     $logNewM->wpis .= 'id_k => '.$KompM['id_k']. ', ';
                     $logNewM->wpis .= 'inwent_k => '.$KompM['inwent_k']. ', ';
                     $logNewM->kto = Auth::user()->username;
                     $logNewM->save(); 
 
                     $log->wpis = 'Do komputera o id '.$validatedData['id_k'];
                     $log->wpis .= ' dodano monitor '.$monitor['model_m']. ', ';
                     $log->wpis .= ' inwent_m => '.$monitor['inwent_m']. ', ';
                     $log->wpis .= ' id_m => '.$monitor['id_m']. ', ';
                     
             }
             
             $log->kto = Auth::user()->username;
             $log->save(); 
         }
         elseif ($validatedData['oldProperty'] == 'id_u') {
             
             $log = new Historia();
             $log->tabela = 'komputery';
             $log->id_o = $validatedData['id_k'];
             $user = Uzytkownik::findOrFail($validatedData['id_u']);
             $KompUser =  Komputer::findOrFail($validatedData['id_k']);
 
             if (array_key_exists('old_id_u',$validatedData)) {
                 $oldUser = Uzytkownik::findOrFail($validatedData['old_id_u']);
                 $affectedOld = DB::table('intranet.komputery')
                     ->where('id_k', $validatedData['id_k'])
                     ->update(['id_u' => NULL]);
                 
                 $logUser = new Historia();
                 $logUser->tabela = 'uzytkownicy';
                 $logUser->id_o = $validatedData['old_id_u'];
                 $logUser->wpis = 'Użytkownik '.$oldUser['nazwa_u'].' '.$oldUser['imie_u'].', ';
                 $logUser->wpis .= 'id_u => '.$oldUser['id_u']. ', ';
                 $logUser->wpis .= 'został odłączony od komputera '.$KompUser['dns_k']. ', ';
                 $logUser->wpis .= 'id_k => '.$KompUser['id_k']. ', ';
                 $logUser->wpis .= 'inwent_k => '.$KompUser['inwent_k']. ', ';
                 $logUser->kto = Auth::user()->username;
                 $logUser->save(); 
 
                 if ($validatedData['id_u'] == $validatedData['old_id_u']) {    
                     $log->wpis = 'Od komputera o id '.$validatedData['id_k'].', ';
                     $log->wpis .= ' inwent_k => '.$KompUser['inwent_k']. ', ';
                     $log->wpis .= ' dns_k => '.$KompUser['dns_k']. ', ';
                     $log->wpis .= ' odłączono użytkownika '.$oldUser['nazwa_u'].' '.$oldUser['imie_u'].', ';
                     $log->wpis .= ' id_u => '.$oldUser['id_u']. ', ';
                 }
                 else {    
                     $affected = DB::table('intranet.komputery')
                     ->where('id_k', $validatedData['id_k'])
                     ->update(['id_u' => $validatedData['id_u']]);
 
                     $logNewUser = new Historia();
                     $logNewUser->tabela = 'uzytkownicy';
                     $logNewUser->id_o = $validatedData['id_u'];
                     $logNewUser->wpis = 'Użytkownik '.$user['nazwa_u'].' '.$user['imie_u'].', ';
                     $logNewUser->wpis .= 'id_u => '.$user['id_u']. ', ';
                     $logNewUser->wpis .= 'został dołączony do komputera '.$KompUser['dns_k']. ', ';
                     $logNewUser->wpis .= 'id_k => '.$KompUser['id_k']. ', ';
                     $logNewUser->wpis .= 'inwent_k => '.$KompUser['inwent_k']. ', ';
                     $logNewUser->kto = Auth::user()->username;
                     $logNewUser->save(); 
                     
                     $log->wpis = 'Zmieniono użytkownika komputera o id_k '.$validatedData['id_k'];
                     $log->wpis .= ' id_u: '.$oldUser['id_u']. ' => '.$user['id_u']. ', ';
                     $log->wpis .= ' nazwa_u: '.$oldUser['nazwa_u']. ' => '.$user['nazwa_u']. ', ';
                     $log->wpis .= ' imie_u: '.$oldUser['imie_u']. ' => '.$user['imie_u'];
                 }
             }
            
             else {
                 $affected = DB::table('intranet.komputery')
                     ->where('id_k', $validatedData['id_k'])
                     ->update(['id_u' => $validatedData['id_u']]);
 
                     $logNewUser = new Historia();
                     $logNewUser->tabela = 'uzytkownicy';
                     $logNewUser->id_o = $validatedData['id_u'];
                     $logNewUser->wpis = 'Użytkownik '.$user['nazwa_u'].$user['imie_u'].', ';
                     $logNewUser->wpis .= 'id_u => '.$user['id_u']. ' ';
                     $logNewUser->wpis .= 'został dołączony do komputera '.$KompUser['dns_k']. ', ';
                     $logNewUser->wpis .= 'id_k => '.$KompUser['id_k']. ', ';
                     $logNewUser->wpis .= 'inwent_k => '.$KompUser['inwent_k']. ', ';
                     $logNewUser->kto = Auth::user()->username;
                     $logNewUser->save(); 
 
                     $log->wpis = 'Do komputera o id '.$validatedData['id_k'];
                     $log->wpis .= ' dołączono użytkownika '.$user['nazwa_u'].' '.$user['imie_u'].', ';
                     $log->wpis .= ' id_u => '.$user['id_u'];
                 }
             
             $log->kto = Auth::user()->username;
             $log->save(); 
         }
         elseif ($validatedData['oldProperty'] == 'id_dz') {
            $Dzial = Dzial::findOrFail($validatedData['id_dz']);
            $Monitor =  Monitor::findOrFail($validatedData['id_m']);
            if (array_key_exists('old_id_dz',$validatedData)) {
                $oldDzial = Dzial::findOrFail($validatedData['old_id_dz']);
                $affectedOld = DB::table('intranet.monitory')
                    ->where('id_m', $validatedData['id_m'])
                    ->update(['id_dz' => 0]);
                
                $wpis = 'Monitor [model_m] => '.$Monitor->model_m.', [serial_m] => '.$Monitor->serial_m.', [id_m] => '.$Monitor->id_m;
                $wpis .= ' usunięto z działu [symbol_d] => '.$oldDzial->symbol_d.', [id_dz] => '.$oldDzial->id_dz;
                app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $oldDzial->id_dz, $wpis);
            }
            if (!array_key_exists('old_id_dz',$validatedData) || $validatedData['id_dz'] != $validatedData['old_id_dz']) {    
                $affected = DB::table('intranet.monitory')
                    ->where('id_m', $validatedData['id_m'])
                    ->update(['id_dz' => $validatedData['id_dz']]);
                $wpis = 'Monitor [model_m] => '.$Monitor->model_m.', [serial_m] => '.$Monitor->serial_m.', [id_m] => '.$Monitor->id_m.'';
                $wpis .= ' został dodany do działu [sumbol_d] => '.$Dzial->symbol_d.', [id_dz] => '.$Dzial->id_dz;
                app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $Dzial->id_dz, $wpis);
            }
            return $this->show($id, $request);
         }
         elseif ($validatedData['oldProperty'] == 'id_k') {
            $Komp = Komputer::findOrFail($validatedData['id_k']);
            $Monitor =  Monitor::findOrFail($validatedData['id_m']);
            if (array_key_exists('old_id_k',$validatedData)) {
                $oldKomp = Komputer::findOrFail($validatedData['old_id_k']);
                $affectedOld = DB::table('intranet.monitory')
                    ->where('id_m', $validatedData['id_m'])
                    ->update(['id_k' => NULL]);
                
                $wpis = 'Od komputera [dns_k] => '.$oldKomp->dns_k.', [id_k] => '.$id.'';
                $wpis .= ' odłączono monitor [model_m] => '.$Monitor->model_m.'';
                $wpis .= ', [serial_m] => '.$Monitor->serial_m;
                $wpis .= ', [id_m] => '.$Monitor->id_m;
                app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $oldKomp->id_k, $wpis);
            }
            if (!array_key_exists('old_id_k',$validatedData) || $validatedData['id_k'] != $validatedData['old_id_k']) {    
                $affected = DB::table('intranet.monitory')
                    ->where('id_m', $validatedData['id_m'])
                    ->update(['id_k' => $validatedData['id_k']]);
                $wpis = 'Do komputera [dns_k] => '.$Komp->dns_k.', [id_k] => '.$id;
                $wpis .= ' został dołączony monitor [model_m] => '.$Monitor->model_m;
                $wpis .= ', [serial_m] => '.$Monitor->serial_m;
                $wpis .= ', [id_m] => '.$Monitor->id_m;
                app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $Komp->id_k, $wpis);
            }
            return $this->show($id, $request);
        }
        else{
            $Monitor =  Monitor::findOrFail($validatedData['id_m']);
            $affected = DB::table('intranet.monitory')
                ->where('id_m', $validatedData['id_m'])
                ->update([$validatedData['oldProperty'] => $validatedData[$validatedData['oldProperty']]]);
            $wpis = 'Zmieniono ['.$validatedData['oldProperty'].'] monitora [id_m] => '.$Monitor->id_m;
            $wpis .= ' ('.$Monitor[$validatedData['oldProperty']].' =>  '.$validatedData[$validatedData['oldProperty']].')' ;
            app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
            
            return $this->show($id, $request);
         }
         $uzytkownicy = Uzytkownik::orderBy('nazwa_u')->get();
         $monitor = DB::table('intranet.komputery as komputery')
             ->leftJoin('intranet.uzytkownicy as uzytkownicy','uzytkownicy.id_u', '=', 'komputery.id_u')
             ->leftJoin('intranet.dzialy as dzialy','dzialy.id_dz', '=', 'komputery.id_dz')
             ->leftJoin('intranet.monitory as monitory', 'komputery.id_k', '=', 'monitory.id_k')
             ->leftJoin('intranet.upsy as upsy','upsy.id_k', '=', 'komputery.id_k')
             //->select('komputery.*', 'uzytkownicy.id_u', 'uzytkownicy.nazwa_u', 'uzytkownicy.imie_u', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d', 'uzytkownicy.id_dz AS userIdDz')
             ->select('komputery.*', 'uzytkownicy.*', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d', 'uzytkownicy.id_dz AS userIdDz', 'monitory.id_m', 'monitory.model_m', 'upsy.id_ups', 'upsy.model_ups', 'upsy.inwent_ups')
             ->where('komputery.id_k',$id)
             ->get()
             ->first();
         
         return view('komputery.show', [
             'komputer' => $komp,
             'uzytkownicy' => $uzytkownicy,
         ]);
    }
    public function disable($id) {
        
        $this->disconnectDzial($id);
        $this->disconnectKomp($id);
        ### END ODŁACZANIE UŻYTKOWNIKA I DZIAŁU ###
        $monitor = Monitor::findOrFail($id);
        $affected = DB::table('intranet.monitory')
            ->where('id_m', $id)
            ->update(['status_m' => 0,]);
        
        $wpis = 'Monitor [id_m] => '.$monitor->id_m.', [model_m] => '.$monitor->model_m.', [serial_m] => '.$monitor->serial_m;
        $wpis .= ' został oznaczony jako usunięty';
        app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
        return redirect('/monitory?active=0');
    }
    public function activate($id) {
        $monitor = Monitor::findOrFail($id);
        $affected = DB::table('intranet.monitory')
            ->where('id_m', $id)
            ->update(['status_m' => 1]);
        $wpis = 'Monitor [id_m] => '.$monitor->id_m.', [model_m] => '.$monitor->model_m.', [serial_m] => '.$monitor->serial_m;
        $wpis .= ' został ponownie aktywowany.';
        app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
        return redirect('/monitory');
    }
    public function disconnectDzial($id) {
        $monitor = Monitor::findOrFail($id); 
        if ($monitor->id_dz > 0) {
            if ($dzial = Dzial::find($monitor->id_dz)) {
                DB::table('intranet.monitory')
                    ->updateOrInsert(   
                    ['id_m' => $id],
                    ['id_dz' => 0]);
                $wpis = 'Monitor [id_m] => '.$monitor->id_m.', [model_m] => '.$monitor->model_m.', [serial_m] => '.$monitor->serial_m;
                $wpis .= ' został odłączony od działu [id_dz] => '.$dzial->id_dz.', [symbol_d] => '.$dzial->symbol_d;
                app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $dzial->id_dz, $wpis);
            }
        }
    }
    public function disconnectKomp($id) {
        $monitor = Monitor::findOrFail($id); 
        if ($monitor->id_k > 0) {
            if ($komp = Komputer::find($monitor->id_k)) {
                DB::table('intranet.monitory')
                    ->updateOrInsert(   
                    ['id_m' => $id],
                    ['id_k' => 0]);
                $wpis = 'Monitor [id_m] => '.$monitor->id_m.', [model_m] => '.$monitor->model_m.', [serial_m] => '.$monitor->serial_m;
                $wpis .= ' został odłączony od komputera [id_k] => '.$komp->id_k.', [dns_k] => '.$komp->dns_k;
                app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $komp->id_k, $wpis);
            }
        }
    }
    public function destroy($id) {
        $this->disconnectDzial($id);
        $this->disconnectKomp($id);
        $monitor = Monitor::findOrFail($id);
        
        $monitor->delete();
        $wpis = 'Monitor [id_m] => '.$monitor->id_m.', [model_m] => '.$monitor->model_m.', [serial_m] => '.$monitor->serial_m;
                $wpis .= ' został usunięty z bazy danych';
                app('App\Http\Controllers\HistoriaController')->store('monitory', $id, $wpis);
        return redirect('/monitory?active=0');
    }
    
}
