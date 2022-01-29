<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ot extends Model
{
    protected $primaryKey = 'id_ot';
    protected $table = 'intranet.ot';
    //public $timestamps = false;
    public $sortable = ['id_ot', 'created_at'];
}
