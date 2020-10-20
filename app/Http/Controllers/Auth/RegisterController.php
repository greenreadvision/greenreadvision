<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\LeaveDay;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Functions\RandomId;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // // Let admin register the new coming. _SmallMO
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'role' => 'required|string|max:10',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $users = User::select('user_id')->get()->map(function($user) { return $user->user_id; })->toArray();
        $user_id =\App\Functions\RandomId::getNewId($users, 11);
        $registerPost= User::create([
            'user_id' => $user_id,
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'role' => $data['role'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'hold a post'
        ]);
        $leaveDay_ids = LeaveDay::select('leave_day_id')->get()->map(function($leaveDay) { return $leaveDay->leaveDay_id; })->toArray();
        $newId = RandomId::getNewId($leaveDay_ids);

        $post = LeaveDay::create([
            'leave_day_id' => $newId,
            'user_id' => $user_id,
            'should_break'=>0,
            'not_break' =>0,
            'has_break'=>0
        ]);
        return $registerPost;
    }
}
