<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    protected $primaryKey = 'id_h';
    protected $table = "intranet.historia";
    //public $timestamps = false;
    public $sortable = ['id_o', 'tabela', 'created_at'];
}
