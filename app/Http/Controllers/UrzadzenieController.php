<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use Auth;

use App\Urzadzenie;
use App\Komputer;
use App\Dzial;
use App\Uzytkownik;
use App\Ot;
use App\Fw;

class UrzadzenieController extends Controller
{
    public function index() {
        $sortable = ['inwent_dev', 'nazwa_dev', 'serial_dev', 'model_dev', 'typ_dev', 'id_dz'];
        $order='inwent_dev';
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
        $urzadzenia = DB::table('intranet.urzadzenia as urzadzenia')
            ->leftJoin('intranet.komputery as komputery', 'komputery.id_k', '=', 'urzadzenia.id_k')
            ->leftJoin('intranet.dzialy as dzialy', 'urzadzenia.id_dz', '=', 'dzialy.id_dz')
            ->select('urzadzenia.*', 
                'komputery.id_k as kompIdK', 'komputery.dns_k', 'komputery.inwent_k',
                'dzialy.symbol_d') 
            ->where([['urzadzenia.status_dev', '=', $active],])
            ->orderBy($order, $direction)
            ->get();
        return view('urzadzenia.index', ['urzadzenia' => $urzadzenia]);
    }
    public function show($id, Request $request) {
        $edit = $request->validate([
            'e' => 'sometimes|in:nazwa,inwent,typ,ip,serial,data,model,komp,dzial,delip',
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
        $dzialy = Dzial::orderBy('symbol_d')->get();
        $komputery = Komputer::orderBy('dns_k')->get();
        $otki = Ot::orderBy('nr_ot')->get();
        $faktury = Fw::orderBy('nr_fw')->get();
                 
        $urzadzenie = DB::table('intranet.urzadzenia as urzadzenia')
            ->leftJoin('intranet.komputery as komputery','urzadzenia.id_k', '=', 'komputery.id_k')
            ->leftJoin('intranet.dzialy as dzialy','dzialy.id_dz', '=', 'urzadzenia.id_dz')
            ->leftJoin('intranet.ot as ot','ot.nr_inwent', '=', 'urzadzenia.inwent_dev')
            ->leftJoin('intranet.fw as fw','ot.id_fw', '=', 'fw.id_fw')
            ->select('urzadzenia.*', 'dzialy.symbol_d', 'komputery.id_dz AS kompIdDz', 'komputery.dns_k',
            'ot.id_ot', 'ot.nr_ot', 'fw.id_fw', 'fw.nr_fw', )
            ->where('urzadzenia.id_dev',$id)
            ->get()
            ->first();
        //return $urzadzenie;
         
        if ($tab && $tab['tab'] == 'log') {
            $logiUrzadzenie = DB::table('intranet.historia as historia')
                ->where([
                    ['historia.id_o', '=', $id],
                    ['tabela', '=', 'urzadzenia'],
                ])
                ->orderBy('id_h', 'desc')
                ->paginate(12);
                 
            $logiUrzadzenie->withPath($id.'?tab=log');
            return view('urzadzenia.show', [
                'tab' => $tab, 
                'urzadzenie' => $urzadzenie,
                'logiUrzadzenie' => $logiUrzadzenie,
                ]);
        }
        elseif ($tab && $tab['tab'] == 'st') {
            //$ot = $this->getOtFile($komp->id_ot);
            return view('urzadzenia.show', [
                'tab' => $tab, 
                'urzadzenie' => $urzadzenie,
                'otki' => $otki,
                'faktury' => $faktury,
                'e' => $edit,
                ]);
        }
        else {
            if ($edit && $edit['e'] == 'delip' && $urzadzenie->ip_dev != NULL) {
                $this->clearField($id, 'ip_dev');
                $urzadzenie->ip_dev = NULL;
            }
            return view('urzadzenia.show', [
                'e' => $edit,
                'tab' => $tab, 
                'urzadzenie' => $urzadzenie,
                'dzialy' => $dzialy,
                'komputery' => $komputery,
                ]);
        }
    }
 
    public function add() {
        $komputery = Komputer::orderBy('dns_k')->get();
        $dzialy = Dzial::orderBy('symbol_d')->get();
        return view('urzadzenia.add', [
            'komputery' => $komputery,
            'dzialy' => $dzialy,
            ]);
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nazwa_dev' => 'required|string|max:30',
            'model_dev' => 'required|string|max:30',
            'typ_dev' => 'required|string|in:drukarka,skaner,switch,router,biblioteka,inne',
            'inwent_dev' => 'required|numeric|digits:4|unique:sqlsrv.intraneturzadzenia',
            'serial_dev' => 'required|unique:sqlsrv.intraneturzadzenia|max:30',
            'ip_dev' => 'nullable|ipv4|unique:sqlsrv.intraneturzadzenia,ip_dev',
            'data_dev' => 'required|date|before:tomorrow',
            'id_k' => 'nullable|numeric|exists:sqlsrv.intranet.komputery,id_k',
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy,id_dz',
        ]);
        $urzadzenie = new urzadzenie();
        $urzadzenie->nazwa_dev = request('nazwa_dev');
        $urzadzenie->model_dev = request('model_dev');
        $urzadzenie->inwent_dev = request('inwent_dev');
        $urzadzenie->serial_dev = request('serial_dev');
        $urzadzenie->typ_dev = request('typ_dev');
        #if (request('ip_dev') == NULL) $urzadzenie->ip_dev = NULL;
        #else 
        $urzadzenie->ip_dev = request('ip_dev');
        $urzadzenie->data_dev = request('data_dev');
        if (request('id_k') == NULL) $urzadzenie->id_k = 0;
        else $urzadzenie->id_k = request('id_k');
        $urzadzenie->id_dz = request('id_dz');

        if($urzadzenie->save()) {
            if ($urzadzenie->id_k > 0) $komputer = Komputer::findOrFail($validatedData['id_k']);
            $dzial = Dzial::findOrFail($validatedData['id_dz']);
            
            $wpis = 'Dodano nowe urządzenie: [id_dev] => '.$urzadzenie->id_dev;
            $wpis .= ', [model_dev] => '.$urzadzenie->model_dev;
            $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
            $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
            if ($urzadzenie->ip_dev != NULL ) $wpis .= ', [ip_dev] => '.$urzadzenie->ip_dev;
            $wpis .= ', [data_dev] => '.$urzadzenie->data_dev;
            if ($urzadzenie->id_k > 0) $wpis .= ', [id_k] => '.$urzadzenie->id_k.' ( '.$komputer['dns_k'].' )'; 
            $wpis .= ', [id_dz] => '.$urzadzenie->id_dz.' ( '.$dzial['symbol_d'].' )';
            app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $urzadzenie->id_dev, $wpis);

            $wpis = 'Do działu [id_dz] => '.$urzadzenie->id_dz;
            $wpis .= ', [symbol_d] => '.$dzial['symbol_d'];
            $wpis .= ' dodano nowe urzadzenie [id_dev] => '.$urzadzenie->id_dev;
            $wpis .= ', [model_dev] => '.$urzadzenie->model_dev;
            $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
            $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
            if ($urzadzenie->ip_dev != NULL ) $wpis .= ', [ip_dev] => '.$urzadzenie->ip_dev;
            $wpis .= ', [data_dev] => '.$urzadzenie->data_dev;
            app('App\Http\Controllers\HistoriaController')->store('dzialy', $urzadzenie->id_dz, $wpis);

            if ($urzadzenie->id_k > 0) {
                $wpis = 'Do kommputera [id_k] =>'.$urzadzenie->id_k;
                $wpis .= ', [dns_k] => '.$komputer['dns_k'];
                $wpis .= ', [inwent_k] => '.$komputer['inwent_k'];
                $wpis .= ', [ip_k] => '.$komputer['ip_k'];
                $wpis .= ' dodano nowy urzadzenie [id_dev] => '.$urzadzenie->id_dev;
                $wpis .= ', [model_dev] => '.$urzadzenie->model_dev;
                $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
                $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
                if ($urzadzenie->ip_dev != NULL ) $wpis .= ', [ip_dev] => '.$urzadzenie->ip_dev;
                $wpis .= ', [data_dev] => '.$urzadzenie->data_dev;
                app('App\Http\Controllers\HistoriaController')->store('komputery', $urzadzenie->id_k, $wpis);        
            }
        }
        return $this->show($urzadzenie->id_dev, $request);
    }
    public function updateOneCol($id, Request $request) {
         $validatedData = $request->validate([
             'id_dev' => 'required|numeric|exists:sqlsrv.intranet.urzadzenia',
             'id_dz' => 'sometimes|nullable|numeric|exists:sqlsrv.intranet.dzialy',
             'old_id_dz' => 'sometimes|nullable|numeric',
             'id_k' => 'sometimes|nullable|numeric|exists:sqlsrv.intranet.komputery',
             'old_id_k' => 'sometimes|nullable|numeric',
             'inwent_dev' => 'sometimes|required|numeric|digits:4|unique:sqlsrv.intraneturzadzenia',
             'old_inwent_dev' => 'sometimes|nullable',
             'ip_dev' => 'sometimes|nullable|ipv4|unique:sqlsrv.intraneturzadzenia',
             'old_ip_dev' => 'sometimes|nullable',
             'model_dev' => 'sometimes|required|string|max:50',
             'old_model_dev' => 'sometimes|nullable',
             'nazwa_dev' => 'sometimes|required|string|max:50',
             'old_nazwa_dev' => 'sometimes|nullable',
             'serial_dev' => 'sometimes|required|string|unique:sqlsrv.intraneturzadzenia|max:50',
             'old_serial_dev' => 'sometimes|nullable',
             'typ_dev' => 'sometimes|required|string|in:drukarka,skaner,switch,router,biblioteka,inne',
             'old_typ_dev' => 'sometimes|nullable',
             'data_dev' => 'sometimes|required|date|before:tomorrow',
             'old_data_dev' => 'sometimes|nullable',
             'oldProperty' => 'required|in:nazwa_dev,model_dev,inwent_dev,serial_dev,typ_dev,ip_dev,data_dev,id_dz,id_k'
         ]);
 
        if ($validatedData['oldProperty'] == 'id_dz') {
            $Dzial = Dzial::findOrFail($validatedData['id_dz']);
            $urzadzenie =  Urzadzenie::findOrFail($validatedData['id_dev']);
            if (array_key_exists('old_id_dz',$validatedData)) {
                $oldDzial = Dzial::findOrFail($validatedData['old_id_dz']);
                $affectedOld = DB::table('intranet.urzadzenia')
                    ->where('id_dev', $validatedData['id_dev'])
                    ->update(['id_dz' => 0]);
                
                $wpis = 'Urzadzenie [model_dev] => '.$urzadzenie->model_dev;
                $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
                $wpis .= ', [id_dev] => '.$urzadzenie->id_dev;
                $wpis .= ' usunięto z działu [symbol_d] => '.$oldDzial->symbol_d.', [id_dz] => '.$oldDzial->id_dz;
                app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $oldDzial->id_dz, $wpis);
            }
            if (!array_key_exists('old_id_dz',$validatedData) || $validatedData['id_dz'] != $validatedData['old_id_dz']) {    
                $affected = DB::table('intranet.urzadzenia')
                    ->where('id_dev', $validatedData['id_dev'])
                    ->update(['id_dz' => $validatedData['id_dz']]);
                $wpis = 'Urzadzenie [model_dev] => '.$urzadzenie->model_dev;
                $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
                $wpis .= ', [id_dev] => '.$urzadzenie->id_dev.'';
                $wpis .= ' został dodany do działu [sumbol_d] => '.$Dzial->symbol_d.', [id_dz] => '.$Dzial->id_dz;
                app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $Dzial->id_dz, $wpis);
                }
                return $this->show($id, $request);
            }
            elseif ($validatedData['oldProperty'] == 'id_k') {
            $Komp = Komputer::findOrFail($validatedData['id_k']);
            $urzadzenie =  urzadzenie::findOrFail($validatedData['id_dev']);
            if (array_key_exists('old_id_k',$validatedData)) {
                $oldKomp = Komputer::findOrFail($validatedData['old_id_k']);
                $affectedOld = DB::table('intranet.urzadzenia')
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
                app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $oldKomp->id_k, $wpis);
            }
            if (!array_key_exists('old_id_k',$validatedData) || $validatedData['id_k'] != $validatedData['old_id_k']) {    
                $affected = DB::table('intranet.urzadzenia')
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
                app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $Komp->id_k, $wpis);
            }
            return $this->show($id, $request);
        }
        else{
            $urzadzenie =  urzadzenie::findOrFail($validatedData['id_dev']);
            $affected = DB::table('intranet.urzadzenia')
                ->where('id_dev', $validatedData['id_dev'])
                ->update([$validatedData['oldProperty'] => $validatedData[$validatedData['oldProperty']]]);
            $wpis = 'Zmieniono ['.$validatedData['oldProperty'].'] urzadzeniea [id_dev] => '.$urzadzenie->id_dev;
            $wpis .= ' ('.$urzadzenie[$validatedData['oldProperty']].' =>  '.$validatedData[$validatedData['oldProperty']].')' ;
            app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
            
            return $this->show($id, $request);
            }
            $uzytkownicy = Uzytkownik::orderBy('nazwa_u')->get();
            $urzadzenie = DB::table('intranet.komputery as komputery')
                ->leftJoin('intranet.dzialy as dzialy','dzialy.id_dz', '=', 'komputery.id_dz')
                ->leftJoin('intranet.urzadzenia as urzadzenia', 'komputery.id_k', '=', 'urzadzenia.id_k')
                ->leftJoin('intranet.upsy as upsy','upsy.id_k', '=', 'komputery.id_k')
                //->select('komputery.*', 'uzytkownicy.id_u', 'uzytkownicy.nazwa_u', 'uzytkownicy.imie_u', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d', 'uzytkownicy.id_dz AS userIdDz')
                ->select('komputery.*', 'uzytkownicy.*', 'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d', 'uzytkownicy.id_dz AS userIdDz', 'urzadzenia.id_dev', 'urzadzenia.model_dev', 'upsy.id_ups', 'upsy.model_ups', 'upsy.inwent_ups')
                ->where('komputery.id_k',$id)
                ->get()
                ->first();
            
            if (!Arr::exists($validatedData, 'dnr')) {
                return view('urzadzenia.show', [
                    'urzadzenia' => $urzadzenia,
                ]);
            }
    }
    public function clearField($id, $field) {
        $urzadzenie = Urzadzenie::findOrFail($id); 
        DB::table('intranet.urzadzenia')
            ->updateOrInsert(   
                ['id_dev' => $id],
                [$field => null]);
        $wpis = 'Dla urządzenie [id_dev] => '.$urzadzenie->id_dev.', [typ_dev] => '.$urzadzenie->typ_dev;
        $wpis.= ', [nazwa_dev] => '.$urzadzenie->nazwa_dev;
        $wpis .=', [model_dev] => '.$urzadzenie->model_dev;
        $wpis .= ', [serial_dev] => '.$urzadzenie->serial_dev;
        $wpis .= ' usunięto wartość ['.$field.'] => '.$urzadzenie->$field;
        app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
    } 
    public function disable($id) {
        
        $this->disconnectDzial($id);
        $this->disconnectKomp($id);
        ### END ODŁACZANIE UŻYTKOWNIKA I DZIAŁU ###
        $urzadzenie = urzadzenie::findOrFail($id);
        $affected = DB::table('intranet.urzadzenia')
            ->where('id_dev', $id)
            ->update(['status_dev' => 0,]);
        
        $wpis = 'Urzadzenie [id_dev] => '.$urzadzenie->id_dev;
        $wpis .= ', [model_dev] => '.$urzadzenie->model_dev;
        $wpis .= ', [typ_dev] => '.$urzadzenie->ip_dev;
        $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
        $wpis .= ' zostało oznaczone jako usunięte';
        app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
        return redirect('/urzadzenia?active=0');
    }
    public function activate($id) {
        $urzadzenie = urzadzenie::findOrFail($id);
        $affected = DB::table('intranet.urzadzenia')
            ->where('id_dev', $id)
            ->update(['status_dev' => 1]);
        $wpis = 'Urzadzenie [id_dev] => '.$urzadzenie->id_dev;
        $wpis .= ', [model_dev] => '.$urzadzenie->model_dev;
        $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
        $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
        $wpis .= ' zostało ponownie aktywowane.';
        app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
        return redirect('/urzadzenia');
    }
    public function disconnectDzial($id) {
        $urzadzenie = urzadzenie::findOrFail($id); 
        if ($urzadzenie->id_dz > 0) {
            if ($dzial = Dzial::find($urzadzenie->id_dz)) {
                DB::table('intranet.urzadzenia')
                    ->updateOrInsert(   
                    ['id_dev' => $id],
                    ['id_dz' => 0]);
                $wpis = 'Urzadzenie [id_dev] => '.$urzadzenie->id_dev;
                $wpis .= ', [model_dev] => '.$urzadzenie->model_dev;
                $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
                $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
                $wpis .= ' zostało odłączone od działu [id_dz] => '.$dzial->id_dz.', [symbol_d] => '.$dzial->symbol_d;
                app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('dzialy', $dzial->id_dz, $wpis);
            }
        }
    }
    public function disconnectKomp($id) {
        $urzadzenie = urzadzenie::findOrFail($id); 
        if ($urzadzenie->id_k > 0) {
            if ($komp = Komputer::find($urzadzenie->id_k)) {
                DB::table('intranet.urzadzenia')
                    ->updateOrInsert(   
                    ['id_dev' => $id],
                    ['id_k' => 0]);
                $wpis = 'Urzadzenie [id_dev] => '.$urzadzenie->id_dev;
                $wpis .= ', [model_dev] => '.$urzadzenie->model_dev;
                $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
                $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
                $wpis .= ' zostało odłączone od komputera [id_k] => '.$komp->id_k.', [dns_k] => '.$komp->dns_k;
                app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
                app('App\Http\Controllers\HistoriaController')->store('komputery', $komp->id_k, $wpis);
            }
        }
    }
    public function destroy($id) {
        $this->disconnectDzial($id);
        $this->disconnectKomp($id);
        $urzadzenie = urzadzenie::findOrFail($id);
        
        $urzadzenie->delete();
        $wpis = 'Urzadzenie [id_dev] => '.$urzadzenie->id_dev;
        $wpis .= ', [model_dev] => '.$urzadzenie->model_dev;
        $wpis .= ', [typ_dev] => '.$urzadzenie->typ_dev;
        $wpis .= ', [inwent_dev] => '.$urzadzenie->inwent_dev;
        $wpis .= ' zostało usunięte z bazy danych';
        app('App\Http\Controllers\HistoriaController')->store('urzadzenia', $id, $wpis);
        return redirect('/urzadzenia?active=0');
    }
    
}
