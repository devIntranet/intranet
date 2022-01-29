<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use App\Wniosek;
use App\Uzytkownik;
use App\Dzial;
use App\Historia;
use App\Magazyn;
use App\UprawnienieMod;
use App\UprawnienieRol;
use App\UprawnienieMagazyn;
use App\UprawnienieShare;
use App\UprawnienieShareDzial;
use App\UprawnienieMonitoring;
use App\UprawnienieStrefy;
use App\UprawnienieArchiwum;
use App\UprawnienieInternet;
use App\UprawnienieExtMailbox;
use App\UprawnienieZaspap;
use App\WniosekRCP;

class WniosekController extends Controller
{
    public function index(Request $request) {
       if ($request->has('otwarte')) {return 1;   }
       if ($this->isAdmin($this->getCurrentUsernameAD())) { return $this->getUserID('sebastianj');}
       $sortable = ['id_wn', 'nazwisko', 'imie', 'symbol_d', 'data_zl', 'data_mod', 'data_zat'];
       $order='id_wn';
       $direction = 'desc';
       if (in_array(request('sort'), $sortable)) {$order = request('sort');}
       
       if (request('direction') == 'desc') {$direction = request('direction');}
       session(['order'=>$order]);
       session(['direction'=>$direction]); 
       $wnioski = DB::table('intranet.wnioski as wn')
        ->leftJoin('intranet.uzytkownicy as u', 'u.id_u', '=', 'wn.id_u')
        ->leftJoin('intranet.dzialy as d', 'd.id_dz', '=', 'wn.id_dz')
        ->select('wn.*',
            'u.nazwa_u', 'u.imie_u',
            'd.symbol_d')
        ->orderBy($order, $direction)
        ->get();
        return view ('wnioski.index', ['wnioski' => $wnioski]);
    }
    public function show($id) {
         
         return view('wnioski.show', ['id' => $id]);
    }
    private function isAdmin($username) {
        $isAdmin = ($username == 'sebastianjs' || $username == 'marcinc' || $username == 'danielw' ? TRUE : FALSE);
        return $isAdmin;
    }
    private function getCurrentUsernameAD() {
        $user = explode('\\', $_SERVER['REMOTE_USER'], 100) ;
        return $user[1];
    }
    private function getUserID($usernameAD) {
        $query = DB::table('intranet.uzytkownicy as uzytkownicy')
            ->where('uzytkownicy.loginad_u', '=', $usernameAD)
            ->select('id_u')
            ->first();
        return $query->id_u;
    }
    private function getDzialyOperatora($userID) {
        return DB::table('intranet.wnioski_operatorzy as wnop')
            ->leftJoin('intranet.dzialy as dzialy', 'dzialy.id_dz', '=', 'wnop.id_dz')
            ->where('wnop.id_u', '=', $userID)
            ->select('wnop.id_dz','dzialy.symbol_d')
            ->get();
    }
    private function getUdzialy() {
        return DB::table('intranet.udzialy as udzialy')
            ->leftJoin('intranet.dzialy as dzialy', 'dzialy.id_dz', '=', 'udzialy.id_dz')
            ->where('udzialy.udzial_aktywny', '=', 1)
            ->select('udzialy.*','dzialy.symbol_d')
            ->get();
    }
    private function getDzialy() {
        return DB::table('intranet.dzialy as dzialy')
            ->get();
    }
    private function getDzialyUdzialy() {
        return DB::table('intranet.udzialy as ud')
            ->leftJoin('intranet.dzialy as dzialy', 'dzialy.id_dz', '=', 'ud.id_dz')
            ->select(DB::raw('count(*) as suma'), 'dzialy.symbol_d', 'ud.id_dz')
            ->groupBy('ud.id_dz', 'dzialy.symbol_d')
            ->orderBy('symbol_d')
            ->get();
    }
    private function getDzialyZaspap() {
        return DB::table('intranet.zasoby_papierowe as zaspap')
            ->leftJoin('intranet.dzialy as dzialy', 'dzialy.id_dz', '=', 'zaspap.id_dz')
            ->select(DB::raw('count(*) as suma'), 'dzialy.symbol_d', 'zaspap.id_dz')
            ->groupBy('zaspap.id_dz', 'dzialy.symbol_d')
            ->orderBy('symbol_d')
            ->get();
    }
    private function getSystems() {
        return DB::table('intranet.wnioski_operatorzy as wnop')
            ->leftJoin('intranet.dzialy as dzialy', 'dzialy.id_dz', '=', 'wnop.id_dz')
            ->where('wnop.id_u', '=', $userID)
            ->select('wnop.id_dz','dzialy.symbol_d')
            ->get();
    }
    private function getModules($idSys) {
        return DB::table('intranet.moduly as moduly')
            ->where('moduly.id_sys', '=', $idSys)
            ->get();
    }
    private function getRoles($idSys) {
        return DB::table('intranet.role as role')
            ->where('role.id_sys', '=', $idSys)
            ->get();
    }
    private function getMagazyny() {
        return DB::table('Tychy1.dbo.MS_MAGAZ as magazyny')
            ->select('magazyny.MAGAZYN', 'magazyny.TYP', 'magazyny.NAZWA')
            ->where('magazyny.NAZWA', '!=', 'NIE STOSOWAĆ')
            ->get();
    }
    private function getMonitoringSystemy() {
        return DB::table('intranet.monitoring_systemy as monsys')
            ->get();
    }
    private function getPomieszczeniaArchiwum() {
        return DB::table('intranet.archiwa_pomieszczenia as archp')
            ->get();
    }
    private function getStrefyDostepu() {
        return DB::table('intranet.strefy_dostepu as strdst')
            ->get();
    }
    private function getExtMailboxes() {
        return DB::table('intranet.ext_mailboxes as extMailboxes')
            ->orderBy('extMailboxes.nazwa_mbx')
            ->get();
    }
    private function getZaspap() {
        return DB::table('intranet.zasoby_papierowe as zaspap')
        ->get();
    }
    public function addStep1(Request $request) {
        if (empty($request->session()->get('wniosek'))) {
            $wniosek = new Wniosek();
            $authUser = explode("\\", $_SERVER['AUTH_USER']);
            $loginAD = $authUser[1];
            $wniosek->id_u = $this->getUserID($loginAD);
            $request->session()->put('wniosek', $wniosek);
        }
        else $wniosek = $request->session()->get('wniosek');
        
        $dzialy = $this->getDzialyOperatora($this->getUserID($this->getCurrentUsernameAD()));
        
        if ($dzialy) {
            return view('wnioski.addStep1', [
                'dzialy' => $dzialy,
                'wniosek'=> $wniosek
            ]);
        }
    }
    public function addStep1post(Request $request) {
        $validatedData = $request->validate([
            'imie' => 'required|max:20',
            'nazwisko' => 'required|max:40',
            'data_start' => 'required|date|after:yesterday',
            'data_end' => 'nullable|date|after:yesterday',
            'id_dz' => 'required|numeric|exists:sqlsrv.intranet.dzialy,id_dz',
            ]);
        
        if ($request->validate(['kartaRCP' => 'required|numeric|in:0,1'])) $request->session()->put('kartaRCP', $request->input('kartaRCP'));
        
        if(empty($request->session()->get('wniosek'))) $wniosek = new Wniosek(); 
        else $wniosek = $request->session()->get('wniosek');
        $wniosek->status_wn = 1;
        $wniosek->fill($validatedData);
        $request->session()->put('wniosek', $wniosek);
        
  
        return redirect()->route('wnioski.addStep2');
        
        /*
        $request->session()->flash('wniosekStep1', $step1);
        *return view('wnioski.addStep2', [
            'step1' => $step1
        $wniosek = $request->session()->get('wniosek');
        return view('wnioski.addStep1', [
            'dzialy' => $dzialy,
            ]);
        $dzialy = $this->getDzialyOperatora($this->getUserID($this->getCurrentUsernameAD()));
        if ($dzialy) {
            return view('wnioski.addStep1', [
                'dzialy' => $dzialy,
                ]);
        }
        */
    }
    public function addStep2(Request $request) {
        $udzialy = $this->getUdzialy();
        $dzialy = $this->getDzialyUdzialy();
        $wniosek = $request->session()->get('wniosek');
        $windows = $request->session()->get('windows');
        $dzialShare = $request->session()->get('dzialShare');
        $share = $request->session()->get('share');
           return view('wnioski.addStep2', [
                'wniosek' => $wniosek,
                'windows' => $windows,
                'udzialy' => $udzialy,
                'dzialy' => $dzialy,
                'dzial' => $dzialShare,
                'share' => $share,
           ]);
    }
    public function addStep2post(Request $request) {
        $validatedData = $request->validate([
            'windows' => 'required|numeric|in:0,1'
        ]);
        $request->session()->put('share', $request->input('share'));
        $request->session()->put('dzialShare', $request->input('dzialShare'));
        $windows = $validatedData['windows'];
        $request->session()->put('windows', $windows);
        if ($validatedData['windows'] == 1) return redirect()->route('wnioski.addStep3');
        else return redirect()->route('wnioski.addStep3');
    }
    public function addStep3(Request $request) {
        if ($request->session()->get('windows') == 0) return $this->addStep4($request);
        //dd(session()->all());
        $moduly = $this->getModules(2); //TPMedia: id=2
        $magazyny = $this->getMagazyny();
        $TPMedia = $request->session()->get('TPMedia');
        $selectedTPMediaModuly = $request->session()->get('selectedTPMediaModuly');
        $uprTPMediaModuly = $request->session()->get('uprTPMediaModuly');
           return view('wnioski.addStep3', [
                'moduly' => $moduly,
                'magazyny' => $magazyny,
           ]);
    }
    public function addStep3post(Request $request) {
        $validatedData = $request->validate([
            'TPMedia' => 'required|numeric|in:0,1'
        ]);
        $request->session()->put('selectedTPMediaModuly', $request->input('selectedTPMediaModuly'));
        $request->session()->put('TPMedia', $validatedData['TPMedia']);
        $request->session()->put('uprTPMediaModuly', $request->input('uprTPMediaModuly'));
        $request->session()->put('magazynRola', $request->input('magazynRola'));
        return redirect()->route('wnioski.addStep4');
    }
    public function addStep4(Request $request) {
        //dd(session()->all());
        $ekartRole = $this->getRoles(3); //eKart Analyst: id=3
        $kartMobileRole = $this->getRoles(4); //KartMobile: id=4
        return view('wnioski.addStep4', [
            'ekartRole' => $ekartRole,
            'kartMobileRole' => $kartMobileRole,
        ]);
    }
    public function addStep4post(Request $request) {
        $validatedData = $request->validate([
            'ekart' => 'required|numeric|in:0,1',
            'kartmobile' => 'required|numeric|in:0,1',
            'ekartRole' => 'nullable|numeric|exists:sqlsrv.intranet.role,id_r',
            'kartMobileRole' => 'nullable|numeric|exists:sqlsrv.intranet.role,id_r',
       ]);
        $request->session()->put('ekart', $validatedData['ekart']);
        $request->session()->put('kartmobile', $validatedData['kartmobile']);
        $request->session()->put('ekartRole', $validatedData['ekartRole']);
        $request->session()->put('kartMobileRole', $validatedData['kartMobileRole']);
        return redirect()->route('wnioski.addStep5');
    }
    public function addStep5(Request $request) {
        if ($request->session()->get('windows') == 0) return $this->addStep9($request);
        //dd(session()->all());
        $komaxRole = $this->getRoles(29); //komax: id=29
        $RCPRole = $this->getRoles(30); //RCP: id=30
        $platnikRole = $this->getRoles(9); //Płatnik: id=9
        $PPKRole = $this->getRoles(26); //PPK: id=26
        return view('wnioski.addStep5', [
            'komaxRole' => $komaxRole,
            'RCPRole' => $RCPRole,
            'platnikRole' => $platnikRole,
            'PPKRole' => $PPKRole,
        ]);
    }
    public function addStep5post(Request $request) {
        $validatedData = $request->validate([
            'komax' => 'required|numeric|in:0,1',
            'RCP' => 'required|numeric|in:0,1',
            'platnik' => 'required|numeric|in:0,1',
            'ppk' => 'required|numeric|in:0,1',
            'epfron' => 'required|numeric|in:0,1',
            'ubezpieczenia' => 'required|numeric|in:0,1',
            'komaxRola' => 'nullable|numeric|exists:sqlsrv.intranet.role,id_r',
            'RCPRola' => 'nullable|numeric|exists:sqlsrv.intranet.role,id_r',    
            'platnikRola' => 'nullable|numeric|exists:sqlsrv.intranet.role,id_r',
            'PPKRola' => 'nullable|numeric|exists:sqlsrv.intranet.role,id_r',
        ]);
        $request->session()->put('komax', $validatedData['komax']);
        $request->session()->put('RCP', $validatedData['RCP']);
        $request->session()->put('platnik', $validatedData['platnik']);
        $request->session()->put('ppk', $validatedData['ppk']);
        $request->session()->put('epfron', $validatedData['epfron']);
        $request->session()->put('ubezpieczenia', $validatedData['ubezpieczenia']);
        $request->session()->put('platnikRola', $validatedData['platnikRola']);
        $request->session()->put('komaxRola', $validatedData['komaxRola']);
        $request->session()->put('RCPRola', $validatedData['RCPRola']);
        $request->session()->put('PPKRola', $validatedData['PPKRola']);
        return redirect()->route('wnioski.addStep6');
    }
    public function addStep6(Request $request) {
        //dd(session()->all());
        $transportRole = $this->getRoles(6); //Transport: id=6
        $GPSModuly = $this->getModules(25); //GPS: id=25
        return view('wnioski.addStep6', [
            'transportRole' => $transportRole,
            'GPSModuly' => $GPSModuly,
        ]);
    }
    public function addStep6post(Request $request) {
        
        $validatedData = $request->validate([
            'transport' => 'required|numeric|in:0,1',
            'GPS' => 'required|numeric|in:0,1',
            'transportRole' => 'nullable|numeric|exists:sqlsrv.intranet.role,id_r',    
            'GPSModuly' => 'nullable|numeric|exists:sqlsrv.intranet.moduly,id_mod',    
        ]);
        
        $request->session()->put('transport', $validatedData['transport']);
        $request->session()->put('transportRole', $validatedData['transportRole']);
        $request->session()->put('GPS', $validatedData['GPS']);
        $request->session()->put('GPSModuly', $validatedData['GPSModuly']);
        
        return redirect()->route('wnioski.addStep7');
    }
    public function addStep7(Request $request) {
        //dd(session()->all());
        $officeModuly = $this->getModules(19); //Office: id=7
        $telwinModuly = $this->getModules(7); //Telwin: id=7
        $sensusReadModuly = $this->getModules(28); //Sensus Read: id=28
        $sensusKonwerterModuly = $this->getModules(34); //Sensus Konwerter: id=35
        $diavasoModuly = $this->getModules(35); //Diavaso: id=35
        return view('wnioski.addStep7', [
            'officeModuly' => $officeModuly,
            'telwinModuly' => $telwinModuly,
            'sensusReadModuly' => $sensusReadModuly,
            'sensusKonwerterModuly' => $sensusKonwerterModuly,
            'diavasoModuly' => $diavasoModuly,
        ]);
    }
    public function addStep7post(Request $request) {
        $validatedData = $request->validate([
            'office' => 'required|numeric|in:0,1',
            'officeModuly' => 'nullable|numeric|exists:sqlsrv.intranet.moduly,id_mod',
            'telwin' => 'required|numeric|in:0,1',
            'telwinModuly' => 'nullable|numeric|exists:sqlsrv.intranet.moduly,id_mod',
            'sensusRead' => 'required|numeric|in:0,1',
            'sensusReadModuly' => 'nullable|numeric|exists:sqlsrv.intranet.moduly,id_mod',
            'sensusKonwerter' => 'required|numeric|in:0,1',
            'sensusKonwerterModuly' => 'nullable|numeric|exists:sqlsrv.intranet.moduly,id_mod',
            'diavaso' => 'required|numeric|in:0,1',
            'diavasoModuly' => 'nullable|numeric|exists:sqlsrv.intranet.moduly,id_mod',
            'rozliczenieInkasenta' => 'required|numeric|in:0,1',
            'autocad' => 'required|numeric|in:0,1',
            'g-starCad' => 'required|numeric|in:0,1',
            'profilKoordynator' => 'required|numeric|in:0,1',
            'profilAdministrator' => 'required|numeric|in:0,1',
            'normaPRO' => 'required|numeric|in:0,1',
        ]);
        $request->session()->put('office', $validatedData['office']);
        $request->session()->put('officeModuly', $validatedData['officeModuly']);
        $request->session()->put('telwin', $validatedData['telwin']);
        $request->session()->put('telwinModuly', $validatedData['telwinModuly']);
        $request->session()->put('sensusRead', $validatedData['sensusRead']);
        $request->session()->put('sensusReadModuly', $validatedData['sensusReadModuly']);
        $request->session()->put('sensusKonwerter', $validatedData['sensusKonwerter']);
        $request->session()->put('sensusKonwerterModuly', $validatedData['sensusKonwerterModuly']);
        $request->session()->put('diavaso', $validatedData['diavaso']);
        $request->session()->put('diavasoModuly', $validatedData['diavasoModuly']);
        $request->session()->put('rozliczenieInkasenta', $validatedData['rozliczenieInkasenta']);
        $request->session()->put('autocad', $validatedData['autocad']);
        $request->session()->put('g-starCad', $validatedData['g-starCad']);
        $request->session()->put('profilKoordynator', $validatedData['profilKoordynator']);
        $request->session()->put('profilAdministrator', $validatedData['profilAdministrator']);
        $request->session()->put('normaPRO', $validatedData['normaPRO']);
        
        
        
        return redirect()->route('wnioski.addStep8');
    }
    public function addStep8(Request $request) {
        //dd(session()->all());
        $monitoringSystemy = $this->getMonitoringSystemy(); 
        return view('wnioski.addStep8', [
            'monitoringSystemy' => $monitoringSystemy,
        ]);
    }
    public function addStep8post(Request $request) {
        //dd($request);
        $request->session()->put('CCTV', $request->input('CCTV'));
        $request->session()->put('monsys', $request->input('monsys'));
        return redirect()->route('wnioski.addStep9');
    }
    public function addStep9(Request $request) {
        //dd(session()->all());
        $pomieszczeniaArchiwum = $this->getPomieszczeniaArchiwum(); 
        $strefyDostepu = $this->getStrefyDostepu(); 
        return view('wnioski.addStep9', [
            'pomieszczeniaArchiwum' => $pomieszczeniaArchiwum,
            'strefyDostepu' => $strefyDostepu,
        ]);
    }
    public function addStep9post(Request $request) {
        $request->session()->put('archp', $request->input('archp'));
        $request->session()->put('strdst', $request->input('strdst'));
        return redirect()->route('wnioski.addStep10');
    }
    public function addStep10(Request $request) {
        //dd(session()->all());
        $extMailboxes = $this->getExtMailboxes();
        //dd($extMailboxes);
        return view('wnioski.addStep10', [
            'extMailboxes' => $extMailboxes,
        ]);
    }
    public function addStep10post(Request $request) {
        $request->session()->put('internetLevel', $request->input('internetLevel'));
        $request->session()->put('pocztaZew', $request->input('pocztaZew'));
        $request->session()->put('mailboxes', $request->input('mailboxes'));
        $request->session()->put('extMbx', $request->input('extMbx'));    
        //dd(session()->all());
        return redirect()->route('wnioski.addStep11');
    }
    public function addStep11(Request $request) {
       // dd(session()->all());
        $zaspap = $this->getZaspap();
        $dzialy = $this->getDzialyZaspap();
        return view('wnioski.addStep11', [
            'zaspap' => $zaspap,
            'dzialy' => $dzialy,
        ]);
    }
    public function addStep11post(Request $request) {
        $request->session()->put('dzialZaspap', $request->input('dzialZaspap'));
        $request->session()->put('zaspapSelect', $request->input('zaspapSelect'));
        //echo json_encode($request->session()->all());
        $wniosek = $request->session()->get('wniosek');
        //dd($wniosek);
        $wniosek->save();
        $this->storeWniosek($request, $wniosek->id_wn);
        //$request->session()->flush();
        //$request->session()->put('wniosek', $wniosek);
        dd(session()->all());
        //dd($wniosek);
        //return redirect()->route('wnioski.addStep1'); 
    }
    public function addStep12(Request $request) {
        $arr = $request->session()->get('magazynRola');
        foreach ($arr as $key => $val) {
            if ($val >0) echo "$key => $val<br>";
        }
    } 
    public function storeWniosek(Request $request, $id_wn) {
        //$validatedData = $request->validate([
        //]);
        //$request->session()->flush();
        if ($request->session()->get('windows') == 1) {
            $uprmod = new UprawnienieMod;
            $windows = [
                'upr' => '3',
                'id_mod' => '50', //Windows
                'id_wn' => $id_wn,
            ];
            $uprmod->fill($windows);
            $uprmod->save();
            ### Zaznaczone działy zasobów
            if ( null != $request->session()->get('dzialShare') ) {
                foreach($request->session()->get('dzialShare') as $dzialShare => $dzialShareEnabled) {
                    if ($dzialShare > 0) {
                        $upudDz = new UprawnienieShareDzial;
                        $upudDzAttr = [
                            'id_dz' => $dzialShare, 
                            'id_wn' => $id_wn,
                        ];
                        $upudDz->fill($upudDzAttr);
                        $upudDz->save();
                        //dump($upud);
                        //dd($upud);
                    }
                }
            }
            ### Uprawnienia do zasobów
            foreach($request->session()->get('share') as $share => $shareUpr) {
                if ($shareUpr > 0) {
                    $upud = new UprawnienieShare;
                    $upudAttr = [
                        'upud_value' => $shareUpr,
                        'id_ud' => $share, 
                        'id_wn' => $id_wn,
                    ];
                    $upud->fill($upudAttr);
                    $upud->save();
                    //dump($upud);
                    //dd($upud);
                }
            }
            ### Uprawnienia TPMedia
            if ($request->session()->get('TPMedia') == 1) {
                ### Moduły poza GM
                foreach($request->session()->get('selectedTPMediaModuly') as $id_mod => $modEnabled) {
                    foreach($request->session()->get('uprTPMediaModuly') as $upr_mod => $uprModValue) {
                        if ($id_mod == $upr_mod) {
                            $uprmod = new UprawnienieMod;
                            $attr = [
                                'upr' => $uprModValue,
                                'id_mod' => $upr_mod,
                                'id_wn' => $id_wn,
                            ];
                            $uprmod->fill($attr);
                            $uprmod->save();
                        }
                    }
                }
                ### Role w GM
                foreach($request->session()->get('magazynRola') as $id_mag => $rola) {
                    if ($rola > 0 ) {
                        $uprMag = new Uprawnieniemagazyn;
                        $attr = [
                            'rola' => $rola,
                            'id_mag' => $id_mag,
                            'id_wn' => $id_wn,
                        ];
                        $uprMag->fill($attr);
                        $uprMag->save();
                    }
                }
            }
            ### Uprawnienia eKartAnalyst
            if ($request->session()->get('ekart') == 1) {
                $uprRol = new UprawnienieRol;
                $attr = [
                    'id_r' => $request->session()->get('ekartRole'),
                    'id_wn' => $id_wn,
                ];
                $uprRol->fill($attr);
                $uprRol->save();
                //dd($uprmod);
            }
            ### Uprawnienia Komax
            if ($request->session()->get('komax') == 1) {
                $uprRol = new UprawnienieRol;
                $attr = [
                    'id_r' => $request->session()->get('komaxRola'),
                    'id_wn' => $id_wn,
                ];
                $uprRol->fill($attr);
                $uprRol->save();
                //dd($uprmod);
            }
            ### Uprawnienia RCP
            if ($request->session()->get('RCP') == 1) {
                $uprRol = new UprawnienieRol;
                $attr = [
                    'id_r' => $request->session()->get('RCPRola'),
                    'id_wn' => $id_wn,
                ];
                $uprRol->fill($attr);
                $uprRol->save();
                //dd($uprmod);
            }
            ### Uprawnienia Płatnik
            if ($request->session()->get('platnik') == 1) {
                $uprRol = new UprawnienieRol;
                $attr = [
                    'id_r' => $request->session()->get('platnikRola'),
                    'id_wn' => $id_wn,
                ];
                $uprRol->fill($attr);
                $uprRol->save();
                //dd($uprmod);
            }
            ### Uprawnienia RCP
            if ($request->session()->get('ppk') == 1) {
                $uprRol = new UprawnienieRol;
                $attr = [
                    'id_r' => $request->session()->get('PPKRola'),
                    'id_wn' => $id_wn,
                ];
                $uprRol->fill($attr);
                $uprRol->save();
                //dd($uprmod);
            }
            ### Uprawnienia e-PFRON
            if ($request->session()->get('epfron') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => '9', // e-PFRON
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Ubezpiecznei Pracownicze
            if ($request->session()->get('ubezpieczenia') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => '111', // Ubezpieczenia Pracownicze
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Transport
            if ($request->session()->get('transport') == 1) {
                $uprRol = new UprawnienieRol;
                $attr = [
                    'id_r' => $request->session()->get('transportRole'),
                    'id_wn' => $id_wn,
                ];
                $uprRol->fill($attr);
                $uprRol->save();
                //dd($uprmod);
            }
            ### Uprawnienia GPS
            if ($request->session()->get('GPS') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => $request->session()->get('GPSModuly'), 
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Office
            if ($request->session()->get('office') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => $request->session()->get('officeModuly'), 
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia telwin
            if ($request->session()->get('telwin') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => $request->session()->get('telwinModuly'), 
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Sensus Read
            if ($request->session()->get('sesnsusRead') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => $request->session()->get('sensusReadModuly'), 
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Sensus Konwerter
            if ($request->session()->get('sesnsusKonwerter') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => $request->session()->get('sensusKonwerterModuly'), 
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Diavaso
            if ($request->session()->get('diavaso') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => $request->session()->get('diavasoModuly'), 
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Rozliczenie Inkasenta
            if ($request->session()->get('rozliczenieInkasenta') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => '69', // Rozliczenie Inkasenta
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia G-Star CAD
            if ($request->session()->get('g-starCad') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => '100', // G-Star CAD
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Auto CAD
            if ($request->session()->get('autocad') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => '54', // Auto CAD
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Profil Koordynator
            if ($request->session()->get('profilKoordynator') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => '56', // Profil Koordynator
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Profil Administrator
            if ($request->session()->get('profilAdministrator') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => '19', // Profil Administrator
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
            ### Uprawnienia Norma PRO
            if ($request->session()->get('normaPRO') == 1) {
                $uprMod = new UprawnienieMod;
                $attr = [
                    'upr' => '1',
                    'id_mod' => '55', // Norma PRO
                    'id_wn' => $id_wn,
                ];
                $uprMod->fill($attr);
                $uprMod->save();
                //dd($uprmod);
            }
        }
        ### Uprawnienia KartMobile
        if ($request->session()->get('kartmobile') == 1) {
            $uprRol = new UprawnienieRol;
            $attr = [
                'id_r' => $request->session()->get('kartMobileRole'),
                'id_wn' => $id_wn,
            ];
            $uprRol->fill($attr);
            $uprRol->save();
            //dd($uprmod);
        }
        ### Uprawnienia CCTV
        if ($request->session()->get('CCTV') == 1) {
            foreach($request->session()->get('monsys') as $ums => $ums_level) {
                if ($ums_level > 0) {
                    $uprCCTV = new UprawnienieMonitoring;
                    $uprAttr = [
                        'id_monsys' => $ums,
                        'ums_level' => $ums_level, 
                        'id_wn' => $id_wn,
                    ];
                    $uprCCTV->fill($uprAttr);
                    $uprCCTV->save();
                    //dump($upud);
                    //dd($upud);
                }
            }
            //dd($uprmod);
        }
        ### Uprawnienia Strefy Dostępu
        if ( null != $request->session()->get('strdst') ) {
            foreach($request->session()->get('strdst') as $strefa => $dostep) {
                if ($dostep > 0) {
                    $uprStrDst = new UprawnienieStrefy;
                    $uprAttr = [
                        'id_strdst' => $strefa,
                        'id_wn' => $id_wn,
                    ];
                    $uprStrDst->fill($uprAttr);
                    $uprStrDst->save();
                    //dump($upud);
                    //dd($upud);
                }
            }
            //dd($uprmod);
        }
        ### Uprawenienia dostępu do Pomieszczeń Archiwum
        if ( null != $request->session()->get('archp') ) {
            foreach($request->session()->get('archp') as $pomieszczenie => $dostep) {
                if ($dostep > 0) {
                    $uprArchiwum = new UprawnienieArchiwum;
                    $uprAttr = [
                        'id_archp' => $pomieszczenie,
                        'id_wn' => $id_wn,
                    ];
                    $uprArchiwum->fill($uprAttr);
                    $uprArchiwum->save();
                    //dump($upud);
                    //dd($upud);
                }
            }
            //dd($uprmod);
        }
        ### Upraweninia dostępu do sieci Internet i imiennej poczty zewnętrznej
        if ( null != $request->session()->get('internetLevel') ) {
            //( null != $request->session()->get('email') ) ? $email = 1 : $email = 0;
            $uprInternet = new UprawnienieInternet;
            $uprAttr = [
                    'www' => $request->session()->get('internetLevel'),
                    'id_wn' => $id_wn,
                    'email' => $request->session()->get('pocztaZew')
                ];
            $uprInternet->fill($uprAttr);
            $uprInternet->save();
            //dump($upud);
            //dd($upud);
        }
        ### Uprawnienia do skrzynek pocztowych zewnętrznych - współdzielonych
        if ($request->session()->get('mailboxes') == 1 && null != $request->session()->get('extMbx')) {
            foreach($request->session()->get('extMbx') as $mbx => $enabled) {
                $uprMbx = new UprawnienieExtmailbox;
                $uprAttr = [
                    'id_mbx' => $mbx,
                    'id_wn' => $id_wn,
                ];
                $uprMbx->fill($uprAttr);
                $uprMbx->save();
            }
            //dump($upud);
            //dd($upud);
        }
        ### Uprawnienia do zasobów papierowych
        if (  null != $request->session()->get('zaspapSelect') ) {
            foreach($request->session()->get('zaspapSelect') as $zaspap => $uprLevel) {
                if ($uprLevel > 0) {
                    $uprZaspap = new UprawnienieZaspap;
                    $uprAttr = [
                        'id_zaspap' => $zaspap,
                        'upzaspap_value' => $uprLevel,
                        'id_wn' => $id_wn,
                    ];
                    $uprZaspap->fill($uprAttr);
                    $uprZaspap->save();
                }
            }
            //dump($upud);
            //dd($upud);
        }
        if ($request->session()->get('kartaRCP') == 1) {
            $kartaRCP = new WniosekRCP;
            $kartaRCP->id_wn = $id_wn;
            $kartaRCP->save();
            //dd($kartaRCP);
        }   
    }
}