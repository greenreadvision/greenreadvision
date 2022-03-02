<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\LeaveDay;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Functions\RandomId;
use App\Intern;
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

    public function basic()
    {
        return view('pm.user.basic');
    }
    public function basicStore(Request $request)
    {
        $ID_photo = null;
        $IDcard_front_path = null;
        $IDcard_back_path = null;
        $healthCard_front_path = null;
        $healthCard_back_path = null;

        $request->validate([
            'name' => 'required|string|min:1',
            'EN_name' => 'required|string|min:1',
            'nickname' => 'required|string|min:1',
            'sex' => 'required|string|min:1',
            'birthday' => 'required|date',
            'email' => 'required|string|min:1',
            'work_position' => 'required|string|min:2|max:20',
            'ID_photo' => 'required|file',
            'contact_person_name_1' => 'required|string|min:1',
            'contact_person_phone_1' => 'required|string|size:10',
            'contact_person_name_2' => 'nullable|string',
            'contact_person_phone_2' => 'nullable|string|size:10',
            'phone' => 'required|string',
            'celephone' => 'required|string|size:10',
            'is_marry' => 'required|string|size:1',
            'ID_number' => 'required|string|size:10',
            'residence_address' => 'required|string|max:100',
            'contact_address' => 'required|string|max:100',
            'IDcard_front_path' => 'required|file',
            'IDcard_back_path' => 'required|file',
            'healthCard_front_path' => 'required|file',
            'healthCard_back_path' => 'required|file',
            'arrival_date' => 'required|date',
            'bank_account_name' => 'required|string',
            'bank' =>  'required|string',
            'bank_branch' => 'required|string',
            'bank_account_number' => 'required|string',

        ]);

        $nickname = $request->input('nickname');
        $user_id = \Auth::user()->user_id;

        if ($request->hasFile('ID_photo')) {
            if ($request->ID_photo->isValid()) {
                \Illuminate\Support\Facades\Storage::delete(\Auth::user()->ID_photo);
                \Auth::user()->update(['ID_photo' => $request->ID_photo->storeAs($user_id.$nickname, $request->ID_photo->getClientOriginalName())]);
            }
        }
        if ($request->hasFile('IDcard_front_path')) {
            if ($request->IDcard_front_path->isValid()) {
                \Illuminate\Support\Facades\Storage::delete(\Auth::user()->IDcard_front_path);
                \Auth::user()->update(['IDcard_front_path' => $request->IDcard_front_path->storeAs($user_id.$nickname, $request->IDcard_front_path->getClientOriginalName())]);
            }
        }
        if ($request->hasFile('IDcard_back_path')) {
            if ($request->IDcard_back_path->isValid()) {
                \Illuminate\Support\Facades\Storage::delete(\Auth::user()->IDcard_back_path);
                \Auth::user()->update(['IDcard_back_path' => $request->IDcard_back_path->storeAs($user_id.$nickname, $request->IDcard_back_path->getClientOriginalName())]);
            }
        }
        if ($request->hasFile('healthCard_front_path')) {
            if ($request->healthCard_front_path->isValid()) {
                \Illuminate\Support\Facades\Storage::delete(\Auth::user()->healthCard_front_path);
                \Auth::user()->update(['healthCard_front_path' => $request->healthCard_front_path->storeAs($user_id.$nickname, $request->healthCard_front_path->getClientOriginalName())]);
            }
        }
        if ($request->hasFile('healthCard_back_path')) {
            if ($request->healthCard_back_path->isValid()) {
                \Illuminate\Support\Facades\Storage::delete(\Auth::user()->healthCard_back_path);
                \Auth::user()->update(['healthCard_back_path' => $request->healthCard_back_path->storeAs($user_id.$nickname, $request->healthCard_back_path->getClientOriginalName())]);
            }
        }
        \Auth::user()->update(['status' => "print"]);
        \Auth::user()->update($request->except('_method', '_token', 'ID_photo', 'IDcard_front_path', 'IDcard_back_path', 'healthCard_front_path', 'healthCard_back_path'));

        return redirect()->route('print');
        
    }
    public function print()
    {
        return view('pm.user.print');
    }

    public function printSet(){
        \Auth::user()->update(['status' => "train"]);
        return redirect()->route('activeTrain');
        
    }
    public function update(Request $request){
        \Auth::user()->update($request->except('_method', '_token'));
        return redirect()->route('profile');
    }

    public function staff()
    {
        $roles = ['supervisor','administrator','staff','intern'];
        $statuses = ['general','train_OK','resign'];
        $users = User::where([['role','!=','manager'],['role','!=','proprietor'],['status','!=','fill'],['status','!=','prints'],['status','!=','train']])->orderby('user_id')->get();

        return view('pm.user.staff',['users'=>$users,'roles'=>$roles,'statuses'=>$statuses]);
    }

    public function intern()
    {
        $interns = Intern::orderby('intern_id')->get();
        $number = 1;
        foreach($interns as $item){
            $number++;
        }
        $statuses = ['general','train_OK','resign'];
        return view('pm.user.intern',['interns' => $interns,'statuses' => $statuses,'number'=>$number]);
    }

    public function setRole(Request $request,String $id)
    {
        $user = User::find($id);
        

        $user->update($request->except('_method', '_token'));
        
        return redirect()->route('staff');
    }

    public function setRoleIntern(Request $request,String $id)
    {
        $intern = Intern::find($id);
        

        $intern->update($request->except('_method', '_token'));
        
        return redirect()->route('intern');
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        $password = Hash::make($request->input('password'));
        \Auth::user()->password = $password;
        \Auth::user()->save();
        \Auth::logout();
        return redirect()->route('login');
    } 

    public function setAccount(Request $request)
    {
        $request->validate([
            'account' => 'required|string|min:1',
        ]);
        \Auth::user()->account = $request->input('account');
        \Auth::user()->save();
        \Auth::logout();
        return redirect()->route('login');
    } 

    public function createIntern(Request $request)
    {
        echo "<script>console.log($request->input('create_intern_id'))</script>";
        $request->validate([
            'create_intern_id' => 'required|string|min:1',
            'create_name' => 'required|string|min:1',
            'create_nickname' => 'required|string|min:1',
            'create_email' => 'required|string|min:5',
            'create_status' => 'required|string'
        ]);
        

        $post = Intern::create([
            'intern_id' => $request->input('create_intern_id'),
            'name' => $request->input('create_name'),
            'nickname' => $request->input('create_nickname'),
            'email' => $request->input('create_email'),
            'status' => $request->input('create_status')
        ]);

        
       return redirect()->route('intern');
    }
}
