<?php

namespace App\Http\Controllers;

use App\BusinessCar;
use App\BusinessTrip;
use App\Functions\RandomId;
use App\Invoice;
use App\OtherInvoice;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class BusinessTripController extends Controller
{
    public function index(){
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        $businessTrips = BusinessTrip::orderby('created_at', 'desc')->with('invoice')->with('otherinvoice')->with('user')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->invoices) != 0) {
                array_push($users, $allUser);
            }
        }
        $projects = Project::orderby('open_date', 'desc')->with('user')->get();
        
        return view('pm.businessTrip.index',['users'=>$users,'businessTrips'=>$businessTrips,'projects' => $projects]);
    }

    public function create(){
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->invoices) != 0) {
                array_push($users, $allUser);
            }
        }
        $reviewers = User::where('role','=','supervisor')->where('status','=','general')->get();
        $invoices = Invoice::orderby('created_at', 'desc')->with('project')->with('user')->get();
        $otherInvoices = OtherInvoice::orderby('created_at', 'desc')->with('user')->get();
        return view('pm.businessTrip.create',['users' => $users,'invoices' => $invoices,'otherInvoices' => $otherInvoices,'reviewers' => $reviewers]);
    }

    public function store(Request $request){
        $request->validate([
            'invoice_id' => 'required|string|size:11',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'start_date' =>'required|date',
            'end_date' =>'required|date',
            'other_content'=>'nullable|string|max:100',
            'fare_train' =>'nullable|integer',
            'fare_car' =>'nullable|integer',
            'fare_other' =>'nullable|integer',
            'meal_people' =>'nullable|integer',
            'meal_day' =>'nullable|integer',
            'meal_cost' =>'nullable|integer',
            'live_people' =>'nullable|integer',
            'live_day' =>'nullable|integer',
            'live_cost' =>'nullable|integer',
            'othercontent_1' => 'nullable|string',
            'othercontent_cost_1' =>'nullable|integer',
            'othercontent_2' => 'nullable|string',
            'othercontent_cost_2' =>'nullable|integer',
            'cost_total' => 'required|integer',
            'reviewer' => 'nullable|string',
            'invoice_type' =>'required|string'
        ]);
        $businessTrip_ids = BusinessTrip::select('businessTrip_id')->get()->map(function ($businessTrip) {
            return $businessTrip->businessTrip_id;
        })->toArray();
        $id = RandomId::getNewId($businessTrip_ids);
        $numbers = BusinessTrip::all();
        $i = 0;
        $max = 0;
        $check_id = (date('Y') - 1911) . date("m");

        foreach ($numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                if(substr($number['final_id'],-8,5) == $check_id){
                    $i++;
                    if ($number['no'] > $max) {
                        $max = $number['no'];
                    }
                }
            }
        }

        if ($max > $i) {
            $var = sprintf("%03d", $max + 1);
            $i = $max;
        } else {
            $var = sprintf("%03d", $i + 1);
        }
        $finished_id = "BT" . (date('Y') - 1911) . date("m") . $var;
        if(\Auth::user()->user_id != 'GRV00002'){
            $reviewer = 'GRV00002';
        }else{
            $reviewer = $request->input('reviewer');
        }
        
        if($request->input('invoice_type') == 'invoice'){
            $invoice = Invoice::where('finished_id',$request->input('invoice_id'))->first();
            $postInvoice_id = $invoice->invoice_id;
        }else if($request->input('invoice_type') == 'otherinvoice'){
            $otherinvoice = OtherInvoice::where('finished_id',$request->input('invoice_id'))->first();
            $postInvoice_id = $otherinvoice->other_invoice_id ;
        }

        $post = BusinessTrip::create([
            'businessTrip_id' => $id,
            'invoice_id' => $postInvoice_id,
            'invoice_type' => $request->input('invoice_type'),
            'user_id' => \Auth::user()->user_id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'other_content' =>$request->input('other_content'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'fare_train' => $request->input('fare_train'),
            'fare_car' =>$request->input('fare_car'),
            'fare_other' =>$request->input('fare_other'),
            'meal_people' =>$request->input('meal_people'),
            'meal_day' =>$request->input('meal_day'),
            'meal_cost' =>$request->input('meal_cost'),
            'live_people' =>$request->input('live_people'),
            'live_day' =>$request->input('live_day'),
            'live_cost' =>$request->input('live_cost'),
            'othercontent_1' =>$request->input('othercontent_1'),
            'othercontent_cost_1' =>$request->input('othercontent_cost_1'),
            'othercontent_2' =>$request->input('othercontent_2'),
            'othercontent_cost_2' =>$request->input('othercontent_cost_2'),
            'cost_total' =>$request->input('cost_total'),
            'reviewer' => $reviewer,
            'no' =>$i+1,
            'final_id' => $finished_id
        ]);
        return redirect()->route('businessTrip.show',$id);
    }

    public function show(string $businessTrip_id){
        $businessTrip = BusinessTrip::find($businessTrip_id);
        $reviewer = User::find($businessTrip->reviewer);
        $year = substr($businessTrip->created_at,0,4) - 1911;
        $month = substr($businessTrip->created_at,5,2);
        $day = substr($businessTrip->created_at,8,2);
        return view('pm.businessTrip.show',['businessTrip' => $businessTrip,'year'=>$year,'month'=>$month,'day'=>$day,'reviewer'=> $reviewer]);
    }

    public function edit(string $businessTrip_id){
        $businessTrip = BusinessTrip::find($businessTrip_id);
        $reviewer = User::find($businessTrip->reviewer);
        $reviewers = User::where('role','=','supervisor')->where('status','=','general')->get();

        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->invoices) != 0) {
                array_push($users, $allUser);
            }
        }
        $invoices = Invoice::orderby('created_at', 'desc')->with('project')->with('user')->get();
        $otherInvoices = OtherInvoice::orderby('created_at', 'desc')->with('user')->get();

        return view('pm.businessTrip.edit',['businessTrip'=>$businessTrip ,'users'=> $users,'reviewer'=>$reviewer,'reviewers'=>$reviewers,'invoices'=>$invoices,'otherInvoices'=> $otherInvoices ]);
    }

    public function update(Request $request,string $businessTrip_id){

        $businessTrip = BusinessTrip::find($businessTrip_id);
        $request->validate([
            'invoice_id' => 'required|string|size:11',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'start_date' =>'required|date',
            'end_date' =>'required|date',
            'other_content'=>'nullable|string|max:100',
            'fare_train' =>'nullable|integer',
            'fare_car' =>'nullable|integer',
            'fare_other' =>'nullable|integer',
            'meal_people' =>'nullable|integer',
            'meal_day' =>'nullable|integer',
            'meal_cost' =>'nullable|integer',
            'live_people' =>'nullable|integer',
            'live_day' =>'nullable|integer',
            'live_cost' =>'nullable|integer',
            'othercontent_1' => 'nullable|string',
            'othercontent_cost_1' =>'nullable|integer',
            'othercontent_2' => 'nullable|string',
            'othercontent_cost_2' =>'nullable|integer',
            'cost_total' => 'required|integer',
            'reviewer' => 'nullable|string',
            'invoice_type' =>'required|string'
        ]);
        if($request->input('invoice_type') == 'invoice'){
            $invoice = Invoice::where('finished_id',$request->input('invoice_id'))->first();
            $postInvoice_id = $invoice->invoice_id;
        }else if($request->input('invoice_type') == 'otherinvoice'){
            $otherinvoice = OtherInvoice::where('finished_id',$request->input('invoice_id'))->first();
            $postInvoice_id = $otherinvoice->other_invoice_id ;
        }
        
        $businessTrip->update($request->except('_method', '_token'));
        $businessTrip->invoice_id = $postInvoice_id;
        $businessTrip->save();
        return redirect()->route('businessTrip.show', $businessTrip_id);
    }

    public function delete(string $businessTrip_id){
        $businessTrip = BusinessTrip::find($businessTrip_id);
        $businessTrip->delete();
        return redirect()->route('businessTrip.index');
    }
}

