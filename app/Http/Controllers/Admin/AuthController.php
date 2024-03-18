<?php

namespace App\Http\Controllers\Admin;

use App\Classes\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function login(Request $request){
        return 'Okay';
    }
}
