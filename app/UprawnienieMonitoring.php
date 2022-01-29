<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieMonitoring extends Model
{
    protected $table = "intranet.uprawnienia_monitoring_systemy";
    protected $primaryKey = 'id_ums';

    protected $fillable = ['id_r', 'id_monsys', 'id_wn', 'ums_level'];
}
