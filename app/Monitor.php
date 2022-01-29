<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $primaryKey = 'id_m';
    protected $table = "intranet.monitory";
    //public $timestamps = false;
    public $sortable = ['id_m', 'model_m', 'inwent_m', 'created_at'];
}
