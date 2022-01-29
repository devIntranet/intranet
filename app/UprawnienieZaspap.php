<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieZaspap extends Model
{
    protected $table = "intranet.uprawnienia_zaspap";
    protected $primaryKey = 'id_uprzaspap';

    protected $fillable = ['id_zaspap', 'upzaspap_value', 'id_wn'];
}
