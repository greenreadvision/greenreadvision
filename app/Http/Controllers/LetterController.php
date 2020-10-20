<?php

namespace App\Http\Controllers;

use App\Letters;
use App\User;
use App\Functions\RandomId;
use Illuminate\Http\Request;

class LetterController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(\Auth::user()->user_id);
      
        return view('pm.letter.index', ["user" => $user]);
    }

    public function show(String $id){
        $letter = Letters::find($id);
        $letter->status = 'read';
        $letter->save();
        return view('pm.letter.show', ["letter" => $letter]);
    }
}
