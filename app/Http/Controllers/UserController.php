<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\LeaveDay;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Functions\RandomId;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
class UserController extends Controller
{
    //
    public function index(){
        return view('pm.user.profile')->with('data', \Auth::user()->toArray());
    }

    public function edit(){
        $user = \Auth::user()->toArray();
        // $user = array_diff_key(\Auth::user()->toArray(), ["id" => null, "email_verified_at" => null, "user_id" => null]);
        return view('pm.user.editProfile')->with('data', $user);
    }

    public function update(Request $request){
        \Auth::user()->update($request->except('_method', '_token'));
        return redirect()->route('profile');
    }

    public function managed()
    {
        $users = \App\User::all();
        return view('pm.user.editRole')->with('data', $users->toArray());
    }

    public function setRole(Request $request)
    {
        $users = \App\User::all();
        foreach ($users as $user){
            $user->status = $request->input($user->user_id);
            $user->save();
            // $user->update($request->except('_method', '_token'));
        }
        return view('pm.user.editRole')->with('data', $users->toArray());
    }
    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $password = Hash::make($request->input('password'));
        \Auth::user()->password = $password;
        \Auth::user()->save();
        \Auth::logout();
        return redirect()->route('login');
    }
}
