<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected function redirectTo()
    {
        if (auth()->user()->status == "fill") {
            return '/basicInformation';
        } else if (auth()->user()->status == "print") {
            return '/print';
        } else if (auth()->user()->status == "train" || auth()->user()->status == "train_OK") {
            return '/train';
            
        } else if (auth()->user()->status == "general") {
            return '/home';
        }
        
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login  username to be used by the controller.
     * 
     * @return string
     */
    public function username()
    {
        return 'account';
    }

    protected function attemptLogin(Request $request)
    {
        $active_user = User::where($this->username(), $request[$this->username()])
            ->where('status','!=',User::STATUS_Resign)->first();
        if ($active_user !== null) {
            return $this->guard()->attempt(
                $this->credentials($request), $request->has('remember')
            );
        }
        return false;
    }
  
}
