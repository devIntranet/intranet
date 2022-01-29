<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Urzadzenie extends Model
{
    protected $primaryKey = 'id_dev';
    protected $table = "intranet.urzadzenia";
    //public $timestamps = false;
    public $sortable = ['id_dev', 'nazwa_dev', 'typ_dev', 'ip_dev', 'inwent_dev', 
                        'id_dz', 'id_k', 'created_at', 'updated_at'];
}
