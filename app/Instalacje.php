<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instalacje extends Model
{
    protected $primaryKey = 'id_i';
    protected $table = "intranet.instalacje";
    //public $timestamps = false;
    public $sortable = ['id_p', 'id_k'];
}
