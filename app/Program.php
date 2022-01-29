<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $primaryKey = 'id_p';
    protected $table = "intranet.programy";
    //public $timestamps = false;
    public $sortable = ['nazwa_p', 'rodzaj_p', 'typ_p', 'ilosc', 'created_at', 'updated_at'];
}
