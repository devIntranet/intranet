<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

use Auth;

use App\Komputer;
use App\Dzial;
use App\Uzytkownik;
use App\Rules\Lowercase;


class UzytkownikController extends Controller
{
    public function index() {
       //$komputery = Komputer::all();
       $sortable = ['nazwa_u', 'imie_u', 'loginad_u', 'dns_k', 'symbol_d', 'id_k', 'id_dz',];
       $order='nazwa_u';
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
       $uzytkownicy = DB::table('intranet.uzytkownicy as u')
           ->leftJoin('intranet.komputery as k', 'k.id_u', '=', 'u.id_u')
           ->leftJoin('intranet.dzialy as d', 'u.id_dz', '=', 'd.id_dz')
           ->select('u.*', 
               'k.id_k', 'k.dns_k', 
               'd.symbol_d') 
           ->where([['u.status_u', '=', $active],])
           ->orderBy($order, $direction)
           ->get();
       return view('uzytkownicy.index', ['uzytkownicy' => $uzytkownicy]);
    }
    public function show($id, Request $request) {
        $tab = $request->validate([
            'tab' => 'sometimes|in:log',
        ]);
        $uzytkownik = DB::table('intranet.uzytkownicy as u')
            ->leftJoin('intranet.komputery as k', 'k.id_u', '=', 'u.id_u')
            ->leftJoin('intranet.dzialy as d','d.id_dz', '=', 'u.id_dz')
            ->select('u.*', 
                'k.id_k', 'k.dns_k', 'k.id_dz as id_kompIdDz',
                'd.symbol_d',)
            ->where('u.id_u',$id)
            ->get()
            ->first();

        if ($tab && $tab['tab'] == 'log') {
            $logiUzytkownik = DB::table('intranet.historia as historia')
                ->where([
                    ['historia.id_o', '=', $id],
                    ['tabela', '=', 'uzytkownicy'],
                ])
                ->orderBy('id_h', 'desc')
                ->paginate(12);
            $logiUzytkownik->withPath($id.'?tab=log');
            return view('uzytkownicy.show', [
                'tab' => $tab, 
                'uzytkownik' => $uzytkownik,
                'logiUzytkownik' => $logiUzytkownik,
                ]);
        }

        else {
            $edit = $request->validate([
                'e' => 'sometimes|in:nazwa_u,imie_u,loginad_u,id_dz,id_k',
            ]);
            //if ($edit) return $edit;
            
            $komputery = DB::table('intranet.komputery as komputery')
                ->where([['status_k', '>', 0], ['id_u', '=', NULL]])
                ->orderBy('dns_k', 'asc')
                ->get();
            $dzialy = DB::table('intranet.dzialy as dzialy')
                ->where('status_dz', '>', 0)
                ->orderBy('symbol_d', 'asc')
                ->get();
            
            return view('uzytkownicy.show', [
                'uzytkownik' => $uzytkownik,
                'komputery' => $komputery,
                'dzialy' => $dzialy,
                'tab' => $tab,
                'e' => $edit,
            ]);
        }
    }
    public function add() {
            $dzialy = Dzial::orderBy('symbol_d')->get();
            return view('uzytkownicy.add', [
                'dzialy' => $dzialy,
                ]);
    }
    public function getUzytkownik($id) {
        return Uzytkownik::findOrFail($id);
    }
    public function updateOneCol($id, Request $request) {
        //return $request;
        $validatedData = $request->validate([
            'id_u' => 'required|numeric|exists:sqlsrv.intranet.uzytkownicy',
            'nazwa_u' => 'sometimes|required|string|max:30',
            'old_nazwa_u' => 'sometimes|nullable',
            'imie_u' => 'sometimes|required|string|max:30',
            'old_imie_u' => 'sometimes|nullable',
            'loginad_u' => ['sometimes','required','string','max:20',new Lowercase,'unique:sqlsrv.intranet.uzytkownicy'],
            'old_loginad_u' => 'sometimes|nullable',
            'id_dz' => 'sometimes|required|numeric|exists:sqlsrv.intranet.dzialy',
            'old_id_dz' => 'sometimes|nullable',
            'id_k' => 'sometimes|nullable|numeric|exists:sqlsrv.intranet.komputery',
            'old_id_k' => 'sometimes|nullable',
            'oldProperty' => 'required|in:nazwa_u,imie_u,loginad_u,id_dz,id_k'
        ]);

        $uzytkownik =  Uzytkownik::findOrFail($validatedData['id_u']);
        
        if ($validatedData['oldProperty'] == 'id_k') {
            if (isset($validatedData['old_id_k'])) app('App\Http\Controllers\KomputerController')->disconnectUser($validatedData['old_id_k']);
            if ((!isset($validatedData['old_id_k'])) || $validatedData['old_id_k'] != $validatedData['id_k']) {
                $kompSetUser = [
                    'id_u' => $validatedData['id_u'], 
                    'id_k' => $validatedData['id_k'],
                    'oldProperty' => 'id_u',
                    'dnr' => '1',
                ];
                $request = new Request($kompSetUser);   
                app('App\Http\Controllers\KomputerController')->updateOneCol($validatedData['id_k'], $request);
            } 
        }
        else {
            $affected = DB::table('intranet.uzytkownicy')
                ->where('id_u', $validatedData['id_u'])
                ->update([$validatedData['oldProperty'] => $validatedData[$validatedData['oldProperty']]]);
            $wpis = 'Zmieniono ['.$validatedData['oldProperty'].'] użytkownika [id_u] => '.$uzytkownik->id_u;
            $wpis .= ' ('.$uzytkownik[$validatedData['oldProperty']].' =>  '.$validatedData[$validatedData['oldProperty']].')' ;
            app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $id, $wpis);
        }
        if (!Arr::exists($validatedData, 'dnr')) {
            return $this->show($id, $request);
        }
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nazwa_u' => 'required|string|max:30',
            'imie_u' => 'required|string|max:20',
            'loginad_u' => ['sometimes','required','string','max:20',new Lowercase,'unique:sqlsrv.intranet.uzytkownicy'],
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy,id_dz',
        ]);
        
         
         $uzytkownik = new uzytkownik();
         $uzytkownik->nazwa_u = request('nazwa_u');
         $uzytkownik->imie_u = request('imie_u');
         $uzytkownik->loginad_u = request('loginad_u');
         $uzytkownik->id_dz = request('id_dz');
 
         if($uzytkownik->save()) {
            $dzial = Dzial::findOrFail($validatedData['id_dz']);
            
            $wpis = 'Dodano nowego użytkownika: [id_u] => '.$uzytkownik->id_u;
            $wpis .= ', [nazwa_u] => '.$uzytkownik->nazwa_u;
            $wpis .= ', [imie_u] => '.$uzytkownik->imie_u;
            $wpis .= ', [loginad_u] => '.$uzytkownik->loginad_u;
            $wpis .= ', [id_dz] => '.$uzytkownik->id_dz.' ( '.$dzial['symbol_d'].' )';
            app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $uzytkownik->id_u, $wpis);

            $wpis = 'Do działu [id_dz] => '.$uzytkownik->id_dz;
            $wpis .= ', [symbol_d] => '.$dzial['symbol_d'];
            $wpis .= ' dodano nowego uzytkownika [id_u] => '.$uzytkownik->id_u;
            $wpis .= ', [nazwa_u] => '.$uzytkownik->nazwa_u;
            $wpis .= ', [imie_u] => '.$uzytkownik->imie_u;
            $wpis .= ', [loginad_u] => '.$uzytkownik->loginad_u;
            app('App\Http\Controllers\HistoriaController')->store('dzialy', $uzytkownik->id_dz, $wpis);
        }
         return $this->show($uzytkownik->id_u, $request);
    }
    public function disable($id) {
        $uzytkownik = Uzytkownik::findOrFail($id);
        $affected = DB::table('intranet.uzytkownicy')
            ->where('id_u', $id)
            ->update(['status_u' => 0,]);
        
        $wpis = 'Użytkownik [id_u] => '.$uzytkownik->id_u.' ('.$uzytkownik->nazwa_u.' '.$uzytkownik->imie_u.')';
        $wpis .= ' został oznaczony jako usunięty';
        app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $id, $wpis);
        return redirect()->route('uzytkownicy.index', ['active' => '0']);
    }
    public function activate($id) {
        $uzytkownik = Uzytkownik::findOrFail($id);
        $affected = DB::table('intranet.uzytkownicy')
            ->where('id_u', $id)
            ->update(['status_u' => 1,]);
        
        $wpis = 'Użytkownik [id_u] => '.$uzytkownik->id_u.' ('.$uzytkownik->nazwa_u.' '.$uzytkownik->imie_u.')';
        $wpis .= ' został ponownie aktywowany.';
        app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $id, $wpis);
        return redirect()->route('uzytkownicy.index', ['active' => '1']);
    }
    public function disconnectDzial($id) {
        $user = Uzytkownik::findOrFail($id); 
        if ($user->id_dz >0) {
            if ($dzial = Dzial::find($user->id_dz)) {
                DB::table('intranet.uzytkownicy')
                    ->updateOrInsert(   
                    ['id_u' => $id],
                    ['id_dz' => null]);
                $wpis = 'Z działu [id_dz] => '.$dzial->id_dz;
                $wpis .= ', [symbol_d] => '.$dzial->symbol_d;
                $wpis .= ' usunięto użytkownika [id_u] => '.$user->id_u;
                $wpis .= ' ('.$user->nazwa_u.' '.$user->imie_u.')';
                app('App\Http\Controllers\HistoriaController')->store('uzytkownicy', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $dzial->id_dz, $wpis);
            }
        }
    }
}
