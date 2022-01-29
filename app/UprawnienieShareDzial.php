<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieShareDzial extends Model
{
    protected $table = "intranet.uprawnienia_udzialy_dzialy";
    protected $primaryKey = 'id_upuddz';

    protected $fillable = ['id_dz', 'id_wn'];
}
