<?php

namespace App\Http\Controllers;

use App\Company;
use App\Project;
use App\Invoice;
use App\Bank;
use App\User;
use App\Letters;
use App\Functions\RandomId;
use App\Http\Controllers\EventController;
use App\OtherInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use LengthException;

class InvoiceController extends Controller
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
        $type = ['salary', 'insurance', 'other'];

        $project_ids = Invoice::select('project_id')->orderby('project_id')->distinct()->get();
        $invoice_groups = [];
        foreach ($project_ids->toArray() as $project_id) {
            array_push($invoice_groups, Invoice::where('project_id', $project_id)->orderby('created_at')->with('project')->get());
        }
        $otherInvoice = OtherInvoice::all();
        // $invoices = Invoice::where('user_id', \Auth::user()->user_id)->orderby('project_id')->with('project')->get();
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
        $invoice = Invoice::orderby('created_at','desc')->get();
        $nickname = User::all();
    
        return view('pm.invoice.indexInvoice', ['invoice_groups' => $invoice_groups, 'otherInvoice' => $otherInvoice, 'type' => $type, 'years' => $years,'invoice' => $invoice,'nickname' => $nickname]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $bank = Bank::all();
        $company = Company::orderby('number')->get();
        $projects = Project::select('project_id', 'name', 'finished')->get()->toArray();
        return view('pm.invoice.createInvoice')->with('data', ['projects' => $projects, 'company' => $company,'bank'=>$bank]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $receipt_file_path = null;
        $detail_file_path = null;
        // $created_at = now();
        $invoice_ids = Invoice::select('invoice_id')->get()->map(function ($invoice) {
            return $invoice->invoice_id;
        })->toArray();

        $request->validate([
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'company' => 'required|string|min:1|max:255',
            'bank' => 'required|string|min:2|max:255',
            'bank_branch' => 'required|string|min:2|max:255',
            'bank_account_number' => 'required|string|min:2|max:255',
            'bank_account_name' => 'required|string|min:2|max:255',
            'receipt' => 'required|Boolean',
            'receipt_date' => 'required|date',
            'remuneration' => 'required|integer',
            'price' => 'required|integer',
            'receipt_file' => 'nullable|file',
            'detail_file' => 'nullable|file',
            'purchase_id' => 'nullable|string'
        ]);

        if ($request->hasFile('receipt_file')) {
            if ($request->receipt_file->isValid()) {
                $receipt_file_path = $request->receipt_file->store('receipts');
            }
        }
        if ($request->hasFile('detail_file')) {
            if ($request->detail_file->isValid()) {
                $detail_file_path = $request->detail_file->store('details');
            }
        }

        $id = RandomId::getNewId($invoice_ids);

        $numbers = Invoice::all();
        $i = 0;
        $max = 0;
        foreach ($numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                $i++;
                if ($number['number'] > $max) {
                    $max = $number['number'];
                }
            }
        }
        $other_numbers = OtherInvoice::all();
        foreach ($other_numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                $i++;
                if ($number['number'] > $max) {
                    $max = $number['number'];
                }
            }
        }
        if ($max > $i) {
            $var = sprintf("%03d", $max + 1);
            $i = $max;
        } else {
            $var = sprintf("%03d", $i + 1);
        }

        $finished_id = "IA" . (date('Y') - 1911) . date("m") . $var;
        $project = Project::find($request->input('project_id'));
        $post = Invoice::create([
            'invoice_id' => $id,
            'user_id' => \Auth::user()->user_id,
            'project_id' => $request->input('project_id'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'number' => $i + 1,
            // 'content' => InvoiceController::replaceEnter(true, $request->input('content')),
            'company_name' => $project->company_name,
            'company' => $request->input('company'),
            'bank' => $request->input('bank'),
            'bank_branch' => $request->input('bank_branch'),
            'bank_account_number' => $request->input('bank_account_number'),
            'bank_account_name' => $request->input('bank_account_name'),
            'receipt' => $request->input('receipt'),
            'receipt_date' => $request->input('receipt_date'),
            'remuneration' => $request->input('remuneration'),
            'price' => $request->input('price'),
            'receipt_file' => $receipt_file_path,
            'detail_file' => $detail_file_path,
            'status' => 'waiting',
            'finished_id' => $finished_id,
            'purchase_id' => $request->input('purchase_id')
        ]);

        // if(!$request->input('receipt')){
        //     EventController::create($request->input('receipt_date'), __('customize.receipt'), __('customize.receipt_date'), __('customize.Invoice'), 'invoice', $id);
        // }


        // fix server getting wrong timezone
        // Invoice::where('invoice_id', $id)->update(['created_at' => $created_at, 'updated_at' => $created_at,]);
        $project_ids = Invoice::select('project_id')->orderby('project_id')->distinct()->get();
        $invoice_groups = [];
        foreach ($project_ids->toArray() as $project_id) {
            array_push($invoice_groups, Invoice::where('project_id', $project_id)->orderby('created_at', 'desc')->with('project')->get());
        }
        // $invoices = Invoice::where('user_id', \Auth::user()->user_id)->orderby('project_id')->with('project')->get();
        // return view('pm.invoice.listInvoice',['invoice_groups'=>$invoice_groups,'projects_id'=> $request->input('project_id')]);

        Mail::raw(route('invoice.review', $id), function ($message) {
            $message->from('greenreadvision2020@gmail.com', 'greenreadvision');
            $message->to('jillianwu@grv.com.tw')->subject(\Auth::user()->name.'新增了一筆帳務');
        });
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => 'gLrgYjtBxxL',
            'title' => \Auth::user()->nickname.' 在 『'.$project->name.'』 新增一筆請款，待審核。',
            'reason' => '',
            'content' => '前往第一階段審核',
            'link' => route('invoice.review', $id),
            'status' => 'not_read',
        ]);

        
        return redirect()->route('invoice.list', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(String $invoice_id)
    {
        //
        $invoice = Invoice::find($invoice_id);
        // $invoice->content = InvoiceController::replaceEnter(false, $invoice->content);
        if ($invoice->receipt_file != null) $invoice->receipt_file = explode('/', $invoice->receipt_file);
        if ($invoice->detail_file != null) $invoice->detail_file = explode('/', $invoice->detail_file);
        return view('pm.invoice.showInvoice')->with('data', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(String $invoice_id)
    {
        //
        $type = ['salary', 'insurance', 'other'];
        $company_name = ['grv', 'rv'];
        $invoice = Invoice::find($invoice_id);
        // $invoice->content = InvoiceController::replaceEnter(false, $invoice->content);
        $projects = Project::select('project_id', 'name', 'finished')->get()->toArray();
        foreach ($projects as $key => $project) {
            $projects[$key]['selected'] = ($project['project_id'] == $invoice->project_id) ? "selected" : " ";
        }
        return view('pm.invoice.editInvoice')->with('data', ['invoice' => $invoice->toArray(), 'projects' => $projects, 'type' => $type, 'company_name' => $company_name]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        //
        $request->validate([
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'content' => 'required|string|min:1|max:100',
            'company_name' => 'required|string|min:2|max:255',
            'company' => 'required|string|min:2|max:255',
            'bank' => 'required|string|min:2|max:255',
            'bank_branch' => 'required|string|min:2|max:255',
            'bank_account_number' => 'required|string|min:2|max:255',
            'bank_account_name' => 'required|string|min:2|max:255',
            'receipt' => 'required|Boolean',
            'receipt_date' => 'required|date',
            'remuneration' => 'required|integer',
            // 'number' => 'required|integer',
            'price' => 'required|integer',
            'receipt_file' => 'nullable|file',
            'detail_file' => 'nullable|file'
        ]);

        $invoice->update($request->except('_method', '_token', 'receipt_file', 'detail_file'));
        // Invoice::where('invoice_id', $invoice_id)->updated_at = now();

        if ($request->hasFile('receipt_file')) {
            if ($request->receipt_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($invoice->receipt_file);
                $invoice->update(['receipt_file' => $request->receipt_file->store('receipts')]);
            }
        }
        if ($request->hasFile('detail_file')) {
            if ($request->detail_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($invoice->detail_file);
                $invoice->update(['detail_file' => $request->detail_file->store('details')]);
            }
        }

        // if (!$request->input('receipt')){
        //     $event = InvoiceEvent::where('invoice_id', $invoice_id)->get()[0];
        //     EventController::update($event->event_id, $request->input('receipt_date'));
        // }
        return redirect()->route('invoice.review', $invoice_id);
    }
    public function fix(Request $request, String $invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        //
        $request->validate([
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'company_name' => 'required|string|min:2|max:255',
            'company' => 'required|string|min:2|max:255',
            'bank' => 'required|string|min:2|max:255',
            'bank_branch' => 'required|string|min:2|max:255',
            'bank_account_number' => 'required|string|min:2|max:255',
            'bank_account_name' => 'required|string|min:2|max:255',
            'receipt' => 'required|Boolean',
            'receipt_date' => 'required|date',
            'remuneration' => 'required|integer',
            // 'number' => 'required|integer',
            'price' => 'required|integer',
            'receipt_file' => 'nullable|file',
            'detail_file' => 'nullable|file'
        ]);

        $invoice->update($request->except('_method', '_token', 'receipt_file', 'detail_file'));
        // Invoice::where('invoice_id', $invoice_id)->updated_at = now();
        if($invoice->status == "waiting-fix"){
            $invoice->status = "waiting";
            $invoice->save();
            $user_id= 'gLrgYjtBxxL';
        }
        else if($invoice->status == "check-fix"){
            $invoice->status = "check";
            $invoice->save();
            $user_id= 'HVcHQDmRwNp';
        }
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $user_id,
            'title' => \Auth::user()->nickname.' 已修改在 『'.$invoice->project->name.'』 的一筆請款，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('invoice.review', $invoice_id),
            'status' => 'not_read',
        ]);
        if ($request->hasFile('receipt_file')) {
            if ($request->receipt_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($invoice->receipt_file);
                $invoice->update(['receipt_file' => $request->receipt_file->store('receipts')]);
            }
        }
        if ($request->hasFile('detail_file')) {
            if ($request->detail_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($invoice->detail_file);
                $invoice->update(['detail_file' => $request->detail_file->store('details')]);
            }
        }

       
        return redirect()->route('invoice.review', $invoice_id);
    }
    public function withdraw(Request $request, String $invoice_id)
    {
        // return $request->finished_id;
        $invoice = Invoice::find($invoice_id);

        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $invoice->user_id,
            'title' => '您在 『'.$invoice->project->name.'』 的一筆請款被退回。',
            'reason' => $request->input('reason'),
            'content' => '前往修改',
            'link' => route('invoice.edit', $invoice_id),
            'status' => 'not_read',
        ]);
        //accountant
        if ($invoice->status == 'waiting') {
            $invoice->status = 'waiting-fix';
            $invoice->save();


        } elseif ( $invoice->status == 'check') {
            $invoice->status = 'check-fix';
            $invoice->save();
        }

       
        return redirect()->route('invoice.review', $invoice_id);
    }
    /**
     * Match the invoices and update the status by accountant and manager.
     *
     * @param \App\Invoice  $invoice
     */
    public function match(Request $request, String $invoice_id)
    {
        // return $request->finished_id;
        $invoice = Invoice::find($invoice_id);

        //accountant
        if (\Auth::user()->role == 'accountant' && $invoice->status == 'waiting') {
            $invoice->status = 'check';

            // $invoice->finished_id = $request->finished_id;
            // $invoice->managed = \Auth::user()->name;
            $invoice->save();
            Mail::raw(route('invoice.review', $invoice_id), function ($message) use ($invoice_id) {
                $invoice = Invoice::find($invoice_id);

                $message->from('greenreadvision2020@gmail.com', 'greenreadvision');
                $message->to('jillianwu@grv.com.tw')->subject($invoice->project->name . '的一筆帳務待審核');
            });
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => 'HVcHQDmRwNp',
                'title' => $invoice->user->nickname.' 在 『'.$invoice->project->name.'』的一筆請款已通過第一階段審核。',
                'reason' => '',
                'content' => '前往第二階段審核',
                'link' => route('invoice.review', $invoice_id),
                'status' => 'not_read',
            ]);
        } elseif (\Auth::user()->role == 'manager' && $invoice->status == 'check') {
            $invoice->status = 'managed';
            $invoice->managed = \Auth::user()->name;
            // $invoice->finished_id = $request->finished_id;
            $invoice->save();
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => 'gLrgYjtBxxL',
                'title' => $invoice->user->nickname.' 在 『'.$invoice->project->name.'』的一筆請款已通過第二階段審核。',
                'reason' => '',
                'content' => '前往第三階段審核',
                'link' => route('invoice.review', $invoice_id),
                'status' => 'not_read',
            ]);
        } elseif (\Auth::user()->role == 'accountant' && $invoice->status == 'managed') {
            $invoice->status = 'matched';
            $invoice->matched = \Auth::user()->name;
            $invoice->save();
        } elseif (\Auth::user()->role == 'accountant' && $invoice->status == 'matched') {
            $nowDate = date("Ymd");
            $invoice->status = 'complete';
            $invoice->matched = \Auth::user()->name;

            $invoice->remittance_date = $nowDate;
            $invoice->save();
        }
        return redirect()->route('invoice.list', $invoice['project_id']);
    }
    public function multipleMatch(Request $request, String $project_id)
    {

        $test = $request->input('checkbox');
        foreach ($test as $data) {
            $invoice = Invoice::find($data);
            if (\Auth::user()->role == 'manager' && $invoice->status == 'check') {
                $invoice->status = 'managed';
                $invoice->managed = \Auth::user()->name;
                // $invoice->finished_id = $request->finished_id;
                $invoice->save();
            } elseif (\Auth::user()->role == 'accountant' && $invoice->status == 'managed') {
                $nowDate = date("Ymd");
                $invoice->status = 'matched';
                $invoice->matched = \Auth::user()->name;
                $invoice->save();
            } elseif (\Auth::user()->role == 'accountant' && $invoice->status == 'matched') {
                $nowDate = date("Ymd");
                $invoice->status = 'complete';
                $invoice->matched = \Auth::user()->name;

                $invoice->remittance_date = $nowDate;
                $invoice->save();
            }
        }


        return redirect()->route('invoice.list', $project_id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $invoice_id)
    {
        //Delete the invoice
        $invoice = Invoice::find($invoice_id);
        \Illuminate\Support\Facades\Storage::delete([$invoice->receipt_file, $invoice->detail_file]);
        if (isset($invoice->invoiceEvent->event)) $invoice->invoiceEvent->event->delete();
        $invoice->delete();
        return redirect()->route('invoice.list', $invoice['project_id']);
    }
    public function list(string $projects_id)
    {
        //
        $state = ['waiting','waiting-fix','check-fix', 'check', 'managed', 'matched', 'complete'];
        $project_ids = Invoice::select('project_id')->orderby('project_id')->distinct()->get();
        $invoice_groups = [];

        foreach ($project_ids->toArray() as $project_id) {
            array_push($invoice_groups, Invoice::where('project_id', $project_id)->orderby('created_at', 'desc')->with('project')->get());
        }

        $temp = "";
        $years = [];

        $invoices = Invoice::orderby('created_at', 'desc')->get();

        foreach ($invoices as $data) {
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
        foreach ($invoices as $data) {
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
        return view('pm.invoice.listInvoice', ['invoice_groups' => $invoice_groups, 'projects_id' => $projects_id, 'state' => $state, 'years' => $years, 'months' => $months]);
    }
}