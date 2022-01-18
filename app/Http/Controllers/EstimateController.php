<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Estimate;
use App\Estimate_item;
use App\Functions\RandomId;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class EstimateController extends Controller
{
    public function index(){
        $estimate = Estimate::orderby('created_at', 'desc')->with('user')->with('project')->with('item')->get();
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->status !='resign' && $allUser->role!= 'intern') {
                array_push($users, $allUser);
            }
        }

        $project = Project::select('name','project_id','company_name')->where('status','=','running')->get();
        return view('pm.estimate.index',['users'=>$users,'estimate'=>$estimate,'projects'=>$project]);
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
        $projects = Project::select('project_id', 'name','company_name')->where('status','!=','close')->orderby('created_at', 'desc')->get();

        return view('pm.estimate.create', ['id' => $id, 'projects' => $projects, 'customer'=> $customer,'users'=>$users]);
    }

    public function store(Request $request){
        $estimates = Estimate::select('estimate_id')->get()->map(function ($estimate) {
            return $estimate->estimate_id;
        })->toArray();

        $request->validate([
            'estimate_id'=>'required|string',
            'company_name'=> 'required|string',
            'user' => 'required|string',
            'customer_name' => 'required|string',
            'customer_principal' => 'required|string',
            'customer_phone' => 'nullable|string',
            'customer_mail' => 'nullable|string',
            'active_title' => 'required|string',
            'project_id' => 'required|string',
            'newProject'=>'nullable|string'
        ]);


        //判定有沒有新的Customer
        $customer_status = 0;
        $customers = Customer::all();
        if($request->input('customer_id')==""||$request->input('customer_id')==null){   //有新版customer要新增
           
            foreach($customers as $c){   //查看公司名稱以及負責人有完全一樣的
                if($c->principal == $request->input('customer_name') && $c->principal == $request->input('customer_principal')){
                    $customer_status = 1;//有相同的但有用到keydown導致$request->input('customer_id')==''
                    $c->phone = $request->input('customer_phone');
                    $c->email = $request->input('customer_mail');
                }
            }
        }

        if($customer_status == 0){  //沒有相同的
            $j = 0;
            $max = 0;
            $item_num = $request->input("item_total_num");
            foreach ($customers->toArray() as $number) {
                $j++;
                if ($number['no'] > $max) {
                    $max = $number['no'];
                }
            }
            if ($max > $j) {
                $var = sprintf("%04d", $max + 1);
                $i = $max;
            } else {
                $var = sprintf("%04d", $j + 1);
            }
            $finished_id = "CUS" . $var;
            
            
            $customer = Customer::select('id')->get()->map(function ($customer) {
                return $customer->id;
            })->toArray();
            $customer_id = RandomId::getNewId($customer);

            Customer::create([
                'id' => $customer_id,
                'no' => $j,
                'customer_id' => $finished_id,
                'name' => $request->input('customer_name') ,
                'principal' => $request->input('customer_principal') ,
                'phone' => $request->input('customer_phone'),
                'email' => $request->input('customer_mail')
            ]);
        }
        //----------------

        //Estimate的NO計算
            $numbers = Estimate::all();
            $j = 0;
            $max = 0;
            $item_num = $request->input("item_total_num");
            foreach ($numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                    $j++;
                    if ($number['no'] > $max) {
                        $max = $number['no'];
                    }
                }
            }
            if ($max > $j) {
                $j = $max;
            }
        //----------------
        

        $estimate_id = RandomId::getNewId($estimates);
        $number = 0;
        for($i = 0 ;$i <= $item_num ; $i++){
            if($request->input('content-' . $i)!=null){
                $request->validate([
                    'content-'.$i => 'required|string|max:255',
                    'quantity-'.$i =>'required|integer',
                    'unit-'.$i => 'required|string',
                    'price-'.$i => 'required|integer',
                    'amount-'.$i => 'required|integer',
                    'note-'.$i => 'nullable|string'
                ]);
            }
        }
        for($i = 0 ;$i <= $item_num ; $i++){
            if($request->input('content-' . $i)!=null){
                $number++;
                Estimate_item::create([
                    'estimate_id'=>$estimate_id,
                    'no'=>$number,
                    'content' => $request->input('content-'.$i),
                    'quantity' => $request->input('quantity-'.$i),
                    'unit' => $request->input('unit-'.$i),
                    'price' => $request->input('price-'.$i),
                    'amount' => $request->input('amount-'.$i),
                    'note' => $request->input('note-'.$i)
                ]);
            }
        }


        if($request->input('project_id') == 'newProject'){
            $project_id = '';
            $active_name = $request->input('newProject');
        }else{
            $project_id = $request->input('project_id');
            $project = Project::find($request->input('project_id'));
            $active_name = $project->name;
        }

        Estimate::create([
            'estimate_id' => $estimate_id,
            'no' => $j,
            'final_id'=>$request->input('estimate_id'),
            'company_name' => $request->input('company_name'),
            'user_id' => $request->input('user'),
            'customer_id'=> $customer_id,
            'project_id' =>  $project_id,
            'active_title' => $request->input('active_title'),
            'active_name'=> $active_name,
            'total_price'=>$request->input('total_amount'),
            'status'=>'waitting',

        ]);

        return view('pm.estimate.index');       
    }
}
