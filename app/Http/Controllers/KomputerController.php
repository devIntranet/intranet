<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use App\Komputer;
use App\Dzial;
use App\Uzytkownik;
use App\Program;
use App\Instalacja;
use App\Urzadzenie;
use App\Monitor;
use App\UPS;
use App\Ot;
use App\Fw;
use App\Historia;
use Auth;

class KomputerController extends Controller
{
    private function getUsersToAdd() {
        return DB::table('intranet.uzytkownicy as uzytkownicy')
            ->leftJoin('intranet.komputery as komputery', 'komputery.id_u', '=', 'uzytkownicy.id_u')
            ->orderBy('nazwa_u', 'asc')
            ->select('nazwa_u','imie_u', 'uzytkownicy.id_u')
            ->where('uzytkownicy.status_u', '=', '1')
            ->whereNull('id_k')
            //->toSQL();
            ->get();
            
    }
    public function index() {
       //$komputery = Komputer::all();
       //$komputery = Komputer::where('dns_k', 'like', '%test%')->orderBy('data_k', 'asc')->get();
       //$user = $_SERVER['AUTH_USER'];
    
       $sortable = ['dns_k', 'nazwa_u', 'symbol_d', 'ip_k', 'typ_k', 'inwent_k'];
       $order='dns_k';
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
       $komputery = DB::table('intranet.komputery as k')
        ->leftJoin('intranet.uzytkownicy as u', 'k.id_u', '=', 'u.id_u')
        ->leftJoin('intranet.dzialy as d', 'k.id_dz', '=', 'd.id_dz')
        ->leftJoin('intranet.monitory as m', 'k.id_k', '=', 'm.id_k')
        ->leftJoin('intranet.upsy as ups', 'k.id_k', '=', 'ups.id_k')
        ->select('k.*',
                'u.id_u AS userIdU', 'u.nazwa_u', 'u.imie_u', 'u.id_dz AS userIdDz',
                'd.id_dz AS dzialIdDz', 'd.symbol_d',
                'm.id_m', 'm.inwent_m',
                'ups.id_ups', 'ups.inwent_ups')
        ->orderBy($order, $direction)
        ->where([['k.status_k', '=', $active],])
        ->get();
       return view('komputery.index', ['komps' => $komputery]);
    }
    public function show($id, Request $request) {
        $edit = $request->validate([
            'e' => 'sometimes|in:dns,inwent,serial,ip,proc,ram,hdd,user,dzial,
                    typ,model,os,soft,dev,data,monitor,ups,ot,fw',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|in:soft,dev,st,log',
        ]);
        $uzytkownicy = DB::table('intranet.uzytkownicy as u')
            ->leftJoin('intranet.komputery as k', 'k.id_u', '=', 'u.id_u')
            ->select('u.*')
            ->orderBy('u.nazwa_u')
            ->where('k.id_k', '=', NULL)
            ->get();
        $dzialy = Dzial::orderBy('symbol_d')->get();
        $monitory = Monitor::orderBy('inwent_m')
            ->where([
                ['id_k', '=', Null],
                ])
            ->orWhere('id_k', '=', '0')
            ->get();
        $upsy = UPS::orderBy('inwent_ups')->where([['id_k', '=', 0]],)
            ->orWhere([['id_k', '=', NULL],],)->get();
        $otki = Ot::orderBy('nr_ot')->get();
        $faktury = Fw::orderBy('nr_fw')->get();
        
        $soft = DB::table('intranet.komputery as k')
        ->orderBy('p.nazwa_p', 'asc')
        ->leftJoin('intranet.instalacje as i','k.id_k', '=', 'i.id_k')
        ->leftJoin('intranet.programy as p','i.id_p', '=', 'p.id_p')
        ->select('k.*', 'p.nazwa_p', 'p.id_p', 
                'p.licqty_p', 'p.lic_p', 'p.typ_p', 'i.id_i')
        ->where([
            ['k.id_k', '=', $id],
            ['p.typ_p', '<>', '1']
            ])
        ->get();

        $softToAdd=DB::table('intranet.programy as p')
        ->orderBy('nazwa_p', 'asc')
        ->select('nazwa_p','id_p', 'typ_p')
        ->where('typ_p', '<>', '1')
        ->whereNotIn('id_p', function($subQuery) use ($id) {
            $subQuery->select('id_p')->from('intranet.instalacje as i')->where([
                ['id_k', '=', $id],
            ]);
        })->get();
        
        $OS = DB::table('intranet.komputery as k')
        ->leftJoin('intranet.instalacje as i','k.id_k', '=', 'i.id_k')
        ->leftJoin('intranet.programy as p','i.id_p', '=', 'p.id_p')
        ->select('k.*', 'p.id_p', 
                'p.nazwa_p', 'p.licqty_p', 
                'p.lic_p', 'p.typ_p', 'i.id_i')
        ->where([
            ['k.id_k', '=', $id],
            ['p.typ_p', '=', '1']
            ])
        ->get()
        ->first();
        
        $OSy = DB::table('intranet.programy')->where('typ_p', '=', '1')->get();
        //return $OSy;
                
        $komp = DB::table('intranet.komputery as k')
        ->leftJoin('intranet.uzytkownicy as u','u.id_u', '=', 'k.id_u')
        ->leftJoin('intranet.monitory as m', 'k.id_k', '=', 'm.id_k')
        ->leftJoin('intranet.upsy as ups','ups.id_k', '=', 'k.id_k')
        ->leftJoin('intranet.dzialy as d','d.id_dz', '=', 'k.id_dz')
        ->leftJoin('intranet.ot as ot','ot.nr_inwent', '=', 'k.inwent_k')
        ->leftJoin('intranet.fw as fw','ot.id_fw', '=', 'fw.id_fw')
        ->select('k.*', 
                'u.id_u', 'u.nazwa_u', 'u.imie_u', 'u.id_dz AS userIdDz',
                'm.id_m', 'm.model_m', 'm.inwent_m',
                'ups.id_ups', 'ups.model_ups', 'ups.inwent_ups',
                'd.id_dz', 'd.nazwa_d', 'd.symbol_d',
                'ot.id_ot', 'ot.nr_ot', 'ot.data_ot', 'ot.dok_ot',
                'fw.id_fw', 'fw.nr_fw', 'fw.data_fw', 'fw.dok_fw',)
        ->where('k.id_k',$id)
        ->get()
        ->first();
        if ($tab && $tab['tab'] == 'soft') {
            return view('komputery.show', [
                'e' => $edit,
                'tab' => $tab, 
                'komputer' => $komp,
                'uzytkownicy' => $uzytkownicy,
                'soft' => $soft,
                'os' => $OS,
                'osy' => $OSy,
                'softToAdd' => $softToAdd,
            ]);
        }
        elseif ($tab && $tab['tab'] == 'dev') {
            $urzadzeniaKomp = DB::table('intranet.urzadzenia')
                ->where([
                    ['id_k', '=', $id],
                ])
            ->get();
            //return $urzadzeniaKomp;
            $urzadzenia = DB::table('intranet.urzadzenia')
                ->whereNull('id_k')
            ->get();
            //return $urzadzenia;
            return view('komputery.show', [
                'e' => $edit,
                'tab' => $tab, 
                'komputer' => $komp,
                'urzadzenia' => $urzadzenia,
                'urzadzeniaKomp' => $urzadzeniaKomp,
                ]);
        }
        elseif ($tab && $tab['tab'] == 'st') {
            $ot = $this->getOtFile($komp->id_ot);
            return view('komputery.show', [
                'tab' => $tab, 
                'komputer' => $komp,
                'otki' => $otki,
                'faktury' => $faktury,
                'e' => $edit,
                ]);
        }
        elseif ($tab && $tab['tab'] == 'log') {
            $logiKomp = DB::table('intranet.historia as historia')
                ->where([
                    ['historia.id_o', '=', $id],
                    ['tabela', '=', 'komputery'],
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(12);
                //->get();
            $logiKomp->withPath($id.'?tab=log');
            return view('komputery.show', [
                'tab' => $tab, 
                'komputer' => $komp,
                'logiKomp' => $logiKomp,
                ]);
        }

        else {
            //return $komp;
            return view('komputery.show', [
                'e' => $edit,
                'tab' => $tab, 
                'komputer' => $komp,
                'uzytkownicy' => $uzytkownicy,
                'dzialy' => $dzialy,
                'monitory' => $monitory,
                'upsy' => $upsy,
                ]);
        }
    }
    public function addStep1() {
        $uzytkownicy = $this->getUsersToAdd(); #Uzytkownik::all();
        //return $uzytkownicy;
        $dzialy = Dzial::all();
         return view('komputery.add', [
             'uzytkownicy' => $uzytkownicy,
             'dzialy' => $dzialy,
             ]);
    }
    public function addStep2(Request $request) {
        $step1 = $request->validate([
            'dns_k' => 'required|unique:sqlsrv.intranet.komputery|max:15',
            //'typ_k' => 'required|alpha|in:K,N,S',
            'inwent_k' => 'required|numeric|digits:4|unique:sqlsrv.intranet.komputery',
            'serial_k' => 'required|string|max:50|unique:sqlsrv.intranet.komputery',
            'data_k' => 'required|date|before:tomorrow',
            'id_u' => 'nullable|numeric|exists:sqlsrv.intranet.uzytkownicy,id_u',
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy,id_dz'
            ]);
        $request->session()->flash('kompStep1', $step1); 
        return view('komputery.addStep2', [
            'step1' => $step1
        ]);
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            'dns_k' => 'required|unique:sqlsrv.intranet.komputery|max:15',
            'ip_k' => 'required|unique:sqlsrv.intranet.komputery|ipv4',
            'typ_k' => 'required|alpha|in:K,N,S',
            'model_k' => 'required|string|max:50',
            'inwent_k' => 'required|numeric|digits:4|unique:sqlsrv.intranet.komputery',
            'serial_k' => 'required|string|max:50|unique:sqlsrv.intranet.komputery',
            'data_k' => 'required|date|before:tomorrow',
            'id_u' => 'nullable|numeric|exists:sqlsrv.intranet.uzytkownicy,id_u',
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy,id_dz',
            'proc_k' => 'required|string|max:50',
            'ram_k' => 'required|numeric|max:256',
            'hdd_k' => 'required|numeric|max:5000',
        ]);
        
        $komputer = new Komputer();
        $komputer->dns_k = request('dns_k');
        $komputer->typ_k = request('typ_k');
        $komputer->model_k = request('model_k');
        $komputer->ip_k = request('ip_k');
        $komputer->data_k = request('data_k');
        $komputer->inwent_k = request('inwent_k');
        $komputer->serial_k = request('serial_k');
        if (request('id_u') != NULL) $komputer->id_u = request('id_u');
        else $komputer->id_u = 0;
        $komputer->id_dz = request('id_dz');
        $komputer->proc_k = request('proc_k');
        $komputer->ram_k = request('ram_k');
        $komputer->hdd_k = request('hdd_k');

        if($komputer->save()) {
            if ($komputer->id_u > 0) $user = Uzytkownik::findOrFail($validatedData['id_u']);
            $dzial = Dzial::findOrFail($validatedData['id_dz']);
            $wpis = 'Dodano nowy komputer [id_k] => '.$komputer->id_k;
            $wpis .= ', [dns_k] => '.$komputer->dns_k;
            $wpis .= ', [typ_k] => '.$komputer->typ_k;
            $wpis .= ', [model_k] => '.$komputer->model_k;
            $wpis .= ', [inwent_k] => '.$komputer->inwent_k;
            $wpis .= ', [serial_k] => '.$komputer->serial_k;
            $wpis .= ', [data_k] => '.$komputer->data_k;
            $wpis .= ', [ip_k] => '.$komputer->ip_k;
            $wpis .= ', [proc_k] => '.$komputer->proc_k;
            $wpis .= ', [ram_k] => '.$komputer->ram_k;
            $wpis .= ', [hdd_k] => '.$komputer->hdd_k;
            if ($komputer->id_u > 0) $wpis .= ', [id_u] => '.$komputer->id_u.' ('.$user['nazwa_u'].' '.$user['imie_u'].')'; 
            $wpis .= ', [id_dz] => '.$komputer->id_dz.' ('.$dzial['symbol_d'].')';
            app('App\Http\Controllers\HistoriaController')->store('komputery', $komputer->id_k, $wpis);

            $wpis = 'Do działu [id_dz] => '.$komputer->id_dz;
            $wpis .= ', [symbol_d] => '.$dzial['symbol_d'];
            $wpis .= ' dodano nowy komputer: ';
            $wpis .= ' [id_k] => '.$komputer->id_k;
            $wpis .= ', [typ_k] => '.$komputer->typ_k;
            $wpis .= ', [model_k] => '.$komputer->model_k;
            $wpis .= ', [inwent_k] => '.$komputer->inwent_k;
            $wpis .= ', [serial_k] => '.$komputer->serial_k;
            $wpis .= ', [data_k] => '.$komputer->data_k;
            $wpis .= ', [ip_k] => '.$komputer->ip_k;
            $wpis .= ', [proc_k] => '.$komputer->proc_k;
            $wpis .= ', [ram_k] => '.$komputer->ram_k;
            $wpis .= ', [hdd_k] => '.$komputer->hdd_k;
            if ($komputer->id_u > 0) $wpis .= ', [id_u] => '.$komputer->id_u.' ( '.$user['nazwa_u'].' '.$user['imie_u'].' )'; 
            $wpis .= ', [id_dz] => '.$komputer->id_dz.' ( '.$dzial['symbol_d'].' )';
            app('App\Http\Controllers\HistoriaController')->store('dzialy', $komputer->id_dz, $wpis);
        
            if ($komputer->id_u > 0) {
                $wpis = 'Użytkownikowi [id_u] => '.$komputer->id_u;
                $wpis .= '( '.$user['nazwa_u'].' '.$user['imie_u'].' )';
                $wpis .= ', [symbol_d] => '.$dzial['symbol_d'];
                $wpis .= ' przydzielono nowy komputer: ';
                $wpis .= ' [id_k] => '.$komputer->id_k;
                $wpis .= ', [typ_k] => '.$komputer->typ_k;
                $wpis .= ', [model_k] => '.$komputer->model_k;
                $wpis .= ', [inwent_k] => '.$komputer->inwent_k;
                $wpis .= ', [serial_k] => '.$komputer->serial_k;
                $wpis .= ', [data_k] => '.$komputer->data_k;
                $wpis .= ', [ip_k] => '.$komputer->ip_k;
                $wpis .= ', [proc_k] => '.$komputer->proc_k;
                $wpis .= ', [ram_k] => '.$komputer->ram_k;
                $wpis .= ', [hdd_k] => '.$komputer->hdd_k;
                $wpis .= ', [id_u] => '.$komputer->id_u.' ( '.$user['nazwa_u'].' '.$user['imie_u'].' )'; 
                $wpis .= ', [id_dz] => '.$komputer->id_dz.' ( '.$dzial['symbol_d'].' )';
                app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $komputer->id_u, $wpis);
            }
        }
        //return $komputer;
        //return $saveResult;
        return $this->show($komputer->id_k, $request);
        //return view('komputery.show', [
        //    'komputer' => $komputer,
        //    ]);
    }
    public function storeOtFile($id, Request $request) {
        $req = $request;
        if ($validatedData = $request->validate([
            'otfile' => 'required|mimes:pdf|between:1,10000',
            'typ' => 'required||alpha|in:ot,fw',
        ])) {
            //return $validatedData;
            $path = $validatedData['otfile']->store($validatedData['typ']);
            $uzytkownicy = Uzytkownik::orderBy('nazwa_u')->get();
            $komp = DB::table('intranet.komputery as komputery')
            ->leftJoin('intranet.uzytkownicy as uzytkownicy','uzytkownicy.id_u', '=', 'komputery.id_u')
            ->leftJoin('intranet.dzialy as dzialy','dzialy.id_dz', '=', 'komputery.id_dz')
            ->leftJoin('intranet.monitory as monitory', 'komputery.id_k', '=', 'monitory.id_k')
            ->leftJoin('intranet.upsy as upsy','upsy.id_k', '=', 'komputery.id_k')
            //->select('komputery.*', 'uzytkownicy.id_u', 'uzytkownicy.nazwa_u', 'uzytkownicy.imie_u', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d', 'uzytkownicy.id_dz AS userIdDz')
            ->select('komputery.*', 'uzytkownicy.*', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d', 'uzytkownicy.id_dz AS userIdDz', 'monitory.id_m', 'monitory.model_m', 'upsy.id_ups', 'upsy.model_ups', 'upsy.inwent_ups')
            ->where('komputery.id_k',$id)
            ->get()
            ->first();
            app('App\Http\Controllers\OtController')->store($Ot);
            return $this->show($id, $request);
            //return view('komputery.show', [
            //'komputer' => $komp,
            //'uzytkownicy' => $uzytkownicy,
            //'tab' => 'dev',
            //]);
        }
    }
    public function storeOtFileGET($id, Request $request) {
        $stArray = [
            'id_k' => $id, 
            'tab' => 'st',
        ];
        $request = new Request($stArray);
        return $this->show($id, $request);
    }
    public function getOtFile($id) {
        $ot = app('App\Http\Controllers\OtController')->get($id);
        return $ot;
    }
    public function downloadOtFile($id) {
        $plik = Ot::findOrFail($id);
        return Storage::download($plik->dok_ot,);
        //return Storage::disk('local')->get($plik->dok_ot);
        //return response()->file($plik->dok_ot);
    }
    public function downloadFtFile($id) {
        $plik = Ft::findOrFail($id);
        return Storage::download($plik->dok_ft,);
        //return Storage::disk('local')->get($plik->dok_ot);
        //return response()->file($plik->dok_ot);
    }
    public function editStep1($id) {
        $uzytkownicy = Uzytkownik::all();
        $dzialy = Dzial::all();
        $komp = DB::table('intranet.komputery as komputery')
        ->leftJoin('intranet.uzytkownicy as uzytkownicy','uzytkownicy.id_u', '=', 'komputery.id_u')
        ->leftJoin('intranet.dzialy as dzialy','dzialy.id_dz', '=', 'uzytkownicy.id_dz')
        ->select('komputery.*', 'uzytkownicy.*', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d')
        ->where('komputery.id_k',$id)
        ->get()
        ->first();

         return view('komputery.editStep1', [
             'uzytkownicy' => $uzytkownicy,
             'dzialy' => $dzialy,
             'komputer' => $komp,
             ]);
    }
    public function editStep2($id, Request $request) {
        $step1 = $request->validate([
            'dns_k' => 'required|max:15|unique:sqlsrv.intranet.komputery,dns_k,'.$id.',id_k',
            'ip_k' => 'nullable|ipv4|unique:sqlsrv.intranet.komputery,ip_k,'.$id.',id_k',
            'proc_k' => 'nullable|string|max:50',
            'ram_k' => 'nullable|numeric|max:256',
            'hdd_k' => 'nullable|numeric|max:50000',
            'typ_k' => 'nullable|alpha|in:K,N,S',
            'model_k' => 'nullable|string|max:50',
            'inwent_k' => 'required|numeric|digits:4|unique:sqlsrv.intranet.komputery,inwent_k,'.$id.',id_k',
            'serial_k' => 'nullable|string|max:50|unique:sqlsrv.intranet.komputery,inwent_k,'.$id.',id_k',
            'data_k' => 'required|date|before:tomorrow',
            'id_u' => 'nullable|exists:sqlsrv.intranet.uzytkownicy,id_u',
            'id_dz' => 'nullable|exists:sqlsrv.intranet.dzialy,id_dz',
            ]);
        $request->session()->flash('kompStep1', $step1); 
        return view('komputery.editStep2', [
             'step1' => $step1,
             'id' => $id,
             ]);
    }
    public function updateOneCol($id, Request $request) {
    
        $validatedData = $request->validate([
            'id_k' => 'required|numeric|exists:sqlsrv.intranet.komputery',
            'id_u' => 'sometimes|required|numeric|exists:sqlsrv.intranet.uzytkownicy',
            'old_id_u' => 'sometimes|nullable|numeric',
            'id_dz' => 'sometimes|nullable|numeric|exists:sqlsrv.intranet.dzialy',
            'old_id_dz' => 'sometimes|nullable|numeric',
            'id_m' => 'sometimes|nullable|numeric|exists:sqlsrv.intranet.monitory',
            'old_id_m' => 'sometimes|nullable|numeric',
            'id_ups' => 'sometimes|nullable|numeric|exists:sqlsrv.intranet.upsy',
            'old_id_ups' => 'sometimes|nullable|numeric',
            'dns_k' => 'sometimes|required|unique:sqlsrv.intranet.komputery|max:15|string',
            'old_dns_k' => 'sometimes|required|exists:sqlsrv.intranet.komputery,dns_k|max:15|alpha_num',
            'ip_k' => 'sometimes|nullable|unique:sqlsrv.intranet.komputery|ipv4',
            'old_ip_k' => 'sometimes|nullable',
            'proc_k' => 'sometimes|required|string|max:50',
            'old_proc_k' => 'sometimes|nullable|string',
            'ram_k' => 'sometimes|required|numeric|max:256',
            'old_ram_k' => 'sometimes|nullable|numeric',
            'hdd_k' => 'sometimes|required|numeric|max:50000',
            'old_hdd_k' => 'sometimes|nullable|numeric',
            'inwent_k' => 'sometimes|required|numeric|digits:4|unique:sqlsrv.intranet.komputery',
            'old_inwent_k' => 'sometimes|nullable',
            'serial_k' => 'sometimes|nullable|string|max:50|unique:sqlsrv.intranet.komputery',
            'old_serial_k' => 'sometimes|nullable',
            'typ_k' => 'sometimes|required|alpha|in:K,N,S',
            'old_typ_k' => 'sometimes|nullable',
            'model_k' => 'sometimes|required|string|max:50',
            'old_model_k' => 'sometimes|nullable',
            'data_k' => 'sometimes|required|date|before:tomorrow',
            'old_data_k' => 'sometimes|nullable',
            'oldProperty' => 'required|in:dns_k,inwent_k,serial_k,typ_k,model_k,data_k,ip_k,proc_k,ram_k,hdd_k,id_u,id_dz,id_m,id_ups',
            'dnr' => 'sometimes|numeric|in:1'
        ]);
        $KompWpis =  Komputer::findOrFail($validatedData['id_k']);
        if ($validatedData['oldProperty'] == 'id_ups') {
            $ups = UPS::findOrFail($validatedData['id_ups']);
            $KompUPS =  Komputer::findOrFail($validatedData['id_k']);
            if (array_key_exists('old_id_ups',$validatedData)) {
                $oldUPS = UPS::findOrFail($validatedData['old_id_ups']);
                $affectedOld = DB::table('intranet.upsy')
                    ->where('id_ups', $validatedData['old_id_ups'])
                    ->update(['id_k' => 0]);
                
                $wpis = 'UPS [id_ups] => '.$oldUPS['id_ups'];
                $wpis .= ', [model_ups] => '.$oldUPS['model_ups'];
                $wpis .= ', [serial_ups] => '.$oldUPS['serial_ups'];
                $wpis .= ', [inwent_ups] => '.$oldUPS['inwent_ups'];
                $wpis .= ' został odłączony od komputera [id_k] => '.$KompUPS['id_k'];
                $wpis .= ', [dns_k] => '.$KompUPS['dns_k'];
                $wpis .= ', [inwent_k] => '.$KompUPS['inwent_k'];
                $wpis .= ', [serial_k] => '.$KompUPS['serial_k'];
                app('App\Http\Controllers\HistoriaController')->store('upsy', $validatedData['old_id_ups'], $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
            }
            if ((!array_key_exists('old_id_ups',$validatedData)) || $validatedData['id_ups'] != $validatedData['old_id_ups']) {    
                $affected = DB::table('intranet.upsy')
                ->where('id_ups', $validatedData['id_ups'])
                ->update(['id_k' => $validatedData['id_k']]);
                
                $wpis = 'UPS [id_ups] => '.$ups['id_ups'];
                $wpis .= ', [model_ups] => '.$ups['model_ups'];
                $wpis .= ', [serial_ups] => '.$ups['serial_ups'];
                $wpis .= ', [inwent_ups] => '.$ups['inwent_ups'];
                $wpis .= ' został przypisany od komputera [id_k] => '.$KompUPS['id_k'];
                $wpis .= ', [dns_k] => '.$KompUPS['dns_k'];
                $wpis .= ', [inwent_k] => '.$KompUPS['inwent_k'];
                $wpis .= ', [serial_k] => '.$KompUPS['serial_k'];
                app('App\Http\Controllers\HistoriaController')->store('upsy', $validatedData['id_ups'], $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
            }
        }
        elseif ($validatedData['oldProperty'] == 'id_m') {
            
            $monitor = Monitor::findOrFail($validatedData['id_m']);
            $KompM =  Komputer::findOrFail($validatedData['id_k']);
            
            if (array_key_exists('old_id_m',$validatedData)) {
                
                $oldMonitor = Monitor::findOrFail($validatedData['old_id_m']);
                $affectedOld = DB::table('intranet.monitory')
                    ->where('id_m', $validatedData['old_id_m'])
                    ->update(['id_k' => 0]);
                    
                $wpis = 'Monitor [id_m] => '.$oldMonitor['id_m'];
                $wpis .= ', [model_m] => '.$oldMonitor['model_m'];
                $wpis .= ', [serial_m] => '.$oldMonitor['serial_m'];
                $wpis .= ', [inwent_m] => '.$oldMonitor['inwent_m'];
                $wpis .= ' został odłączony od komputera [id_k] => '.$KompM['dns_k'];
                $wpis .= ', [dns_k] => '.$KompM['dns_k'];
                $wpis .= ', [inwent_k] => '.$KompM['inwent_k'];
                app('App\Http\Controllers\HistoriaController')->store('monitory', $validatedData['old_id_m'], $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
            }
            if ((!array_key_exists('old_id_m',$validatedData)) || $validatedData['id_m'] != $validatedData['old_id_m']) {    
                $affected = DB::table('intranet.monitory')
                    ->where('id_m', $validatedData['id_m'])
                    ->update(['id_k' => $validatedData['id_k']]);

                    $wpis = 'Monitor [id_m] => '.$monitor['id_m'];
                    $wpis .= ', [model_m] => '.$monitor['model_m'];
                    $wpis .= ', [inwent_m] => '.$monitor['inwent_m'];
                    $wpis .= ', [serial_m] => '.$monitor['serial_m'];
                    $wpis .= ' został prszypisany do komputera [id_k] => '.$KompM['id_k'];
                    $wpis .= ', [dns_k] => '.$KompM['dns_k'];
                    $wpis .= ', [inwent_k] => '.$monitor['inwent_k'];
                    $wpis .= ', [serial_m] => '.$monitor['serial_k'];
                    app('App\Http\Controllers\HistoriaController')->store('monitory', $validatedData['id_m'], $wpis);
                    app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
            }   
        }
        elseif ($validatedData['oldProperty'] == 'id_u') {
            
            $user = Uzytkownik::findOrFail($validatedData['id_u']);
            $KompUser =  Komputer::findOrFail($validatedData['id_k']);

            if (array_key_exists('old_id_u',$validatedData)) {
                $oldUser = Uzytkownik::findOrFail($validatedData['old_id_u']);
                $affectedOld = DB::table('intranet.komputery')
                    ->where('id_k', $validatedData['id_k'])
                    ->update(['id_u' => 0]);
                
                    $wpis = 'Komputer';
                    $wpis .= ' [id_k] => '.$KompUser['id_k'];
                    $wpis .= ', [dns_k] => '.$KompUser['dns_k'];
                    $wpis .= ', [inwent_k] => '.$KompUser['inwent_k'];
                    $wpis .= ', [serial_k] => '.$KompUser['serial_k'];
                    $wpis .= ' został odłączony od użytkownika';
                    $wpis .= ' [id_u] => '.$oldUser['id_u'];
                    $wpis .= ', [nazwa_u] => '.$oldUser['nazwa_u'];
                    $wpis .= ', [imie_u] => '.$oldUser['imie_u'];
                    app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $validatedData['old_id_u'], $wpis);
                    app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
            }
            if ((!array_key_exists('old_id_u',$validatedData)) || $validatedData['id_u'] != $validatedData['old_id_u']) {    
            
                $affected = DB::table('intranet.komputery')
                    ->where('id_k', $validatedData['id_k'])
                    ->update(['id_u' => $validatedData['id_u']]);
                
                $wpis = 'Komputer';
                $wpis .= ' [id_k] => '.$KompUser['id_k'];
                $wpis .= ', [dns_k] => '.$KompUser['dns_k'];
                $wpis .= ', [inwent_k] => '.$KompUser['inwent_k'];
                $wpis .= ', [serial_k] => '.$KompUser['serial_k'];
                $wpis .= ' został przypisany od użytkownika';
                $wpis .= ' [id_u] => '.$user['id_u'];
                $wpis .= ' ('.$user['nazwa_u'].' '.$user['imie_u'].')';
                app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $validatedData['id_u'], $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
            }
        }
        elseif ($validatedData['oldProperty'] == 'id_dz') {
            
            $Dzial = Dzial::findOrFail($validatedData['id_dz']);
            $KompDzial =  Komputer::findOrFail($validatedData['id_k']);

            if (array_key_exists('old_id_dz',$validatedData)) {
                $oldDzial = Dzial::findOrFail($validatedData['old_id_dz']);
                $affectedOld = DB::table('intranet.komputery')
                    ->where('id_k', $validatedData['id_k'])
                    ->update(['id_dz' => 0]);
                
                    $wpis = 'Komputer';
                    $wpis .= ' [id_k] => '.$KompDzial['id_k'];
                    $wpis .= ', [dns_k] => '.$KompDzial['dns_k'];
                    $wpis .= ', [inwent_k] => '.$KompDzial['inwent_k'];
                    $wpis .= ', [serial_k] => '.$KompDzial['serial_k'];
                    $wpis .= ' został odłączony od działu';
                    $wpis .= ' [id_dz] => '.$oldDzial['id_dz'];
                    $wpis .= ', [nazwa_d] => '.$oldDzial['nazwa_d'];
                    $wpis .= ', [symbol_d] => '.$oldDzial['symbol_d'];
                    app('App\Http\Controllers\HistoriaController')->store('dzialy', $validatedData['old_id_dz'], $wpis);
                    app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
            }
            if ((!array_key_exists('old_id_dz',$validatedData)) || $validatedData['id_dz'] != $validatedData['old_id_dz']) {    
                
                $affected = DB::table('intranet.komputery')
                    ->where('id_k', $validatedData['id_k'])
                    ->update(['id_dz' => $validatedData['id_dz']]);
                
                $wpis = 'Komputer';
                $wpis .= ' [id_k] => '.$KompDzial['id_k'];
                $wpis .= ', [dns_k] => '.$KompDzial['dns_k'];
                $wpis .= ', [inwent_k] => '.$KompDzial['inwent_k'];
                $wpis .= ', [serial_k] => '.$KompDzial['serial_k'];
                $wpis .= ' został przypisany od działu';
                $wpis .= ' [id_dz] => '.$Dzial['id_dz'];
                $wpis .= ', [nazwa_d] => '.$Dzial['nazwa_d'];
                $wpis .= ', [symbol_d] => '.$Dzial['symbol_d'];
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $validatedData['id_dz'], $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
            }
        }
        else{
            $affected = DB::table('intranet.komputery')
                ->where('id_k', $validatedData['id_k'])
                ->update([$validatedData['oldProperty'] => $validatedData[$validatedData['oldProperty']]]);

            if ($affected) {
                if (!array_key_exists('old_'.$validatedData['oldProperty'],$validatedData)) {
                    $wpis = 'Wprowadzono nowe dane komputera';
                    $wpis .= ' [id_k] => '.$validatedData['id_k'];
                    $wpis .= ' Dodano ['.$validatedData['oldProperty']. '] => ';
                    $wpis .= $validatedData[$validatedData['oldProperty']];
                    app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
                }
                else {
                    $wpis = 'Edytowano dane komputera';
                    $wpis .= ' [id_k] => '.$validatedData['id_k'];
                    $wpis .= ' Zmieniono ['.$validatedData['oldProperty'].']: ';
                    $wpis .= $validatedData['old_'.$validatedData['oldProperty']].' => ';
                    $wpis .= $validatedData[$validatedData['oldProperty']];
                    app('App\Http\Controllers\HistoriaController')->store('komputery', $validatedData['id_k'], $wpis);
                }
            }
        }
        
        $uzytkownicy = Uzytkownik::orderBy('nazwa_u')->get();
        $komp = DB::table('intranet.komputery as komputery')
            ->leftJoin('intranet.uzytkownicy as uzytkownicy','uzytkownicy.id_u', '=', 'komputery.id_u')
            ->leftJoin('intranet.dzialy as dzialy','dzialy.id_dz', '=', 'komputery.id_dz')
            ->leftJoin('intranet.monitory as monitory', 'komputery.id_k', '=', 'monitory.id_k')
            ->leftJoin('intranet.upsy as upsy','upsy.id_k', '=', 'komputery.id_k')
            //->select('komputery.*', 'uzytkownicy.id_u', 'uzytkownicy.nazwa_u', 'uzytkownicy.imie_u', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d', 'uzytkownicy.id_dz AS userIdDz')
            ->select('komputery.*', 'uzytkownicy.*', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d', 'uzytkownicy.id_dz AS userIdDz', 'monitory.id_m', 'monitory.model_m', 'upsy.id_ups', 'upsy.model_ups', 'upsy.inwent_ups')
            ->where('komputery.id_k',$id)
            ->get()
            ->first();
        
            if (!Arr::exists($validatedData, 'dnr')) {
                return view('komputery.show', [
                    'komputer' => $komp,
                    'uzytkownicy' => $uzytkownicy,
                ]);
            }
    }
    public function update($id, Request $request) {
        $validatedData = $request->validate([
            'dns_k' => 'required|max:15|unique:sqlsrv.intranet.komputery,dns_k,'.$id.',id_k',
            'id_u' => 'nullable|numeric|exists:sqlsrv.intranet.uzytkownicy',
            'id_dz' => 'nullable|numeric|exists:sqlsrv.intranet.dzialy',
            'ip_k' => 'nullable|ipv4|unique:sqlsrv.intranet.komputery,ip_k,'.$id.',id_k',
            'data_k' => 'required|date|before:tomorrow',
            'proc_k' => 'nullable|string|max:50',
            'ram_k' => 'nullable|numeric|max:256',
            'hdd_k' => 'nullable|numeric|max:50000',
            'inwent_k' => 'required|numeric|digits:4|unique:sqlsrv.intranet.komputery,inwent_k,'.$id.',id_k',
            'serial_k' => 'nullable|string|max:50|unique:sqlsrv.intranet.komputery,inwent_k,'.$id.',id_k',
            'typ_k' => 'required|alpha|in:K,N,S',
            'model_k' => 'nullable|string|max:50',
        ]);
        $oldKomp = DB::table('intranet.komputery as komputery')
            ->leftJoin('intranet.uzytkownicy as uzytkownicy','uzytkownicy.id_u', '=', 'komputery.id_u')
            ->leftJoin('intranet.dzialy as dzialy','dzialy.id_dz', '=', 'uzytkownicy.id_dz')
            ->select('komputery.*', 'uzytkownicy.*', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d')
            ->where('komputery.id_k',$id)
            ->get()
            ->first();

        $affected = DB::table('intranet.komputery as komputery')
            ->where('id_k', $id)
            ->update([
                'id_u' => $validatedData['id_u'],
                'id_dz' => $validatedData['id_dz'],
                'dns_k' => $validatedData['dns_k'],
                'inwent_k' => $validatedData['inwent_k'],
                'serial_k' => $validatedData['serial_k'],
                'data_k' => $validatedData['data_k'],
                'typ_k' => $validatedData['typ_k'],
                'model_k' => $validatedData['model_k'],
                'proc_k' => $validatedData['proc_k'],
                'ram_k' => $validatedData['ram_k'],
                'hdd_k' => $validatedData['hdd_k'],
                'ip_k' => $validatedData['ip_k'],
                ]);
        if($affected) {
            $log = new Historia();
            $log->tabela = 'komputery';
            $log->id_o = $id;
            $log->wpis = 'Zmieniono dane komputera [id_k] => '.$id.':';
            if ($oldKomp->dns_k != $validatedData['dns_k']) 
                $log->wpis .= ' [dns_k]: '.$oldKomp->dns_k. ' => '.$validatedData['dns_k'];
            if ($oldKomp->inwent_k != $validatedData['inwent_k']) 
                $log->wpis .= ' [inwent_k]: '.$oldKomp->inwent_k. ' => '.$validatedData['inwent_k'];
            if ($oldKomp->serial_k != $validatedData['serial_k']) 
                $log->wpis .= ' [serial_k]: '.$oldKomp->serial_k. ' => '.$validatedData['serial_k'];
            if ($oldKomp->typ_k != $validatedData['typ_k']) 
                $log->wpis .= ' [typ_k]: '.$oldKomp->typ_k. ' => '.$validatedData['typ_k'];
            if ($oldKomp->model_k != $validatedData['model_k']) 
                $log->wpis .= ' [model_k]: '.$oldKomp->model_k. ' => '.$validatedData['model_k'];
            if ($oldKomp->data_k != $validatedData['data_k']) 
                $log->wpis .= ' [data_k]: '.$oldKomp->data_k. ' => '.$validatedData['data_k'];
            if ($oldKomp->ip_k != $validatedData['ip_k']) 
                $log->wpis .= ' [ip_k]: '.$oldKomp->ip_k. ' => '.$validatedData['ip_k'];
            if ($oldKomp->proc_k != $validatedData['proc_k']) 
                $log->wpis .= ' [proc_k]: '.$oldKomp->proc_k. ' => '.$validatedData['proc_k'];
            if ($oldKomp->ram_k != $validatedData['ram_k'])
                $log->wpis .= ' [ram_k]: '.$oldKomp->ram_k. ' => '.$validatedData['ram_k'];
            if ($oldKomp->hdd_k != $validatedData['hdd_k']) 
                $log->wpis .= ' [hdd_k]: '.$oldKomp->hdd_k. ' => '.$validatedData['hdd_k'];
            if ($oldKomp->id_u != $validatedData['id_u']) {
                $log->wpis .= ' [id_u]: '.$oldKomp->id_u. ' => '.$validatedData['id_u'];
                if ($oldUser =  Uzytkownik::findOrFail($oldKomp->id_u) && $newUser =  Uzytkownik::findOrFail($validatedData['id_u'])){ 
                    $oldUser =  Uzytkownik::findOrFail($oldKomp->id_u);
                    $log->wpis .= ' ( '.$oldUser['nazwa_u'].' '.$oldUser['imie_u'].' => '.$newUser['nazwa_u'].' '.$newUser['imie_u']. ' )';
                }
                else {
                    $log->wpis .= ' (brak informacji o nazwie użytkownika)';
                }
            }
            if ($oldKomp->id_dz != $validatedData['id_dz']) {
                $log->wpis .= ' id_dz: '.$oldKomp->id_dz. ' => '.$validatedData['id_dz'];
                if ($oldDzial =  Dzial::findOrFail($oldKomp->id_dz) && $newDzial =  Dzial::findOrFail($validatedData['id_dz'])){ 
                    $oldDzial =  Dzial::findOrFail($oldKomp->id_dz);
                    $log->wpis .= ' ([symbol_d]: '.$oldDzial['symbol_d'].' => '.$newDzial['sumbol_d'].' )';
                }
                else {
                    $log->wpis .= ' (brak informacji o nazwie użytkownika)';
                }
            }
            $log->kto = Auth::user()->username;    
            $log->save(); 
        }
        $uzytkownicy = Uzytkownik::orderBy('nazwa_u')->get();
        $komp = DB::table('intranet.komputery as komputery')
            ->leftJoin('intranet.uzytkownicy as uzytkownicy','uzytkownicy.id_u', '=', 'komputery.id_u')
            ->leftJoin('intranet.dzialy as dzialy','dzialy.id_dz', '=', 'uzytkownicy.id_dz')
            ->select('komputery.*', 'uzytkownicy.*', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d')
            ->where('komputery.id_k',$id)
            ->get()
            ->first();
        return $this->show($id, $request);
        //return view('komputery.show', [
        //    'komputer' => $komp,
        //    'uzytkownicy' => $uzytkownicy
        //]);
    }
    public function disconnectUser($id) {
        $komp = Komputer::findOrFail($id); 
        if ($komp->id_u >0) {
            if ($user = Uzytkownik::find($komp->id_u)) {
                DB::table('intranet.komputery')
                    ->updateOrInsert(   
                        ['id_k' => $id],
                        ['id_u' => null]);
                $wpis = 'Od komputera [id_k] => '.$komp->id_k;
                $wpis .= ' [dns_k] => '.$komp->dns_k;
                $wpis .= ' [inwent_k] => '.$komp->inwent_k;
                $wpis .= ' [serial_k] => '.$komp->serial_k;
                $wpis .= ' odłączono użytkownika [id_u] => '.$user->id_u;
                $wpis .= ' ('.$user->nazwa_u. ' '.$user->imie_u.')';
                app('App\Http\Controllers\HistoriaController')->store('komputery', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $user->id_u, $wpis);
            }
        }
    }
    public function disconnectDzial($id) {
        $komp = Komputer::findOrFail($id); 
        if ($komp->id_dz >0) {
            if ($dzial = Dzial::find($komp->id_dz)) {
                DB::table('intranet.komputery')
                    ->updateOrInsert(   
                    ['id_k' => $id],
                    ['id_dz' => null]);
                $wpis = 'Z działu [id_dz] => '.$dzial->id_dz;
                $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
                $wpis .= ' usunięto komputer [id_k] => '.$komp->id_k;
                $wpis .= ', [dns_k] => '.$komp->dns_k;
                $wpis .= ', [inwent_k] => '.$komp->inwent_k;
                $wpis .= ', [serial_k] => '.$komp->serial_k;
                app('App\Http\Controllers\HistoriaController')->store('komputery', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $dzial->id_dz, $wpis);
            }
        }
    }
    public function clearField($id, $field) {
        $komp = Komputer::findOrFail($id); 
        DB::table('intranet.komputery')
            ->updateOrInsert(   
                ['id_k' => $id],
                [$field => null]);
        $wpis = 'Dla komputera [id_k] => '.$komp->id_k.', [dns_k] => '.$komp->dns_k;
        $wpis .= ' usunięto wartość ['.$field.'] => '.$komp->$field;
        app('App\Http\Controllers\HistoriaController')->store('komputery', $id, $wpis);
    }  
    public function activate($id) {
        $komputer = Komputer::findOrFail($id);
        $affected = DB::table('intranet.komputery')
            ->where('id_k', $id)
            ->update(['status_k' => 1]);
        $wpis = 'Komputer '.$komputer->dns_k.' o id '.$id;
        $wpis .= ' został ponownie aktywowany.';
        app('App\Http\Controllers\HistoriaController')->store('komputery', $id, $wpis);
        return redirect('/komputery');
    }
    public function disable($id) {
        $instalacje = DB::table('intranet.instalacje')->where('id_k', $id)->get();
        foreach ($instalacje as $instalacja) {
            $instalacjaArray = [
                'id_k' => $instalacja->id_k, 
                'id_i' => $instalacja->id_i,
                'dnr' => '1',
            ];
            $request = new Request($instalacjaArray);
            $this->delSoft($request);            
        }
        
        ### END KASOWANIE INSTALCJ ###
        ##############################
        ### ODŁACZANIE URZĄDZEŃ ###
        $devs = DB::table('intranet.urzadzenia')->where('id_k', $id)->get();
        foreach ($devs as $dev) {
            $devArray = [
                'id_k' => $dev->id_k, 
                'id_dev' => $dev->id_dev,
                'dnr' => '1',
            ];
            $request = new Request($devArray);
            $this->delDev($request);            
        }
        
        ### END ODŁĄCZANIE URZĄDZEŃ ###
        ###############################
        ### ODŁĄCZANIE UŻYTKOWNIKA I DZIAŁU ###
        $this->disconnectUser($id);
        $this->disconnectDzial($id);
        ### END ODŁACZANIE UŻYTKOWNIKA I DZIAŁU ###
        ### KASOWANIE IP ###
        $this->clearField($id, 'ip_k');
        ### END KASOWANIE IP ###
        $komputer = Komputer::findOrFail($id);
        $affected = DB::table('intranet.komputery')
              ->where('id_k', $id)
              ->update(['status_k' => 0]);
        //$komputer->delete();
        
        return redirect('/komputery?active=0');;
    }
    public function destroy($id) {
        ### KASOWANIE INSTALACJI ###
        $instalacje = DB::table('intranet.instalacje')->where('id_k', $id)->get();
        foreach ($instalacje as $instalacja) {
            $instalacjaArray = [
                'id_k' => $instalacja->id_k, 
                'id_i' => $instalacja->id_i,
                'dnr' => '1',
            ];
            $request = new Request($instalacjaArray);
            $this->delSoft($request);            
        }
        ### END KASOWANIE INSTALCJ ###
        ##############################
        ### ODŁACZANIE URZĄDZEŃ ###
        $devs = DB::table('intranet.urzadzenia')->where('id_k', $id)->get();
        foreach ($devs as $dev) {
            $devArray = [
                'id_k' => $dev->id_k, 
                'id_dev' => $dev->id_dev,
                'dnr' => '1',
            ];
            $request = new Request($devArray);
            $this->delDev($request);            
        }
        ### END ODŁĄCZANIE URZĄDZEŃ ###
        ###############################
        ### ODŁĄCZANIE UŻYTKOWNIKA I DZIAŁU ###
        $this->disconnectUser($id);
        $this->disconnectDzial($id);
        ### END ODŁACZANIE UŻYTKOWNIKA I DZIAŁU ###
        ### KASOWANIE IP ###
        $this->clearField($id, 'ip_k');
        ### END KASOWANIE IP ###
        $komputer = Komputer::findOrFail($id);
        //$affected = DB::table('intranet.komputery')
        //      ->where('id_k', $id)
        //      ->update(['status_k' => 0]);
        $komputer->delete();
        return redirect('/komputery?active=0');
    }
    public function delSoft(Request $request) {
        $validatedData = $request->validate([
            'id_k' => 'required|exists:sqlsrv.intranet.komputery',
            'id_i' => 'required|exists:sqlsrv.intranet.instalacje',
            'dnr' => 'sometimes|numeric|in:1'       
        ]);
        $oldSoft = DB::table('intranet.instalacje as instalacje')
            ->leftJoin('intranet.programy as programy','instalacje.id_p', '=', 'programy.id_p')
            ->select('instalacje.id_i','programy.*')
            ->where([
                ['instalacje.id_i', '=', $validatedData['id_i']],
                ])
            ->get()
            ->first();
            
        $instalacja = Instalacja::findOrFail($validatedData['id_i']);
        $instalacja->delete();
        if ($instalacja) {
            $komp = Komputer::findOrFail($validatedData['id_k']);
            $log = new Historia();
            $log->tabela = 'komputery';
            $log->id_o = $validatedData['id_k'];
            $log->wpis = 'Z komputera '.$komp['dns_k'].' o id '.$validatedData['id_k'];
            $log->wpis .= ' usunięto program '.$oldSoft->nazwa_p;
            $log->wpis .= ' o numerze id '.$oldSoft->id_p;
            $log->kto = Auth::user()->username;
            $log->save();

            $logSoft = new Historia();
            $logSoft->tabela = 'programy';
            $logSoft->id_o = $oldSoft->id_p;
            $logSoft->wpis = 'Program '.$oldSoft->nazwa_p. ' o id '.$oldSoft->id_p;
            $logSoft->wpis .= ' usunięto z komputera '.$komp['dns_k'];
            $logSoft->wpis .= ' o numerze id '.$validatedData['id_k'];
            $logSoft->wpis .= ' i numerze inwent '.$komp['inwent_k'];
            $logSoft->kto = Auth::user()->username;
            $logSoft->save();
        }
        if (!Arr::exists($validatedData, 'dnr')) {
            //if ($validatedData['dnr'] != '1') {
                return $this->show($validatedData['id_k'], $request);
            //}
        }
    }
    public function addSoft(Request $request) {
        $validatedData = $request->validate([
            'id_k' => 'required|numeric|exists:sqlsrv.intranet.komputery',
            'id_p' => 'required|numeric|exists:sqlsrv.intranet.programy',
            'id_i' => 'sometimes|numeric|exists:sqlsrv.intranet.instalacje',
        ]);
        if (isset($validatedData['id_i'])) {
            $instalacja = Instalacja::findOrFail($validatedData['id_i']);
            $oldSoft = Program::findOrFail($instalacja->id_p);
            $instalacja->delete();
            if ($instalacja) {
                $Soft = Program::findOrFail($validatedData['id_p']);
                $komp = Komputer::findOrFail($validatedData['id_k']);
                $log = new Historia();
                $log->tabela = 'komputery';
                $log->id_o = $validatedData['id_k'];
                $log->wpis = 'Z komputera '.$komp['dns_k'].' o id '.$validatedData['id_k'];
                $log->wpis .= ' usunięto program '.$oldSoft['nazwa_p'];
                $log->wpis .= ' o numerze id '.$oldSoft['id_p'];
                $log->kto = Auth::user()->username;
                $log->save();
    
                $logSoft = new Historia();
                $logSoft->tabela = 'programy';
                $logSoft->id_o = $validatedData['id_p'];
                $logSoft->wpis = 'Program '.$oldSoft['nazwa_p']. ' o id '.$oldSoft['id_p'];
                $logSoft->wpis .= ' usunięto z komputera '.$komp['dns_k'];
                $logSoft->wpis .= ' o numerze id '.$validatedData['id_k'];
                $logSoft->wpis .= ' i numerze inwent '.$komp['inwent_k'];
                $logSoft->kto = Auth::user()->username;
                $logSoft->save();
            }
        }
        
        $instalacja = new Instalacja();
        $instalacja->id_k = $validatedData['id_k'];
        $instalacja->id_p = $validatedData['id_p'];
        $instalacja->save();

        
        if ($instalacja) {
            $soft = Program::findOrFail($validatedData['id_p']);
            $komp = Komputer::findOrFail($validatedData['id_k']);
            $log = new Historia();
            $log->tabela = 'komputery';
            $log->id_o = $validatedData['id_k'];
            $log->wpis = 'Do komputera '.$komp['dns_k'].' o id '.$validatedData['id_k'];
            $log->wpis .= ' dodano program '.$soft['nazwa_p'];
            $log->wpis .= ' o numerze id '.$soft['id_p'];
            $log->kto = Auth::user()->username;
            $log->save();

            $logSoft = new Historia();
            $logSoft->tabela = 'programy';
            $logSoft->id_o = $validatedData['id_p'];
            $logSoft->wpis = 'Program '.$soft['nazwa_p']. ' o id '.$validatedData['id_p'];
            $logSoft->wpis .= ' dodano do komputera '.$komp['dns_k'];
            $logSoft->wpis .= ' o numerze id '.$validatedData['id_k'];
            $logSoft->wpis .= ' i numerze inwent '.$komp['inwent_k'];
            $logSoft->kto = Auth::user()->username;
            $logSoft->save();
        }
        return $this->show($validatedData['id_k'], $request);
    
    }
    public function addDev(Request $request) {
        $validatedData = $request->validate([
            'id_k' => 'required|numeric|exists:sqlsrv.intranet.komputery',
            'id_dev' => 'required|numeric|exists:sqlsrv.intranet.urzadzenia',
        ]);
        $affected = DB::table('intranet.urzadzenia')
              ->where('id_dev', $validatedData['id_dev'])
              ->update(['id_k' => $validatedData['id_k']]);
        if ($affected) {
            $dev = Urzadzenie::findOrFail($validatedData['id_dev']);
            $komp = Komputer::findOrFail($validatedData['id_k']);
            $log = new Historia();
            $log->tabela = 'komputery';
            $log->id_o = $validatedData['id_k'];
            $log->wpis = 'Do komputera '.$komp['dns_k'].' o id '.$validatedData['id_k'];
            $log->wpis .= ' dodano urządzenie '.$dev['nazwa_dev'];
            $log->wpis .= ' o numerze id '.$dev['id_dev'];
            $log->wpis .= ' i numerze inwent '.$dev['inwent_dev'];
            $log->kto = Auth::user()->username;
            $log->save();

            $logDev = new Historia();
            $logDev->tabela = 'urzadzenia';
            $logDev->id_o = $validatedData['id_dev'];
            $logDev->wpis = 'Urządzenie '.$dev['nazwa_dev']. ' o id '.$validatedData['id_dev'];
            $logDev->wpis .= ' dołączono do komputera '.$komp['dns_k'];
            $logDev->wpis .= ' o numerze id '.$validatedData['id_k'];
            $logDev->wpis .= ' i numerze inwent '.$komp['inwent_k'];
            $logDev->kto = Auth::user()->username;
            $logDev->save();
        }
        return $this->show($validatedData['id_k'], $request);
    }
    public function delDev(Request $request) {
        $validatedData = $request->validate([
            'id_k' => 'required|numeric|exists:sqlsrv.intranet.komputery',
            'id_dev' => 'required|numeric|exists:sqlsrv.intranet.urzadzenia',       
            'dnr' => 'sometimes|numeric|in:1'       
        ]);
        $affected = DB::table('intranet.urzadzenia')
              ->where('id_dev', $validatedData['id_dev'])
              ->update(['id_k' => NULL]);
        
        if ($affected) {
            $dev = Urzadzenie::findOrFail($validatedData['id_dev']);
            $komp = Komputer::findOrFail($validatedData['id_k']);
            $log = new Historia();
            $log->tabela = 'komputery';
            $log->id_o = $validatedData['id_k'];
            $log->wpis = 'Z komputera '.$komp['dns_k'].' o id '.$validatedData['id_k'];
            $log->wpis .= ' usunięto urządzenie '.$dev['nazwa_dev'];
            $log->wpis .= ' o numerze id '.$dev['id_dev'];
            $log->wpis .= ' i numerze inwent '.$dev['inwent_dev'];
            $log->kto = Auth::user()->username;
            $log->save();

            $logDev = new Historia();
            $logDev->tabela = 'urzadzenia';
            $logDev->id_o = $validatedData['id_dev'];
            $logDev->wpis = 'Urządzenie '.$dev['nazwa_dev']. ' o id '.$validatedData['id_dev'];
            $logDev->wpis .= ' usunięto z komputera '.$komp['dns_k'];
            $logDev->wpis .= ' o numerze id '.$validatedData['id_k'];
            $logDev->wpis .= ' i numerze inwent '.$komp['inwent_k'];
            $logDev->kto = Auth::user()->username;
            $logDev->save();
        }
        if (!$validatedData['dnr'] || !$validatedData['dnr'] != '1') {
            return $this->show($validatedData['id_k'], $request);
        }
    }
}