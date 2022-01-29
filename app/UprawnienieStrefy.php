<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieStrefy extends Model
{
    protected $table = "intranet.uprawnienia_strefy_dostepu";
    protected $primaryKey = 'id_uprstrdst';

    protected $fillable = ['id_strdst', 'id_wn'];
}
