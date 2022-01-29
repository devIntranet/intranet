<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieMagazyn extends Model
{
    protected $table = "intranet.uprawnienia_gm";
    protected $primaryKey = 'id_uprgm';

    protected $fillable = ['id_mag', 'rola', 'id_wn'];
}
