<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


use App\Komputer;
use App\Dzial;
use App\Uzytkownik;
use App\Instalacja;
use App\Program;

class ProgramController extends Controller
{
    public function index() {
        $sortable = ['nazwa_p', 'data_p', 'typ_p', 'lic_p', 'licqty_p'];
        $order='nazwa_p';
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
        $programy = DB::table('intranet.programy as programy')
            ->leftJoin('intranet.instalacje as instalacje', 'instalacje.id_p', '=', 'programy.id_p')
            ->leftJoin('intranet.komputery as komputery', 'komputery.id_k', '=', 'instalacje.id_k')
            ->selectRaw('programy.id_p, programy.nazwa_p, programy.data_p, programy.licqty_p, programy.lic_p, programy.typ_p, count(instalacje.id_p) as install')
            ->where([['programy.status_p', '=', $active],])
            ->groupBy(DB::raw('programy.id_p, programy.nazwa_p, programy.typ_p, programy.lic_p, programy.licqty_p, programy.data_p'))
            ->orderBy($order, $direction)
            ->get();
            //->toSQL();
        //return $programy;
        return view('programy.index', ['programy' => $programy]);
    }
    public function show($id, Request $request) {
        $edit = $request->validate([
            'e' => 'sometimes|in:nazwa,typ,lic,licqty,data',
        ]);
        //if ($edit) return $edit;
        $tab = $request->validate([
            'tab' => 'sometimes|in:inst,log',
        ]);
                
        $program = DB::table('intranet.programy as programy')
        ->leftJoin('intranet.instalacje as instalacje','instalacje.id_p', '=', 'programy.id_p')
        ->leftJoin('intranet.komputery as komputery', 'komputery.id_k', '=', 'instalacje.id_k')
        ->leftJoin('intranet.dzialy as dzialy','komputery.id_dz', '=', 'dzialy.id_dz')
        ->leftJoin('intranet.uzytkownicy as uzytkownicy','komputery.id_u', '=', 'uzytkownicy.id_u')
        ->select('programy.*', 
                'uzytkownicy.id_u', 'uzytkownicy.nazwa_u', 'uzytkownicy.imie_u',
                'dzialy.id_dz', 'dzialy.nazwa_d', 'dzialy.symbol_d',
                'komputery.id_k', 'komputery.dns_k', 'komputery.inwent_k')
        ->where('programy.id_p',$id)
        ->get()
        ->first();
        $install = DB::table('intranet.instalacje as instalacje')
            ->where('id_p', $id)
            ->count();
        if ($tab && $tab['tab'] == 'inst') {
            $installed = DB::table('intranet.instalacje as instalacje')
                ->leftJoin('intranet.programy as programy', 'programy.id_p', '=', 'instalacje.id_p')
                ->leftJoin('intranet.komputery as komputery', 'komputery.id_k', '=', 'instalacje.id_k')
                ->leftJoin('intranet.dzialy as dzialy','komputery.id_dz', '=', 'dzialy.id_dz')
                ->leftJoin('intranet.uzytkownicy as uzytkownicy','komputery.id_u', '=', 'uzytkownicy.id_u')
                ->select('komputery.id_k', 'komputery.dns_k', 
                    'uzytkownicy.id_u', 'uzytkownicy.nazwa_u', 'uzytkownicy.imie_u',
                    'dzialy.id_dz', 'dzialy.symbol_d',
                    'instalacje.id_i', 'instalacje.updated_at')
                ->where('instalacje.id_p', $id)
                ->get();
        
            return view('programy.show', [
                'tab' => $tab, 
                'program' => $program,
                'installed' => $installed,
                ]);
        }
        elseif ($tab && $tab['tab'] == 'log') {
            $logiSoft = DB::table('intranet.historia as historia')
                ->where([
                    ['historia.id_o', '=', $id],
                    ['tabela', '=', 'programy'],
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(12);
                //->get();
            $logiSoft->withPath($id.'?tab=log');
            return view('programy.show', [
                'tab' => $tab, 
                'program' => $program,
                'logiSoft' => $logiSoft,
                ]);
        }

        else {
            //return $komp;
            return view('programy.show', [
                'e' => $edit,
                'program' => $program,
                'install' => $install
                ]);
        }
    }
    public function add() {
        return view('programy.add');
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nazwa_p' => 'required|unique:sqlsrv.intranet.programy|max:30',
            'typ_p' => 'required|numeric|digits:1',
            'lic_p' => 'required|string|max:15',
            'licqty_p' => 'required|numeric|max:1000',
            'data_p' => 'required|date|before:tomorrow',
        ]);
        
         $program = new program();
         $program->nazwa_p = request('nazwa_p');
         $program->typ_p = request('typ_p');
         $program->lic_p = request('lic_p');
         $program->licqty_p = request('licqty_p');
         $program->data_p = request('data_p');
         
         if($program->save()) {
            $wpis = 'Dodano nowy program: [id_p] => '.$program->id_p;
            $wpis .= ', [nazwa_p] => '.$program->nazwa_p;
            $wpis .= ', [typ_p] => '.$program->typ_p;
            $wpis .= ', [lic_p] => '.$program->lic_p;
            $wpis .= ', [licqty_p] => '.$program->licqty_p;
            $wpis .= ', [data_p] => '.$program->data_p;
            app('App\Http\Controllers\HistoriaController')->store('programy', $program->id_p, $wpis);

         }
         return $this->show($program->id_p, $request);
    }
    public function updateOneCol($id, Request $request) {
        //return $request;
        $validatedData = $request->validate([
            'id_p' => 'required|numeric|exists:sqlsrv.intranet.programy',
            'nazwa_p' => 'sometimes|required|string|max:100',
            'old_nazwa_p' => 'sometimes|nullable',
            'typ_p' => 'sometimes|required|numeric|in:1,2',
            'old_typ_p' => 'sometimes|nullable',
            'lic_p' => 'sometimes|required|string|max:20',
            'old_lic_p' => 'sometimes|nullable',
            'licqty_p' => 'sometimes|required|string|max:20',
            'old_licqty_p' => 'sometimes|nullable',
            'data_p' => 'sometimes|required|date|before:tomorrow',
            'old_data_p' => 'sometimes|nullable',
            'oldProperty' => 'required|in:nazwa_p,typ_p,lic_p,licqty_p,data_p'
        ]);

        $program =  Program::findOrFail($validatedData['id_p']);
        $affected = DB::table('intranet.programy')
            ->where('id_p', $validatedData['id_p'])
            ->update([$validatedData['oldProperty'] => $validatedData[$validatedData['oldProperty']]]);
        $wpis = 'Zmieniono ['.$validatedData['oldProperty'].'] programu [id_p] => '.$program->id_p;
        $wpis .= ' ('.$program[$validatedData['oldProperty']].' =>  '.$validatedData[$validatedData['oldProperty']].')' ;
        app('App\Http\Controllers\HistoriaController')->store('programy', $id, $wpis);
        
        return $this->show($id, $request);
       
   }
    public function disable($id) {
        $program = Program::findOrFail($id);
        $affected = DB::table('intranet.programy')
            ->where('id_p', $id)
            ->update(['status_p' => 0,]);
        
        $wpis = 'Program [id_p] => '.$program->id_p.', [nazwa_p] => '.$program->nazwa_p;
        $wpis .= ' został oznaczony jako usunięty';
        app('App\Http\Controllers\HistoriaController')->store('programy', $id, $wpis);
        return redirect()->route('programy.index', ['active' => 0]);
        return redirect('{{/programy}}?active=0');
    }
    public function activate($id) {
        $program = Program::findOrFail($id);
        $affected = DB::table('intranet.programy')
            ->where('id_p', $id)
            ->update(['status_p' => 1]);
        $wpis = 'Program [id_p] => '.$program->id_p.', [nazwa_p] => '.$program->nazwa_p;
        $wpis .= ' został ponownie aktywowany.';
        app('App\Http\Controllers\HistoriaController')->store('programy', $id, $wpis);
        return redirect()->route('programy.index');
        #return redirect('/programy');
    }
}
