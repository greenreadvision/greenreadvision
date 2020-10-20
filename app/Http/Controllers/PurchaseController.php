<?php

namespace App\Http\Controllers;

use App\Company;
use App\Project;
use App\Purchase;
use App\PurchaseItem;

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
        $project_ids = Purchase::select('project_id')->orderby('project_id')->distinct()->get();
        $purchase_groups = [];
        foreach ($project_ids->toArray() as $project_id) {
            array_push($purchase_groups, Purchase::where('project_id', $project_id)->orderby('created_at')->with('project')->get());
        }
        $project = Project::orderby('open_date', 'desc')->get();
        $temp = "";
        $years = [];

        foreach ($project as $data) {
            $state = 0;

            $temp = substr($data->open_date, 0, 4);
            foreach ($years as $year) {
                if (substr($data->open_date, 0, 4) == $year) {
                    $state = 1;
                }
            }
            if ($state == 0) {
                array_push($years, substr($data->open_date, 0, 4));
            }
        }
        return view('pm.purchase.indexPurchase', ['purchase_groups' => $purchase_groups, 'years' => $years, 'state' => $state]);
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

        $projects = Project::select('project_id', 'name')->get()->toArray();

        return view('pm.purchase.createPurchase', ['id' => $id, 'projects' => $projects]);
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
            'company1' => 'required|string|min:2|max:20',
            'contact_person' => 'required|string|min:1|max:20',
            'phone' => 'required|string|size:10',
            'fax' => 'required|string|size:10',
            'applicant' => 'required|string|min:1|max:5',
            'address' => 'required|string|min:1|max:50',
            'note' => 'nullable|string|min:1|max:500',
        ]);
        $purchase_id = RandomId::getNewId($purchases);



        $numbers = Purchase::all();
        $i = 0;
        $max = 0;
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
        for ($j = 0; $j < 10; $j++) {
            
            if ($request->input('content-' . $j) != null) {
                $number++;
                $request->validate([
                    'content-'.$j => 'required|string|min:1|max:50',
                    'quantity-'.$j => 'required|integer',
                    'price-'.$j => 'required|integer',
                    'note-'.$j => 'nullable|string|min:1|max:50'
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
            'amount' => $temp,
            'total_amount' => $temp,
            'tex' => 0,
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
        return view('pm.purchase.showPurchase', ['purchase' => $purchase, 'purchase_item' => $purchase_item, 'i' => $i]);
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
        return view('pm.purchase.editPurchase', ['purchase' => $purchase, 'projects' => $projects, 'purchase_item' => $purchase_item]);
    }


    public function update(Request $request, String $purchase_id)
    {
        $purchase = Purchase::find($purchase_id);
        //
        $request->validate([
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'purchase_date' => 'required|date',
            'delivery_date' => 'required|date',
            'company' => 'required|string|min:2|max:20',
            'contact_person' => 'required|string|min:1|max:10',
            'phone' => 'required|string|size:10',
            'fax' => 'required|string|size:10',
            'applicant' => 'required|string|min:1|max:5',
            'address' => 'required|string|min:1|max:50',
            'note' => 'nullable|string|min:1|max:500',
        ]);

        $purchase->update($request->except('_method', '_token'));
        $purchase_item = PurchaseItem::where('purchase_id', $purchase_id)->get();
        $i = 1;
        foreach ($purchase_item as $item) {
            if ($request->input('content' . $i) != null) {
                $item->content = $request->input('content' . $i);
                $item->quantity = $request->input('quantity' . $i);
                $item->price = $request->input('price' . $i);
                $item->note = $request->input('note' . $i);
                $i++;
                $item->save();
            } else {
                $i++;
            }
        }
        for ($j = 0; $j < 30 - $i; $j++) {
            if ($request->input('content-' . $j) != null) {
                PurchaseItem::create([
                    'purchase_id' => $purchase_id,
                    'no' => $i + $j,
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
        $purchase->amount = $temp;
        $purchase->total_amount = $temp;
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
        $purchase = Purchase::find($purchase_id);
        foreach ($purchase->purchaseItem as $item) {
            $item->delete();
        }
        $purchase->delete();

        return redirect()->route('purchase.list', $purchase['project_id']);
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
        return view('pm.purchase.listPurchase', ['purchase_groups' => $purchase_groups, 'projects_id' => $projects_id, 'years' => $years, 'months' => $months]);
    }
}
