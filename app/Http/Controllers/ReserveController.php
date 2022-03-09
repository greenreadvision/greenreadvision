<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDO;

class ReserveController extends Controller
{
    function index(){
        return view('pm.reserve.indexReserve');
    }
}
