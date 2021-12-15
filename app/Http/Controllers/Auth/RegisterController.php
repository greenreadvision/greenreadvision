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
    protected $redirectTo = '/basicInformation';

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
            'account' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|max:16|confirmed',
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
        $users = User::all();
        $staff_id = 'GRV'.sprintf("%05d",count($users));
        $registerPost= User::create([
            'user_id' => $staff_id,
            'account' => $data['account'],
            'role' => 'staff',
            'password' => Hash::make($data['password']),
            'status' => 'fill'
        ]);
        $leaveDay_ids = LeaveDay::select('leave_day_id')->get()->map(function($leaveDay) { return $leaveDay->leaveDay_id; })->toArray();
        $newId = RandomId::getNewId($leaveDay_ids);

        $post = LeaveDay::create([
            'leave_day_id' => $newId,
            'user_id' => $staff_id,
        ]);
        return $registerPost;
    }
}
