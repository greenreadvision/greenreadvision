<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hulk;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Functions\RandomId;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\RegistersUsers;

class HulkController extends Controller{
    public function index(){
        $areas = ['taipei', 'ntc', 'taoyuan', 'hsinchu', 'miaoli', 'other'];
        $ages = ['children', 'teen', 'adult', 'elderly'];
        $datas = Hulk::all();
        return view('pm.hulk.indexHulk', ['areas' => $areas, 'ages' => $ages, 'datas' => $datas]);
    }

    public function store(Request $request){
        $post = Hulk::create([
            'sex' => $request -> input('select_sex'),
            'area' => $request -> input('select_area'),
            'age' => $request -> input('select_age')
        ]);
        return redirect()->route('hulk');
    }
}