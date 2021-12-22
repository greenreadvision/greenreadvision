<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Customer;
use App\Functions\RandomId;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        $bank=Bank::all();
        $customer = Customer::orderby('updated_at', 'desc')->get();

        return view('pm.customer.index',['customer'=>$customer,'bank'=> $bank]);
    }

    public function store(Request $request){
        $customer_status = 0;
        $bank_status = 0;
        $bank_id = null;
        $request->validate([
            'name' => 'required|string',
            'bank_id' => 'nullable|string',
            'tax_id' => 'nullable|string',
            'address' => 'nullable|string',
            'principal' => 'required|string',
            'sex' => 'required|string',
            'phone' => 'required|string',
            'fax' => 'nullable|string',
            'email' => 'email|nullable|string',
            
        ]);
        if($request->input('bank_id') != null){     //有選擇舊有的Bank資料
            $bank_status = 1;
            $bank_update = Bank::find($request->input('bank_id'));
            $bank_update->update($request->except('_method', '_token'));
            $customers = Customer::select('id','bank_id')->get();
            foreach($customers as $item){
                if($item->bank_id == $request->input('bank_id')){   
                    $customer_status = 1;
                    $customer_id = $item->id;
                }
            }
            if($customer_status == 1){      //直接更新Customer(避免新增多個同樣名稱的資料)
                $customer = Customer::find($customer_id);
                $customer->update($request->except('_method', '_token'));
                $customer->name = $request->input('name');
                $customer->address = $request->input('address');
                $customer->tax_id = $request->input('tax_id');
                $customer->phone = $request->input('phone');
                $customer->principal = $request->input('principal');
                $customer->sex = $request->input('sex');
                $customer->fax = $request->input('fax');
                $customer->email = $request->input('email');
                $customer->save();
            }
        }else if($request->input('bank_id') == null && $request->input('bank_name') != null){    //沒有選擇舊有BANK資料，但有填寫BANK資料
            //建立新的BANK資料
            $bank_status = 0;
            $bank = Bank::select('name')->get();
            $request->validate([
                'bank' => 'required|string',
                'bank_branch' => 'required|string',
                'bank_account_number' => 'required|string',
                'bank_name' => 'required|string',
            ]);
            
            foreach($bank as $b){   //判定
                if($b->bank_account_name == $request->input('bank_name')){
                    $bank_status = 1;   //有舊有資料
                }
            }
            if($bank_status == 0){      //沒有舊有資料
                $bank_ids = Bank::select('bank_id')->get()->map(function ($bank) {
                    return $bank->bank_id;
                })->toArray();
                $bank_id = RandomId::getNewId($bank_ids);
                $post = Bank::create([
                    'bank_id' => $bank_id,
                    'name' => $request->input('name'),
                    'bank_account_name' => $request->input('bank_name'),
                    'bank' => $request->input('bank'),
                    'bank_branch' => $request->input('bank_branch'),
                    'bank_account_number' => $request->input('bank_account_number')
                ]);
            }   
        }
        if($customer_status == 0){      //如果沒有CUSTOMER舊有資料，要建立新的CUSTOMER
            $customers_ids = Customer::select('id')->get()->map(function ($customer) {
                return $customer->id;
            })->toArray();
            $id = RandomId::getNewId($customers_ids);
            $i = 0;
            $max = 0;
            $numbers = Customer::all();
            foreach($numbers->toArray() as $number){
                $i++;
                if ($number['no'] > $max) {
                    $max = $number['no'];
                }
            }
            if ($max > $i) {
                $var = sprintf("%04d", $max + 1);
                $i = $max;
            } else {
                $var = sprintf("%04d", $i + 1);
            }
            $finished_id = "CUS" . $var;

            if($bank_status != 0){  //有舊友BANK資料
                $bank_id = $request->input('bank_id');
            }
    
            $post = Customer::create([
                'id' => $id,
                'no' => $i+1,
                'bank_id' => $bank_id,
                'name' =>$request->input('name'),
                'address' => $request->input('address'),
                'principal' => $request->input('principal'),
                'sex' => $request->input('sex'),
                'tax_id' => $request->input('tax_id'),
                'customer_id' => $finished_id,
                'phone' =>  $request->input('phone'),
                'fax' => $request->input('fax'),
                'email' => $request->input('email')
            ]);
        }
        return redirect()->route('customer.index');
    }

    public function update(Request $request, String $customer_id){
        $customer = Customer::find($customer_id);
        $request->validate([
            'Customer_id' => 'required|string',
            'name' => 'required|string',
            'bank_id' => 'nullable|string',
            'principal' => 'required|string',
            'sex' => 'required|string',
            'tax_id' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'fax' => 'nullable|string',
            'email' => 'nullable|string'
        ]);
        $customer->update($request->except('_method', '_token'));
        if($request->input('bank_id') != null){
            $bank_update = Bank::find($request->input('bank_id'));
            $bank_update->update($request->except('_method', '_token'));

        }else if($request->input('bank_id') == null && $request->input('bank') != null){
            $bank_status = 0;
            $bank = Bank::select('name')->get();
            $request->validate([
                'bank' => 'required|string',
                'bank_branch' => 'required|string',
                'bank_account_number' => 'required|string',
                'bank_name' => 'required|string',
            ]);
            
            foreach($bank as $b){
                if($b->name == $request->input('bank_name')){
                    $bank_status = 1;
                }
            }
            if($bank_status == 0){
                $bank_ids = Bank::select('bank_id')->get()->map(function ($bank) {
                    return $bank->bank_id;
                })->toArray();
                $bank_id = RandomId::getNewId($bank_ids);
                $post = Bank::create([
                    'bank_id' => $bank_id,
                    'name' => $request->input('name'),
                    'bank_account_name' => $request->input('bank_name'),
                    'bank' => $request->input('bank'),
                    'bank_branch' => $request->input('bank_branch'),
                    'bank_account_number' => $request->input('bank_account_number')
                ]);
            }   
            $customer->bank_id = $bank_id;
            $customer->save();
        }
        return redirect()->route('customer.index');
    }
    public function destroy(String $customer_id){
        $customer = Customer::find($customer_id);
        $customer->delete();
        return redirect()->route('customer.index');
    }
}
