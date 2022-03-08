<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Functions\RandomId;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\RegistersUsers;

class HulkController extends Controller{
    public function index(){
        $areas = ['taipei', 'ntc', 'taoyuan', 'hsinchu', 'miaoli', 'other'];
        $ages = ['children', 'teen', 'adult', 'elderly'];
        return view('pm.hulk.indexHulk', ['areas' => $areas, 'ages' => $ages]);
    }
}