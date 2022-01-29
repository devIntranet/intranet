<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dzial;
use App\Uzytkownik;
use App\Komputer;
use App\Urzadzenie; 
use App\Historia;
use Illuminate\Support\Facades\DB;
use Adldap\Laravel\Facades\Adldap;

class DzialController extends Controller
{
    public function index() {
       //$komputery = Komputer::all();
       $sortable = ['symbol_d', 'symbol_parent', 'nazwa_d', 'id_uk', 'id_p'];
       $order='symbol_d';
       $direction = 'asc';
       $active = request('active');
       $search = Adldap::search()->where('samAccountName', '=', 'sebastianj')->get();
       //return $search;
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
       $dzialy = DB::table('intranet.dzialy as dzialy')
        ->leftJoin('intranet.dzialy as d2', 'd2.id_dz', '=', 'dzialy.parent_dz')
        ->leftJoin('intranet.uzytkownicy as uzytkownicy', 'dzialy.id_uk', '=', 'uzytkownicy.id_u')
        ->leftJoin('intranet.piony as piony', 'piony.id_p', '=', 'dzialy.id_p')
        ->select('dzialy.*',
            'd2.symbol_d as symbol_parent', 'd2.id_dz as id_parent',
            'piony.nazwa_p', 'uzytkownicy.nazwa_u', 'uzytkownicy.imie_u')
        ->orderBy($order, $direction)
        ->where([['dzialy.status_dz', '=', $active],])
        ->get();
       return view ('dzialy.index', ['dzialy' => $dzialy]);
    }
    private function getKomputeryDzialu($id) {
        return DB::table('intranet.komputery as komputery')
            ->leftJoin('intranet.uzytkownicy as uzytkownicy', 'komputery.id_u', '=', 'uzytkownicy.id_u')
            ->where([
                ['komputery.id_dz', '=', $id],
                ['komputery.status_k', '=', 1],
                ])
            ->orderBy('komputery.dns_k')
            ->get();
    }
    private function getUzytkownicyDzialu($id) {
        return DB::table('intranet.uzytkownicy as uzytkownicy')
            ->leftJoin('intranet.komputery as komputery', 'komputery.id_u', '=', 'uzytkownicy.id_u')
            ->select('uzytkownicy.*','komputery.id_k', 'komputery.dns_k')
            ->where([
                ['uzytkownicy.id_dz', '=', $id],
                ['uzytkownicy.status_u', '=', '1'],
                ])
            ->orderBy('uzytkownicy.nazwa_u')
            ->get();
    }
    private function getOperatorzyWnioskow($id) {
        return DB::table('intranet.wnioski_operatorzy as operatorzyWN')
            ->leftJoin('intranet.uzytkownicy as uzytkownicy', 'operatorzyWN.id_u', '=', 'uzytkownicy.id_u')
            ->select('OperatorzyWN.*','uzytkownicy.nazwa_u', 'uzytkownicy.imie_u')
            ->where([
                ['operatorzyWN.id_dz', '=', $id],
                ['uzytkownicy.status_u', '=', '1'],
                ])
            ->orderBy('uzytkownicy.nazwa_u')
            ->get();
    }
    private function getUrzadzeniaDzialu($id) {
        return DB::table('intranet.urzadzenia as urzadzenia')
            ->where([
                ['urzadzenia.id_dz', '=', $id],
                ['urzadzenia.status_dev', '=', '1'],
                ])
            ->orderBy('urzadzenia.nazwa_dev')
            ->get();
    }
    private function getKomputeryToAdd() {
        return DB::table('intranet.komputery as komputery')
            ->leftJoin('intranet.uzytkownicy as uzytkownicy', 'komputery.id_u', '=', 'uzytkownicy.id_u')
            ->where([
                ['komputery.id_dz', '=', 0],
                ['komputery.status_k', '=', 1],
            ])
            ->orWhere([
                ['komputery.id_dz', '=', NULL],
                ['komputery.status_k', '=', 1],
            ])
            ->orderBy('komputery.dns_k')
            ->get();
    }
    private function getUrzadzeniaToAdd() {
        return DB::table('intranet.urzadzenia as urzadzenia')
        ->where([
            ['status_dev', '=', '1'],
            ['id_dz', '=', 0],
        ])
        ->orWhere([
            ['id_dz', '=', NULL],
            ['status_dev', '=', 1],
        ])
        ->get();
    }
    private Function getDzialKierownikId($id) {
        $dzial = $this->getDzial($id);
        return $dzial->id_uk;
    }
    private Function getParentDzialId($id) {
        $dzial = $this->getDzial($id);
        return $dzial->parent_dz;
    }
    private function getManagersToAdd($id) {
        
        return DB::table('intranet.uzytkownicy as uzytkownicy')
            ->where([
                ['status_u', '=', '1'],
                ['id_u', '!=', $this->getDzialKierownikId($id)],
            ])
            ->get();
    }
    private function getAllActiveUsers() {
        return DB::table('intranet.uzytkownicy as uzytkownicy')
            ->orderBy('nazwa_u', 'asc')
            ->select('nazwa_u','imie_u', 'id_u')
            ->where([
                ['uzytkownicy.status_u', '=', '1'],
            ])
            ->get();
    }
    private function getUsersToAdd() {
        return DB::table('intranet.uzytkownicy as uzytkownicy')
            ->orderBy('nazwa_u', 'asc')
            ->select('nazwa_u','imie_u', 'id_u')
            ->where([
                ['uzytkownicy.status_u', '=', '1'],
                ['uzytkownicy.id_dz', '<', '1'],
            ])
            ->get();
    }
    private function getDzial($id) {
        return DB::table('intranet.dzialy as dzialy')
            ->leftJoin('intranet.uzytkownicy as uzytkownicy', 'uzytkownicy.id_u', '=', 'dzialy.id_uk')
            ->leftJoin('intranet.dzialy as d2', 'dzialy.parent_dz', '=', 'd2.id_dz')
            ->leftJoin('intranet.piony as piony', 'piony.id_p', '=', 'dzialy.id_p')
            ->select('dzialy.*', 
                'd2.id_dz as parentIdDz', 'd2.symbol_d as parentSymbolD', 
                'piony.nazwa_p', 'piony.numer_p',
                'uzytkownicy.id_u', 'uzytkownicy.nazwa_u', 'uzytkownicy.imie_u')
            ->where('dzialy.id_dz', '=', $id)
            ->orderBy('dzialy.symbol_d')
            ->get()
            ->first();
    }
    private function getPossibleParents() {
        return DB::table('intranet.dzialy as dzialy')
            ->where([
                ['parent_dz', '=', 0],
                ['status_dz', '=', 1],
            ])
            ->orWhere([
                ['parent_dz', '=', NULL],
                ['status_dz', '=', 1],
            ])
            ->orderBy('dzialy.symbol_d')
            ->get();
    }
    private function getPossibleManagers() {
        return DB::table('intranet.uzytkownicy')
        ->where([
            ['status_u', '=', '1'],
        ])
        ->orderBy('nazwa_u')
        ->get();
    }
    private function getParentDzialy($id) {
        return DB::table('intranet.dzialy as dzialy')
            ->select('dzialy.*')
            ->where([
                ['dzialy.parent_dz', '=', '0'],
                ['dzialy.id_dz', '!=', $id],
                ['dzialy.id_dz', '!=', $this->getParentDzialId($id) ],
            ])
            ->orderBy('dzialy.symbol_d')
            ->get();
    }
    private function getLogiDzial($id) {
        return DB::table('intranet.historia as historia')
                ->where([
                    ['historia.id_o', '=', $id],
                    ['tabela', '=', 'dzialy'],
                ])
                ->orderBy('id_h', 'desc')
                ->paginate(12);
    }
    private function getPiony() {
        return DB::table('intranet.piony as piony')->get();
    }
    private function getPion($id) {
        return DB::table('intranet.piony as piony')
                ->where([
                    ['id_p', '=', $id],
                ])
                ->get()
                ->first();
    }
    private function getEdit(Request $request) {
        return $request->validate([
            'e' => 'sometimes|in:symbol_d,id_dz,parent_dz,nazwa_d,id_uk,id_p,id_k,dev,u,opwn',
        ]);
    }
    private function getTab(Request $request) {
        return $request->validate([
            'tab' => 'sometimes|in:u,dev,komp,log,wn',
        ]);
    }
    public function show($id, Request $request) {
        $tab = $this->getTab($request);
        $edit =$this->getEdit($request);
        #$dzialy = DB::table('intranet.dzialy')
        #    ->where('status_dz', '=', '1')
        #    ->get();
        
        $dzial = $this->getDzial($id);
            
        if ($tab && $tab['tab'] == 'log') {
            return view('dzialy.show', [
                'tab' => $tab,
                'dzial' => $dzial,
                'logiDzial' => $this->getLogiDzial($id)->withPath($id.'?tab=log'),
                ]);
        }
        elseif ($tab && $tab['tab'] == 'komp') {
            return view('dzialy.show', [
                'kToAdd' => $this->getKomputeryToAdd(),
                'komputeryDzialu' => $this->getKomputeryDzialu($id),
                'dzial' => $dzial,
                'tab' => $tab,
                'e' => $this->getEdit($request),
            ]);
        }
        elseif ($tab && $tab['tab'] == 'dev') {
            return view('dzialy.show', [
                'devToAdd' => $this->getUrzadzeniaToAdd(),
                'urzadzeniaDzialu' => $this->getUrzadzeniaDzialu($id),
                'dzial' => $dzial,
                'tab' => $tab,
                'e' => $this->getEdit($request),
            ]);
        }
        elseif ($tab && $tab['tab'] == 'u') {
            return view('dzialy.show', [
                'uToAdd' => $this->getUsersToAdd(),
                'uzytkownicyDzialu' => $this->getUzytkownicyDzialu($id),
                'dzial' => $dzial,
                'tab' => $tab,
                'e' => $this->getEdit($request),
            ]);
        }
        elseif ($tab && $tab['tab'] == 'wn') {
            return view('dzialy.show', [
                'allUsers' => $this->getAllActiveUsers(),
                'operatorzyWN' => $this->getOperatorzyWnioskow($id),
                'dzial' => $dzial,
                'tab' => $tab,
                'e' => $this->getEdit($request),
            ]);
        }
        else {
            if ($edit) {
                return view('dzialy.show', [
                    'dzial' => $dzial,
                    'ukToAdd' => $this->getManagersToAdd($id),
                    'parentDzialy' => $this->getParentDzialy($id),
                    'piony' => $this->getPiony(), 
                    'tab' => $tab,
                    'e' => $this->getEdit($request),
                ]);
            }
            else {
                return view('dzialy.show', [
                    'dzial' => $dzial,
                ]);
            }
        }
    }
    public function delKomp($id, Request $request) {
        $edit = $request->validate([
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy',
            'id_k' => 'required|numeric|exists:sqlsrv.intranet.komputery',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|string|in:dev,log,komp,u',
        ]);
        $dnr = $request->validate([
            'dnr' => 'sometimes|numeric|in:1',
        ]);
        app('App\Http\Controllers\KomputerController')->disconnectDzial($edit['id_k']);
        return $this->show($id, $request);
    }
    public function addKomp($id, Request $request) {
        $edit = $request->validate([
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy',
            'id_k' => 'required|numeric|exists:sqlsrv.intranet.komputery',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|string|in:dev,log,komp,u',
        ]);
        $addKompArray = [
            'oldProperty' => 'id_dz',
            'id_k' => $edit['id_k'],
            'id_dz' => $edit['id_dz'],
            'tab' => $tab,
            'dnr' => '1',
        
        ];
        $request = new Request($addKompArray);
        app('App\Http\Controllers\KomputerController')->updateOneCol($edit['id_k'], $request);
        
        $request = new Request($addDevArray);
        return $this->show($id, [
            'dzial' => $this->getDzial($edit['id_dz']),
            'komputeryDzialu' => $this->getKomputeryDzialu($edit['id_dz']),
            'tab' => 'komp',
        ]);
        //return redirect()->route('dzialy.show', $id, ['tab' => $tab]);
        //return $this->show($id, $request);
    }
    public function delDev($id, Request $request) {
        $edit = $request->validate([
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy',
            'id_dev' => 'required|numeric|exists:sqlsrv.intranet.urzadzenia',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|string|in:dev,log,komp,u',
        ]);
        $dnr = $request->validate([
            'dnr' => 'sometimes|numeric|in:1',
        ]);
        app('App\Http\Controllers\UrzadzenieController')->disconnectDzial($edit['id_dev']);
        return $this->show($id, $request);
    }
    public function addDev($id, Request $request) {
        $edit = $request->validate([
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy',
            'id_dev' => 'required|numeric|exists:sqlsrv.intranet.urzadzenia',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|string|in:dev,log,komp,u',
        ]);
        $addDevArray = [
            'oldProperty' => 'id_dz',
            'id_dev' => $edit['id_dev'],
            'id_dz' => $edit['id_dz'],
            'tab' => $tab,
            'dnr' => '1',
        ];
        $request = new Request($addDevArray);
        app('App\Http\Controllers\UrzadzenieController')->updateOneCol($edit['id_dev'], $request);
        return view('dzialy.show', [
            'dzial' => $this->getDzial($edit['id_dz']),
            'komputeryDzialu' => $this->getKomputeryDzialu($edit['id_dz']),
            'tab' => 'dev',
        ]);
        return $this->show($id, $request);
    }
    public function delUser($id, Request $request) {
        $edit = $request->validate([
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy',
            'id_u' => 'required|numeric|exists:sqlsrv.intranet.uzytkownicy',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|string|in:dev,log,komp,u',
        ]);
        $dnr = $request->validate([
            'dnr' => 'sometimes|numeric|in:1',
        ]);
        app('App\Http\Controllers\UzytkownikController')->disconnectDzial($edit['id_u']);
        return $this->show($id, $request);
    }
    public function addUser($id, Request $request) {
        $edit = $request->validate([
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy',
            'id_u' => 'required|numeric|exists:sqlsrv.intranet.uzytkownicy',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|string|in:dev,log,komp,u',
        ]);
        $addUserArray = [
            'oldProperty' => 'id_dz',
            'id_u' => $edit['id_u'],
            'id_dz' => $edit['id_dz'],
            'tab' => $tab,
            'dnr' => '1',
        ];
        $request = new Request($addUserArray);
        app('App\Http\Controllers\UzytkownikController')->updateOneCol($edit['id_u'], $request);
        return $this->show($id, $request);
    }
    public function delOperatorWN($id, Request $request) {
        $edit = $request->validate([
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy',
            'id_u' => 'required|numeric|exists:sqlsrv.intranet.uzytkownicy',
            'id_wnu' => 'required|numeric|exists:sqlsrv.intranet.wnioski_operatorzy',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|string|in:dev,log,komp,u,wn',
        ]);
        $dnr = $request->validate([
            'dnr' => 'sometimes|numeric|in:1',
        ]);
        //return $edit['id_wnu'];
        DB::table('intranet.wnioski_operatorzy')->where('wnioski_operatorzy.id_wnu', '=', $edit['id_wnu'])->delete();
        //app('App\Http\Controllers\UzytkownikController')->disconnectDzial($edit['id_u']);
        return $this->show($id, $request);
    }
    public function addOperatorWN($id, Request $request) {
        $edit = $request->validate([
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy',
            'id_u' => 'required|numeric|exists:sqlsrv.intranet.uzytkownicy',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|string|in:dev,log,komp,u,wn',
        ]);
        $addOperatorWNarray = [
            'id_dz' => $edit['id_dz'],
            'tab' => $tab,
            'dnr' => '1',
        ];
        $request = new Request($addOperatorWNarray);
        DB::table('intranet.wnioski_operatorzy')
            ->updateOrInsert(
                ['id_dz' => $edit['id_dz'], 'id_u' => $edit['id_u'],]
        );
        //app('App\Http\Controllers\UzytkownikController')->updateOneCol($edit['id_u'], $request);
        
        return $this->show($id, $request);
    }
    public function updateOneCol($id, Request $request) {
        $validatedData = $request->validate([
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy',
            'symbol_d' => 'sometimes|required|string|max:4|unique:sqlsrv.intranet.dzialy',
            'old_symbol_d' => 'sometimes|nullable',
            'nazwa_d' => 'sometimes|required|string|unique:sqlsrv.intranet.dzialy',
            'old_nazwa_d' => 'sometimes|nullable',
            'id_p' => 'sometimes|required|numeric|in:1,2,3|exists:sqlsrv.intranet.piony',
            'old_id_p' => 'sometimes|nullable',
            'parent_dz' => 'sometimes|nullable|numeric|exists:sqlsrv.intranet.dzialy,id_dz',
            'old_parent_dz' => 'sometimes|nullable',
            'id_uk' => 'sometimes|required|numeric|exists:sqlsrv.intranet.uzytkownicy,id_u',
            'old_id_uk' => 'sometimes|nullable',
            'oldProperty' => 'required|in:symbol_d,nazwa_d,id_p,parent_dz,id_uk',
        ]);

       if ($validatedData['oldProperty'] == 'parent_dz') {
           $parent = Dzial::findOrFail($validatedData['parent_dz']);
           $dzial =  Dzial::findOrFail($validatedData['id_dz']);
           if (array_key_exists('old_parent_dz',$validatedData)) {
               $oldParent = Dzial::findOrFail($validatedData['old_parent_dz']);
               $affectedOld = DB::table('intranet.dzialy')
                   ->where('id_dz', $validatedData['id_dz'])
                   ->update(['parent_dz' => 0]);
               
               $wpis = 'Dział [id_dz] => '.$dzial->id_dz;
               $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
               $wpis .= ' został odłączony z nadrzędnego działu [id_dz] => '.$oldParent->id_dz;
               $wpis .= ', [symbol_d] => '.$oldParent->symbol_d;
               app('App\Http\Controllers\HistoriaController')->store('dzialy', $id, $wpis);
               app('App\Http\Controllers\HistoriaController')->store('dzialy', $oldParent->id_dz, $wpis);
           }
           if (!array_key_exists('old_parent_dz',$validatedData) || $validatedData['parent_dz'] != $validatedData['id_dz']) {    
               $affected = DB::table('intranet.dzialy')
                   ->where('id_dz', $validatedData['id_dz'])
                   ->update(['parent_dz' => $validatedData['parent_dz']]);
                $wpis = 'Dział [id_dz] => '.$dzial->id_dz;
                $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
                $wpis .= ' został dołączony jako sekcja do działu nadrzędnego [id_dz] => '.$parent->id_dz;
                $wpis .= ', [symbol_d] => '.$parent->symbol_d;
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $parent->id_dz, $wpis);
               }
               return $this->show($id, $request);
           }
           elseif ($validatedData['oldProperty'] == 'id_k') {
           $Komp = Komputer::findOrFail($validatedData['id_k']);
           $urzadzenie =  urzadzenie::findOrFail($validatedData['id_dev']);
           if (array_key_exists('old_id_k',$validatedData)) {
               $oldKomp = Komputer::findOrFail($validatedData['old_id_k']);
               $affectedOld = DB::table('intranet.dzialy')
                   ->where('id_dev', $validatedData['id_dev'])
                   ->update(['id_k' => NULL]);
               
               $wpis = 'Od komputera [dns_k] => '.$oldKomp->dns_k.', [id_k] => '.$oldKomp->id_k;
               $wpis .= ', [model_k] => '.$oldKomp->model_k;
               $wpis .= ', [inwent_k] => '.$oldKomp->inwent_k;
               $wpis .= ', [serial_k] => '.$oldKomp->serial_k;
               $wpis .= ' odłączono urzadzenie [model_dev] => '.$urzadzenie->model_dev.'';
               $wpis .= ', [id_dev] => '.$urzadzenie->id_dev;
               $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
               $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
               app('App\Http\Controllers\HistoriaController')->store('dzialy', $id, $wpis);
               app('App\Http\Controllers\HistoriaController')->store('komputery', $oldKomp->id_k, $wpis);
           }
           if (!array_key_exists('old_id_k',$validatedData) || $validatedData['id_k'] != $validatedData['old_id_k']) {    
               $affected = DB::table('intranet.dzialy')
                   ->where('id_dev', $validatedData['id_dev'])
                   ->update(['id_k' => $validatedData['id_k']]);
               $wpis = 'Do komputera [dns_k] => '.$Komp->dns_k.', [id_k] => '.$id;
               $wpis .= ', [model_k] => '.$Komp->model_k;
               $wpis .= ', [inwent_k] => '.$Komp->inwent_k;
               $wpis .= ', [serial_k] => '.$Komp->serial_k;
               $wpis .= ' przypisano urzadzenie [model_dev] => '.$urzadzenie->model_dev;
               $wpis .= ', [id_dev] => '.$urzadzenie->id_dev;
               $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
               $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
               app('App\Http\Controllers\HistoriaController')->store('dzialy', $id, $wpis);
               app('App\Http\Controllers\HistoriaController')->store('komputery', $Komp->id_k, $wpis);
           }
           return $this->show($id, $request);
       }
       elseif ($validatedData['oldProperty'] == 'id_uk') {
        $kierownik = Uzytkownik::findOrFail($validatedData['id_uk']);
        $dzial =  Dzial::findOrFail($validatedData['id_dz']);
        if (array_key_exists('old_id_uk',$validatedData)) {
            $oldKierownik = Uzytkownik::findOrFail($validatedData['old_id_uk']);
            $affectedOld = DB::table('intranet.dzialy')
                ->where('id_dz', $validatedData['id_dz'])
                ->update(['id_uk' => 0]);
            
            $wpis = 'Usunięto kierownika [id_u] => '.$oldKierownik->id_uk;
            $wpis .= ' ('.$oldKierownik->nazwa_u.' '.$oldKierownik->imie_u.')';
            $wpis .= ' z działu [id_dz] => '.$dzial->id_dz;
            $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
            app('App\Http\Controllers\HistoriaController')->store('dzialy', $id, $wpis);
            app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $oldKierownik->id_u, $wpis);
        }
        if (!array_key_exists('old_id_uk',$validatedData) || $validatedData['id_uk'] != $validatedData['old_id_uk']) {    
            $affected = DB::table('intranet.dzialy')
                ->where('id_dz', $validatedData['id_dz'])
                ->update(['id_uk' => $validatedData['id_uk']]);
             $wpis = 'Użytkownik [id_u] => '.$validatedData['id_uk'];
             $wpis .= ' ('.$kierownik->nazwa_u.' '.$kierownik->imie_u.')';
             $wpis .= ' został dodany jako kierownik działu [id_dz] => '.$validatedData['id_dz'];
             $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
             app('App\Http\Controllers\HistoriaController')->store('dzialy', $id, $wpis);
             app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $kierownik->id_u, $wpis);
            }
            return $this->show($id, $request);
        }
        elseif ($validatedData['oldProperty'] == 'id_p') {
            $pion = DB::table('intranet.piony as piony')->where('id_p', '=', $validatedData['id_p'])->get()->first();
            $oldPion = DB::table('intranet.piony as piony')->where('id_p', '=', $validatedData['old_id_p'])->get()->first();
            $dzial =  Dzial::findOrFail($validatedData['id_dz']);
            if ($validatedData['id_p'] != $validatedData['old_id_p']) {    
                $affected = DB::table('intranet.dzialy')
                    ->where('id_dz', $validatedData['id_dz'])
                    ->update(['id_p' => $validatedData['id_p']]);
                 $wpis = 'Zmieniono pion działu [id_dz] => '.$validatedData['id_dz'];
                 $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
                 $wpis .= ', [id_p] '.$pion->id_p.' => '.$oldPion->id_p;
                 $wpis .= ', ('.$pion->nazwa_p.' => '.$oldPion->nazwa_p.')';
                 app('App\Http\Controllers\HistoriaController')->store('dzialy', $id, $wpis);
                 app('App\Http\Controllers\HistoriaController')->store('piony', $pion->id_p, $wpis);
                 app('App\Http\Controllers\HistoriaController')->store('piony', $oldPion->id_p, $wpis);
                }
                return $this->show($id, $request);
            }
        
        else{
            $dzial =  Dzial::findOrFail($validatedData['id_dz']);
            $affected = DB::table('intranet.dzialy')
                ->where('id_dz', $validatedData['id_dz'])
                ->update([$validatedData['oldProperty'] => $validatedData[$validatedData['oldProperty']]]);
            $wpis = 'Zmieniono ['.$validatedData['oldProperty'].'] działu [id_dz] => '.$dzial->id_dz;
            $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
            $wpis .= ' ('.$dzial[$validatedData['oldProperty']].' =>  '.$validatedData[$validatedData['oldProperty']].')' ;
            app('App\Http\Controllers\HistoriaController')->store('dzialy', $id, $wpis);
            
            return $this->show($id, $request);
        }
    }
    public function add() {
        return view('dzialy.add', [
            'piony' => $this->getPiony(),
            'parents' => $this->getPossibleParents(),
            'managers' => $this->getPossibleManagers(),
            ]);
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nazwa_d' => 'required|string|max:50|unique:sqlsrv.intranet.dzialy',
            'symbol_d' => 'required|string|max:5|unique:sqlsrv.intranet.dzialy',
            'id_p' => 'required|numeric|exists:sqlsrv.intranet.piony',
            'parent_dz' => 'nullable|numeric|exists:sqlsrv.intranet.dzialy,id_dz',
            'id_uk' => 'required|numeric|exists:sqlsrv.intranet.uzytkownicy,id_u',
        ]);
        
        $dzial = new Dzial();
        $dzial->nazwa_d = $validatedData['nazwa_d'];
        $dzial->symbol_d = $validatedData['symbol_d'];
        $dzial->id_p = $validatedData['id_p'];
        $dzial->id_uk = $validatedData['id_uk'];
        $dzial->parent_dz = $validatedData['parent_dz'];
        if (request('parent_dz') == NULL) $dzial->parent_dz = 0;
        if($dzial->save()) {
            $kierownik = app('App\Http\Controllers\UzytkownikController')->getUzytkownik($dzial->id_uk);
            $pion = $this->getPion($dzial->id_p);
            if ($dzial->parent_dz > 0) {
                $parent = $this->getDzial($dzial->parent_dz);
            
                $wpis = 'Dział [id_dz] => '.$dzial->id_dz;
                $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
                $wpis .= ' został dołączony jako sekcja do działu nadrzędnego [id_dz] => '.$parent->id_dz;
                $wpis .= ', [symbol_d] => '.$parent->symbol_d;
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $parent->id_dz, $wpis);
           }
            $wpis = 'Dodano nowy dział [id_dz] => '.$dzial->id_dz;
            $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
            $wpis .= ', [nazwa_d] => '.$dzial->nazwa_d;
            $wpis .= ', [id_p] => '.$dzial->id_p.' ('.$pion->nazwa_p.')';
            if ($dzial->parent_dz > 0) {
                $wpis .= ', [parent_dz] => '.$dzial->parent_dz.' ([symbol_d] => '.$parent->symbol_d.')';
            }
            $wpis .= ', [id_uk] => '.$dzial->id_uk.' ('.$kierownik->nazwa_u.' '.$kierownik->imie_u.')';
            app('App\Http\Controllers\HistoriaController')->store('dzialy', $dzial->id_dz, $wpis);

            $wpis = 'Użytkownik [id_u] => '.$dzial->id_uk;
            $wpis .= ' ('.$kierownik->nazwa_u.' '.$kierownik->imie_u.')';
            $wpis .= ' został dodano jako kierownik działu [id_dz] => '.$dzial->id_dz;
            $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
            app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $kierownik->id_u, $wpis);
            
            return $this->show($dzial->id_dz, $request);
        }
    }
    public function disable($id) {
        $dzial = Dzial::findOrFail($id);
        $affected = DB::table('intranet.dzialy')
            ->where('id_dz', $id)
            ->update(['status_dz' => 0,]);
        
        $wpis = 'Dzial [id_dz] => '.$dzial->id_dz.', [symbol_d] => '.$dzial->symbol_d.', [nazwa_d] => '.$dzial->nazwa_d;
        $wpis .= ' został oznaczony jako usunięty';
        app('App\Http\Controllers\HistoriaController')->store('dzialy', $id, $wpis);
        return redirect()->route('dzialy.index', ['active' => 0]);
        //return redirect('{{/programy}}?active=0');
    }
    
    //public function add() {
    //   $dzialy = 
    //    return view('komputery.add');
   // }
}
