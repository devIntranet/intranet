<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UPS extends Model
{
    protected $primaryKey = 'id_ups';
    protected $table = "intranet.upsy";
    //public $timestamps = false;
    public $sortable = ['id_ups', 'model_ups', 'inwent_u', 'created_at'];
}
