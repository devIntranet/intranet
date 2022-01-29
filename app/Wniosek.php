<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wniosek extends Model
{
    protected $table = "intranet.wnioski";
    protected $primaryKey = 'id_wn';

    protected $fillable = ['nazwisko', 'imie', 'data_start', 'data_end', 'id_dz', 'id_u', 'status_wn'];
}
