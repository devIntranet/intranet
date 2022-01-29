<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
      }
}
