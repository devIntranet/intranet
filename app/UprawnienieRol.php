<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieRol extends Model
{
    protected $table = "intranet.uprawnienia_rol";
    protected $primaryKey = 'id_uprrol';

    protected $fillable = ['id_r', 'id_wn', 'login_rol', 'haslo_rol'];
}
