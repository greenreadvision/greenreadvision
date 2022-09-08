<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\User;
use App\Goods;
use App\Functions\RandomId;
use App\Project;
use App\Intern

;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use LengthException;

class GoodsController extends Controller
{
    /**
     * Fix textarea data without wrap from front_end.
     */
    // private function replaceEnter(Bool $database, String $content)
    // {
    //     if ($database)
    //         return str_replace("\n", "<br />", str_replace("\r\n", "<br />", $content));
    //     else
    //         return str_replace("<br />", "\n", $content);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
  
        {
        $users = [];
        $allUsers = User::orderby('nickname')->with('goods')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->status != 'resign') {
                array_push($users, $allUser);
            }
        }
        $purchases = Purchase::orderby('created_at', 'desc')->get();

        $goods = Goods::orderby('created_at', 'desc')->with('purchases.project')->with('user')->get();

        return view('pm.goods.index', ['goods' => $goods, 'users' => $users]);
    }
    public function create()
    {
        $users = [];
        $allUsers = User::orderby('nickname')->get();
        $interns = Intern::all();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->role != 'resigned') {
                array_push($users, $allUser);
            }
        }
        $purchases = Purchase::orderby('purchase_date', 'desc')->with('project')->with('user')->get();
        return view('pm.goods.create', ['users' => $users, 'purchases' => $purchases, 'interns' => $interns]);
    }
    public function store(Request $request)
    {
        //
        // $freight_bill_path = null;
        // $freight_exterior_path = null;
        // $all_goods_path = null;
        // $single_good_path = null;
        // $defect_goods_path = null;

        $goods_ids = Goods::select('goods_id')->get()->map(function ($good) {
            return $good->goods_id;
        })->toArray();

        $request->validate([
            'purchase_id' => 'nullable|exists:purchases,id',
            'freight_name' => 'required|string|min:1|max:255',
            'delivery_number' => 'required|string|min:1|max:50',
            'good_name' => 'required|string|min:1|max:255',
            // 'quantity' => 'nullable|integer',
            // 'random_inspection' => 'nullable|integer',
            // 'defect' => 'nullable|integer',
            // 'freight_bill' => 'nullable|file',
            // 'freight_exterior' => 'nullable|file',
            // 'all_goods' => 'nullable|file',
            // 'single_good' => 'nullable|file',
            // 'defect_goods' => 'nullable|file',
            // 'remark'=>'nullable|string'
        ]);

        // if ($request->hasFile('freight_bill')) {
        //     if ($request->freight_bill->isValid()) {
        //         $freight_bill_path = $request->freight_bill->storeAs('goods', $request->freight_bill->getClientOriginalName());
        //     }
        // }
        // if ($request->hasFile('freight_exterior')) {
        //     if ($request->freight_exterior->isValid()) {
        //         $freight_exterior_path = $request->freight_exterior->storeAs('goods', $request->freight_exterior->getClientOriginalName());
        //     }
        // }
        // if ($request->hasFile('all_goods')) {
        //     if ($request->all_goods->isValid()) {
        //         $all_goods_path = $request->all_goods->storeAs('goods', $request->all_goods->getClientOriginalName());
        //     }
        // }
        // if ($request->hasFile('single_good')) {
        //     if ($request->single_good->isValid()) {
        //         $single_good_path = $request->single_good->storeAs('goods', $request->single_good->getClientOriginalName());
        //     }
        // }
        // if ($request->hasFile('defect_goods')) {
        //     if ($request->defect_goods->isValid()) {
        //         $defect_goods_path = $request->defect_goods->storeAs('goods', $request->defect_goods->getClientOriginalName());
        //     }
        // }
        $id = RandomId::getNewId($goods_ids);
        $purchase_id = Null;
        if($request->input('purchase_id') != ''){
            $purchase = Purchase::where('id', '=', $request->input('purchase_id'))->get();
            $purchase_id = $purchase[0]->purchase_id;
        }

        $intern = null;
        if($request->input('signer')=='實習生'){
            $intern = $request->input('intern');
        }

        $post = Goods::create([
            'goods_id' => $id,
            'purchase_id' => $purchase_id,
            'user_id' => \Auth::user()->user_id,
            'signer' => $request->input('signer'),
            'intern' => $intern,
            'receipt_date' => $request->input('receipt_date'),
            'good_name' => $request->input('good_name'),
            'freight_name' => $request->input('freight_name'),
            'delivery_number' => $request->input('delivery_number'),
            // 'quantity' => $request->input('quantity'),
            // 'random_inspection' => $request->input('random_inspection'),
            // 'defect' => $request->input('defect'),
            // 'inventory_name' => $request->input('inventory_name'),
            // 'freight_bill' => $freight_bill_path,
            // 'freight_exterior' => $freight_exterior_path,
            // 'all_goods' => $all_goods_path,
            // 'single_good' => $single_good_path,
            // 'defect_goods' => $defect_goods_path,
            // 'remark' => $request->input('remark'),
        ]);

        return redirect()->route('goods.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(String $id)
    {
        //
        $good = Goods::find($id);
        $users = [];
        $interns = Intern::all();
        $allUsers = User::orderby('nickname')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->role != 'resigned') {
                array_push($users, $allUser);
            }
        }
        $purchases = Purchase::orderby('purchase_date', 'desc')->with('project')->with('user')->get();

        $purchase = null;
        
        $purchase_id = null;
        if ($good->purchase_id != null){
            $purchase = Purchase::find($good->purchase_id);
            $purchase_id = $purchase->id;
        }
        // $invoice->content = InvoiceController::replaceEnter(false, $invoice->content);
        if ($good->freight_bill != null) $good->freight_bill = explode('/', $good->freight_bill);
        if ($good->freight_exterior != null) $good->freight_exterior = explode('/', $good->freight_exterior);
        if ($good->all_goods != null) $good->all_goods = explode('/', $good->all_goods);
        if ($good->single_good != null) $good->single_good = explode('/', $good->single_good);
        if ($good->defect_goods != null) $good->defect_goods = explode('/', $good->defect_goods);

        return view('pm.goods.show', ['good' => $good, 'users' => $users,'purchases' => $purchases, 'purchase_id' => $purchase_id, 'interns' => $interns]);
    }

    public function update(Request $request, String $id, String $type)
    {

        $good = Goods::find($id);

        switch ($type) {
            case "purchase":
                $purchase = Purchase::where('id', '=', $request->input('purchase_id'))->get();
                $good->purchase_id =  $purchase[0]->purchase_id;
                $good->save();
                break;
            case "signer":
                $good->update($request->except('_method', '_token'));
                break;
            case "freightName":
                $request->validate([
                    'freight_name' => 'required|string|min:1|max:255'
                ]);
                $good->update($request->except('_method', '_token'));
                break;
            case "deliveryNumber":
                $request->validate([
                    'delivery_number' => 'required|string|min:1|max:50'
                ]);
                $good->update($request->except('_method', '_token'));
                break;
            case "quantity":
                $request->validate([
                    'quantity' => 'nullable|integer',
                    'random_inspection' => 'nullable|integer',
                    'defect' => 'nullable|integer',
                ]);
                $good->update($request->except('_method', '_token'));
                break;
            case "goodName":
                $request->validate([
                    'good_name' => 'required|string|min:1|max:255'
                ]);
                $good->update($request->except('_method', '_token'));
                break;
            case "remark":
                $request->validate([
                    'remark' => 'nullable|string'
                ]);
                $good->update($request->except('_method', '_token'));
                break;
            case "allGood":
                if ($request->hasFile('allGood')) {
                    if ($request->allGood->isValid()) {
                        $path = $request->allGood->storeAs('good', $request->allGood->getClientOriginalName());
                        $good->all_goods = $path;
                        $good->save();
                    }
                }

                break;
            case "singleGood":
                if ($request->hasFile('singleGood')) {
                    if ($request->singleGood->isValid()) {
                        $path = $request->singleGood->storeAs('good', $request->singleGood->getClientOriginalName());
                        $good->single_good = $path;
                        $good->save();
                    }
                }

                break;
            case "defectGood":
                if ($request->hasFile('defectGood')) {
                    if ($request->defectGood->isValid()) {
                        $path = $request->defectGood->storeAs('good', $request->defectGood->getClientOriginalName());
                        $good->defect_goods = $path;
                        $good->save();
                    }
                }

                break;
            case "freightExterior":
                if ($request->hasFile('freightExterior')) {
                    if ($request->freightExterior->isValid()) {
                        $path = $request->freightExterior->storeAs('good', $request->freightExterior->getClientOriginalName());
                        $good->freight_exterior = $path;
                        $good->save();
                    }
                }

                break;
            case "freightBill":
                if ($request->hasFile('freightBill')) {
                    if ($request->freightBill->isValid()) {
                        $path = $request->freightBill->storeAs('good', $request->freightBill->getClientOriginalName());
                        $good->freight_bill = $path;
                        $good->save();
                    }
                }

                break;
            default:
                break;
        }
        // $request->validate([
        //     // 'purchase_id' => 'required|exists:purchases,id',

        //     'good_name' => 'required|string|min:1|max:255',

        //     'freight_bill' => 'nullable|file',
        //     'freight_exterior' => 'nullable|file',
        //     'all_goods' => 'nullable|file',
        //     'single_good' => 'nullable|file',
        //     'defect_goods' => 'nullable|file',
        //     'remark'=>'nullable|string'
        // ]);
        // $good->update($request->except('_method', '_token'));

        // if ($request->hasFile('freight_bill')) {
        //     if ($request->freight_bill->isValid()) {
        //         \Illuminate\Support\Facades\Storage::delete($good->freight_bill);
        //         $good->update(['freight_bill' => $request->freight_bill->storeAs('freight_bill',$request->freight_bill->getClientOriginalName())]);
        //     }
        // }
        // if ($request->hasFile('freight_exterior')) {
        //     if ($request->freight_exterior->isValid()) {
        //         \Illuminate\Support\Facades\Storage::delete($good->freight_exterior);
        //         $good->update(['freight_exterior' => $request->freight_exterior->storeAs('freight_exterior',$request->freight_exterior->getClientOriginalName())]);
        //     }
        // }
        // if ($request->hasFile('all_goods')) {
        //     if ($request->all_goods->isValid()) {
        //         \Illuminate\Support\Facades\Storage::delete($good->all_goods);
        //         $good->update(['all_goods' => $request->all_goods->storeAs('all_goods',$request->all_goods->getClientOriginalName())]);
        //     }
        // }
        // if ($request->hasFile('single_good')) {
        //     if ($request->single_good->isValid()) {
        //         \Illuminate\Support\Facades\Storage::delete($good->single_good);
        //         $good->update(['single_good' => $request->single_good->storeAs('single_good',$request->single_good->getClientOriginalName())]);
        //     }
        // }
        // if ($request->hasFile('defect_goods')) {
        //     if ($request->defect_goods->isValid()) {
        //         \Illuminate\Support\Facades\Storage::delete($good->defect_goods);
        //         $good->update(['defect_goods' => $request->defect_goods->storeAs('defect_goods',$request->defect_goods->getClientOriginalName())]);
        //     }
        // }

        return redirect()->route('goods.show', $id);
    }

    public function destroy(String $id)
    {

        //Delete the invoice
        $good = Goods::find($id);
        \Illuminate\Support\Facades\Storage::delete([$good->freight_bill, $good->freight_exterior, $good->all_goods, $good->single_good, $good->defect_goods]);

        $good->delete();
        return redirect()->route('goods.index');
    }
}
