<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dzial extends Model
{
    protected $primaryKey = 'id_dz';
    protected $table = "intranet.dzialy";

    public function dzialHasUsers() {
        return $this->hasMany(Uzytkownik::class, 'id_dz', 'id_dz');
    }
}