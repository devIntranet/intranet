<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WniosekRCP extends Model
{
    protected $table = "intranet.wnioski_rcp";
    protected $primaryKey = 'id_wnrcp';

    protected $fillable = ['id_wn', 'nr_rcp', 'nr_karty'];
}
