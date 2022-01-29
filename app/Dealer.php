<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $primaryKey = 'id_dea';
    protected $table = 'intranet.dealerzy';
    //public $timestamps = false;
    public $sortable = ['id_dea', 'created_at'];
}
