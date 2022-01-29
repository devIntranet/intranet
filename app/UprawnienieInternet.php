<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieInternet extends Model
{
    protected $table = "intranet.wnioski_internet";
    protected $primaryKey = 'id_wi';

    protected $fillable = ['www', 'email', 'id_wn', 'adresEmail'];
}
