<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fw extends Model
{
    protected $primaryKey = 'id_fw';
    protected $table = 'intranet.fw';
    //public $timestamps = false;
    public $sortable = ['id_fw', 'created_at'];
}
