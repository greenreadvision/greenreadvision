<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstimateController extends Controller
{
    public function index(){
        return view('pm.estimate.index');
    }

    public function create(){
        return view('pm.estimate.create');
    }
}
