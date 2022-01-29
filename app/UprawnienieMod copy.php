<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieMod extends Model
{
    protected $table = "intranet.uprawnienia_mod";
    protected $primaryKey = 'id_uprmod';

    protected $fillable = ['upr', 'id_mod', 'id_wn', 'login_mod', 'haslo_mod'];
}
