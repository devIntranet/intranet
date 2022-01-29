<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UprawnienieExtMailbox extends Model
{
    protected $table = "intranet.uprawnienia_ext_mailboxes";
    protected $primaryKey = 'id_uprmbx';

    protected $fillable = ['id_mbx', 'id_wn'];
}
