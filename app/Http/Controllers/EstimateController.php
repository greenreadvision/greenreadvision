<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Estimate;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class EstimateController extends Controller
{
    public function index(){
        return view('pm.estimate.index');
    }

    public function create(){
        $no = Estimate::all();
        $i = 0;
        $max = 0;
        foreach ($no->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                $i++;
                if ($number['no'] > $max) {
                    $max = $number['no'];
                }
            }
        }
        if ($max > $i) {
            $var = sprintf("%03d", $max + 1);
            $i = $max;
        } else {
            $var = sprintf("%03d", $i + 1);
        }
        $id = "ES" . (date('Y') - 1911) . date("m") . $var;
        $customer = Customer::all();
        $users = User::where('status','=','general')->where('role','!=','manager')->orderby('user_id')->get();
        $projects = Project::select('project_id', 'name','company_name')->orderby('created_at', 'desc')->get();
        $rv = Project::where('company_name', '=', 'rv')->where('status','=','running')->orderby('created_at', 'desc')->get();
        $grv2 = Project::where('company_name', '=', 'grv_2')->where('status','=','running')->orderby('created_at', 'desc')->get();

        return view('pm.estimate.create', ['id' => $id,'rv' => $rv,'grv2'=>$grv2, 'projects' => $projects, 'customer'=> $customer,'users'=>$users]);
    }

    public function store(Request $request){
        $estimates = Estimate::select('id')->get()->map(function ($estimate) {
            return $estimate->id;
        })->toArray();

        
    }
}
