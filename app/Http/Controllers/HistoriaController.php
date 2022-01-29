<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Historia;
use App\Komputer;
use App\Urzadzenie;
use Auth;

class HistoriaController extends Controller
{
    public function store($tabela, $id, $wpis) {
        $log = new Historia();
        $log->tabela = $tabela;
        $log->id_o = $id;
        $log->wpis = $wpis;
        $log->kto = Auth::user()->username;
        $log->save(); 
    }
    
    public function storeOT($ot) {
        $log = new Historia();
        $log->tabela = $ot->dev_typ;
        if ($ot->dev_typ = 'komputery'){
            $komp = Komputer::findOrFail($ot->id_k);
            $log->id_o = $ot->id_k;
            $log->wpis = 'Dla komputera o id ['.$komp->id_k.'] i dns_k => ['.$komp->dns_k.']';
        }
        if ($ot->dev_typ = 'monitory'){
            $monitor = Monitor::findOrFail($ot->id_m);
            $log->id_o = $ot->id_m;
            $log->wpis = 'Dla monitora o id ['.$monitor->id_m.']';
        }
        if ($ot->dev_typ = 'urzadzenia'){
            $dev = Urzadzenie::findOrFail($ot->id_dev);
            $log->id_o = $ot->id_dev;
            $log->wpis = 'Dla urzadzenia o id ['.$dev->id_dev.'] i nazwa_dev => ['.$dev->nazwa_k.']';
        }
        $log->wpis .= 'wprowadzono nowy dokument OT o id ['.$ot->id_ot.'].';
        $log->kto = Auth::user()->username;
        $log->save(); 
    }
}
