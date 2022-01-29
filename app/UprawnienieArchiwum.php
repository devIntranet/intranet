<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieArchiwum extends Model
{
    protected $table = "intranet.uprawnienia_archiwa_pomieszczenia";
    protected $primaryKey = 'id_upar';

    protected $fillable = ['id_archp', 'id_wn'];
}
