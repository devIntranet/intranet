<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uzytkownik extends Model
{
    protected $primaryKey = 'id_u';
    protected $table = "intranet.uzytkownicy";

    public function userHasKomputer() {
        return $this->hasOne(Komputer::class, 'id_u', 'id_u');
    }

    public function userToDzial() {
        return $this->belongsTo(Dzial::class, 'id_dz', 'id_dz');
    }
}
