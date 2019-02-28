<?php

namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxController extends Controller
{
    public function login(){
        $data=$_GET;
        print_r($data);exit;
    }
}
