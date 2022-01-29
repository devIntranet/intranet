<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Uzytkownik;

class Komputer extends Model
{
    protected $primaryKey = 'id_k';
    protected $table = "intranet.komputery";
    public $timestamps = false;
    public $sortable = ['dns_k', 'typ_k', 'ip_k', 'inwent_k', 'nazwa_u', 'symbol_d'];

    public function komputerToUser() {
        return $this->belongsTo(Uzytkownik::class, 'id_u', 'id_u');
    }
    public function komputerToDzial() {
        return $this->hasOneThrough(Dzial::class, Uzytkownik::class, 'id_u', 'id_dz', 'id_u', 'id_dz');
    }
}