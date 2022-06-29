<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\Purchase;
use App\PurchaseItem;
use App\Invoice;
use App\OtherInvoice;
use App\Functions\RandomId;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class PurchaseController extends Controller
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
        //
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->purchases) != 0) {
                array_push($users, $allUser);
            }
        }
        $purchases = Purchase::orderby('purchase_date', 'desc')->with('project')->with('user')->get();
        return view('pm.purchase.indexPurchase', ['users' => $users, 'purchases' => $purchases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $no = Purchase::all();
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
        $id = "PO" . (date('Y') - 1911) . date("m") . $var;

        $projects = Project::select('project_id', 'name')->orderby('created_at', 'desc')->get()->toArray();
        $rv = Project::where('company_name', '=', 'rv')->orderby('created_at', 'desc')->get();
        $grv = Project::where('company_name', '=', 'grv')->orderby('created_at', 'desc')->get();
        $grv2 = Project::where('company_name', '=', 'grv_2')->orderby('created_at', 'desc')->get();

        return view('pm.purchase.createPurchase', ['id' => $id,'rv' => $rv,'grv' => $grv,'grv2'=>$grv2, 'projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $purchases = Purchase::select('purchase_id')->get()->map(function ($purchase) {
            return $purchase->purchase_id;
        })->toArray();

        $request->validate([
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'purchase_date' => 'required|date',
            'delivery_date' => 'required|date',
            'title' => 'required|string|min:1',
            'company1' => 'required|string|min:2|max:20',
            'contact_person' => 'required|string|min:1|max:20',
            'phone' => 'required|string',
            'fax' => 'nullable|string',
            'applicant' => 'required|string|min:1|max:5',
            'address' => 'required|string|min:1|max:50',
            'note' => 'nullable|string|min:1|max:500',
        ]);
        $purchase_id = RandomId::getNewId($purchases);



        $numbers = Purchase::all();
        $i = 0;
        $max = 0;
        $item_num = $request->input("item_total_num");
        foreach ($numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                $i++;
                if ($number['no'] > $max) {
                    $max = $number['no'];
                }
            }
        }

        if ($max > $i) {
            $i = $max;
        }
        $project = Project::find($request->input('project_id'));

        $j = 0;
        $number = 0;
        for ($j = 0; $j < $item_num + 1; $j++) {

            if ($request->input('content-' . $j) != null) {
                $number++;
                $request->validate([
                    'content-' . $j => 'required|string|min:1|max:50',
                    'quantity-' . $j => 'required|numeric',
                    'price-' . $j => 'required|numeric',
                    'note-' . $j => 'nullable|string|min:1|max:50'
                ]);
                PurchaseItem::create([
                    'purchase_id' => $purchase_id,
                    'no' => $number,
                    'content' => $request->input('content-' . $j),
                    'quantity' => $request->input('quantity-' . $j),
                    'price' => $request->input('price-' . $j),
                    'amount' => $request->input('quantity-' . $j) * $request->input('price-' . $j),
                    'note' => $request->input('note-' . $j)
                ]);
            }
        }
        $purchase_item = PurchaseItem::where('purchase_id', $purchase_id)->get();
        $temp = 0;
        foreach ($purchase_item as $data) {
            $temp += $data['price'] * $data['quantity'];
        }
        $post = Purchase::create([
            'purchase_id' => $purchase_id,
            'user_id' => \Auth::user()->user_id,
            'project_id' => $request->input('project_id'),
            'id' => $request->input('id'),
            'title' => $request->input('title'),
            'no' => $i + 1,
            'company_name' => $project->company_name,
            'company' => $request->input('company1'),
            'contact_person' => $request->input('contact_person'),
            'phone' => $request->input('phone'),
            'fax' => $request->input('fax'),
            'applicant' => $request->input('applicant'),
            'purchase_date' => $request->input('purchase_date'),
            'delivery_date' => $request->input('delivery_date'),
            'address' => $request->input('address'),
            'note' => $request->input('note'),
            'amount' => $request->input('amount'),
            'total_amount' => $request->input('total_amount'),
            'tex' => $request->input('tex'),
            // 'is_apply_money' => false,

        ]);



        return redirect()->route('purchase.review', $purchase_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(String $purchase_id)
    {
        //
        $purchase = Purchase::find($purchase_id);
        $purchase_item = PurchaseItem::where('purchase_id', $purchase_id)->get();
        $i = 0;
        foreach ($purchase_item as $data) {
            $i++;
        }

        $invoices = Invoice::where('purchase_id','=',$purchase->id)->get();
        $other_invoices = OtherInvoice::where('purchase_id','=',$purchase->id)->get();

        return view('pm.purchase.showPurchase', ['purchase' => $purchase, 'purchase_item' => $purchase_item, 'i' => $i,'invoices'=>$invoices,'other_invoices'=>$other_invoices]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(String $purchase_id)
    {
        //
        $purchase = Purchase::find($purchase_id);
        // $invoice->content = InvoiceController::replaceEnter(false, $invoice->content);
        $projects = Project::select('project_id', 'name')->get()->toArray();
        foreach ($projects as $key => $project) {
            $projects[$key]['selected'] = ($project['project_id'] == $purchase->project_id) ? "selected" : " ";
        }

        $purchase_item = PurchaseItem::where('purchase_id', $purchase_id)->get();
        $rv = Project::where('company_name', '=', 'rv')->orderby('created_at', 'desc')->get();
        $grv = Project::where('company_name', '=', 'grv')->orderby('created_at', 'desc')->get();
        $grv_2 = Project::where('company_name', '=', 'grv_2')->orderby('created_at', 'desc')->get();

        return view('pm.purchase.editPurchase', ['rv' => $rv,'grv' => $grv,'grv_2' => $grv_2,'purchase' => $purchase, 'projects' => $projects, 'purchase_item' => $purchase_item]);
    }


    public function update(Request $request, String $purchase_id)
    {
        $purchase = Purchase::find($purchase_id);
        $project = Project::find($request->input('project_id'));
        //
        $request->validate([
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'title' => 'required|string|min:1',
            'purchase_date' => 'required|date',
            'delivery_date' => 'required|date',
            'company' => 'required|string|min:2|max:20',
            'contact_person' => 'required|string|min:1|max:10',
            'phone' => 'required|string',
            'fax' => 'nullable|string',
            'applicant' => 'required|string|min:1|max:5',
            'address' => 'required|string|min:1|max:50',
            'note' => 'nullable|string|min:1|max:500',
        ]);

        

        $purchase->update($request->except('_method', '_token'));
        $purchase_item = PurchaseItem::where('purchase_id', $purchase_id)->get();
        $i = 1;
        foreach ($purchase_item as $item) {
            if ($request->input('content-' . $i) != null) {
                $item->content = $request->input('content-' . $i);
                $item->quantity = $request->input('quantity-' . $i);
                $item->price = $request->input('price-' . $i);
                $item->amount = $request->input('quantity-' . $i) * $request->input('price-' . $i);
                $item->note = $request->input('note-' . $i);
                $i++;
                $item->save();
            } else {
                $i++;
            }
        }
        $item_total_num = $request->input('item_total_num'); 
        for($j=count($purchase_item)+1 ; $j <= $item_total_num; $j++){
              
            if ($request->input('content-' . $j) != null) {
                PurchaseItem::create([
                    'purchase_id' => $purchase_id,
                    'no' => $j,
                    'content' => $request->input('content-' . $j),
                    'quantity' => $request->input('quantity-' . $j),
                    'price' => $request->input('price-' . $j),
                    'amount' => $request->input('quantity-' . $j) * $request->input('price-' . $j),
                    'note' => $request->input('note-' . $j)
                ]);
            }
        }

        $purchase_item = PurchaseItem::where('purchase_id', $purchase_id)->get();
        $temp = 0;
        foreach ($purchase_item as $data) {
            $temp += $data['price'] * $data['quantity'];
        }
        $purchase->company_name = $project->company_name;
        $purchase->amount = $request->input('amount');
        $purchase->tex = $request->input('tex');
        $purchase->total_amount = $request->input('total_amount');
        $purchase->save();
        // if (!$request->input('receipt')){
        //     $event = InvoiceEvent::where('invoice_id', $invoice_id)->get()[0];
        //     EventController::update($event->event_id, $request->input('receipt_date'));
        // }
        return redirect()->route('purchase.review', $purchase_id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $purchase_id)
    {
        //Delete the invoice
        $purchase_delete = Purchase::find($purchase_id);
        $allPurchase = Purchase::orderby('created_at', 'desc')->get();
        //刪除外部invoice含有此刪除報價單的
        $invoice = Invoice::where('purchase_id','=',$purchase_delete->id)->get();
        $otherinvoice = OtherInvoice::where('purchase_id','=',$purchase_delete->id)->get();
        foreach($invoice as $item){
            $item->purchase_id = null;
            $item->save();
        }
        foreach($otherinvoice as $item){
            $item->purchase_id = null;
            $item->save();
        }
        
        $purchase_delete->delete();

        return redirect()->route('purchase.index');
    }

    public function destroyItem(String $purchase_id, String $no)
    {
        //Delete the invoice
        $purchase_item = PurchaseItem::find($no);
        $purchase_item->delete();
        return redirect()->route('purchase.edit', $purchase_id);
    }

    public function list(string $projects_id)
    {
        //
        $project_ids = Purchase::select('project_id')->orderby('project_id')->distinct()->get();
        $purchase_groups = [];

        foreach ($project_ids->toArray() as $project_id) {
            array_push($purchase_groups, Purchase::where('project_id', $project_id)->orderby('created_at', 'desc')->with('project')->get());
        }


        $temp = "";
        $years = [];

        $purchases = Purchase::orderby('created_at', 'desc')->get();

        foreach ($purchases as $data) {
            if ($data->project_id == $projects_id) {
                $stateYear = 0;

                $temp = substr($data->created_at, 0, 4);
                foreach ($years as $year) {
                    if (substr($data->created_at, 0, 4) == $year) {
                        $stateYear = 1;
                    }
                }
                if ($stateYear == 0) {
                    array_push($years, substr($data->created_at, 0, 4));
                }
            }
        }
        $months = [];
        foreach ($purchases as $data) {
            if ($data->project_id == $projects_id) {
                $stateMonth = 0;

                $temp = substr($data->created_at, 0, 7);
                foreach ($months as $month) {
                    if (substr($data->created_at, 0, 7) == $month) {
                        $stateMonth = 1;
                    }
                }
                if ($stateMonth == 0) {
                    array_push($months, substr($data->created_at, 0, 7));
                }
            }
        }

        // $invoices = Invoice::where('user_id', \Auth::user()->user_id)->orderby('project_id')->with('project')->get();
        return redirect()->route('purchase.index');
    }
}
