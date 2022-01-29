<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieShare extends Model
{
    protected $table = "intranet.uprawnienia_udzialy";
    protected $primaryKey = 'id_upud';

    protected $fillable = ['id_ud', 'id_wn', 'upud_value'];
}
