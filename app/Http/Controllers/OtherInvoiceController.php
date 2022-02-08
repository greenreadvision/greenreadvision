<?php

namespace App\Http\Controllers;

use App\BusinessTrip;
use App\User;
use App\Invoice;
use App\Letters;
use App\Purchase;
use App\OtherInvoice;
use App\Functions\RandomId;
use App\Http\Controllers\EventController;
use App\Mail\EventMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class OtherInvoiceController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $other_invoice_ids = OtherInvoice::select('other_invoice_id')->get()->map(function($other_invoice) { return $other_invoice->other_invoice_id; })->toArray();

        $request->validate([
            'type' => 'required|string|min:2|max:255',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'company' => 'required|string|min:2|max:255',
            'company_name' => 'required|string|min:2|max:255',
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
            'purchase_id' => 'nullable|string',
            'reviewer' => 'required|string'
        ]);

        if ($request->hasFile('receipt_file')){
            if ($request->receipt_file->isValid()){
                $receipt_file_path = $request->receipt_file->store('receipts');
            }
        }
        if ($request->hasFile('detail_file')){
            if ($request->detail_file->isValid()){
                $detail_file_path = $request->detail_file->store('details');
            }
        }

        $id = RandomId::getNewId($other_invoice_ids);
        $numbers = Invoice::all();
        $i = 0;
        $max = 0;
        //查看流水號月份是否正確
        $check_id = (date('Y') - 1911) . date("m");

        foreach ($numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                if($number['company_name'] == $request->input('company_name') && substr($number['finished_id'],-8,5) == $check_id){
                    $i++;
                    if ($number['number'] > $max) {
                        $max = $number['number'];
                    }
                }
            }
        }
        $other_numbers = OtherInvoice::all();
        foreach ($other_numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                if($number['company_name'] == $request->input('company_name') && substr($number['finished_id'],-8,5) == $check_id){
                    $i++;
                    if ($number['number'] > $max) {
                        $max = $number['number'];
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
        
        switch($request->input('company_name')){
            case 'rv':
                $finished_id = "IAR" . (date('Y') - 1911) . date("m") . $var;
                break;
            case 'grv_2':
                $finished_id = "IAG" . (date('Y') - 1911) . date("m") . $var;
                break;
            case 'grv':
                $finished_id = "IA" . (date('Y') - 1911) . date("m") . $var;
                break;
            default:
                break;
        }

        $intern = '';
        if(\Auth::user()->role =='intern'){
            $intern = $request->input('intern_name');
        }
        else{
            $intern = NULL ;
        }
       
        $post = OtherInvoice::create([
            'intern_name' => $intern,
            'other_invoice_id' => $id,
            'user_id' => \Auth::user()->user_id,
            'type'=>$request->input('type'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'number' => $i+1,
            // 'content' => InvoiceController::replaceEnter(true, $request->input('content')),
            'company_name' => $request->input('company_name'),
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
            'finished_id'=>$finished_id,
            'purchase_id' => $request->input('purchase_id'),
            'managed' => '',
            'reviewer' => $request->input('reviewer')

        ]);

        // if(!$request->input('receipt')){
        //     EventController::create($request->input('receipt_date'), __('customize.receipt'), __('customize.receipt_date'), __('customize.Invoice'), 'invoice', $id);
        // }
        // Mail::raw(route('invoice.review.other', $id), function ($message) {
        //     $message->from('greenreadvision2020@gmail.com', 'greenreadvision');
        //     $message->to('jillianwu@grv.com.tw')->subject(\Auth::user()->name.'新增了一筆帳務');
        // });
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => 'GRV00002',
            'title' => \Auth::user()->nickname.' 在 『'.__('customize.'.$request->input('type').'').'』 新增一筆請款，待審核。',
            'reason' => '',
            'content' => '前往第一階段審核',
            'link' => route('invoice.review.other', $id),
            'status' => 'not_read',
        ]);
        $reviewer_data = User::find('GRV00002');
        $email = 'zx99519567@gmail.com';//$reviewer_data->email
        $maildata = [
            'title' => \Auth::user()->nickname.' 在 『'.__('customize.'.$request->input('type').'').'』 新增一筆請款，待審核。',
            'reason' => '',
            'content' => '前往第一階段審核',
            'link' => route('invoice.review.other', $id),
        ];
        //Mail::to($email)->send(new EventMail($maildata));
        // fix server getting wrong timezone
        // Invoice::where('invoice_id', $id)->update(['created_at' => $created_at, 'updated_at' => $created_at,]);
        return redirect()->route('invoice.review.other', $id);
        
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
        $invoice = OtherInvoice::find($invoice_id);
        if($invoice->purchase_id!= null){
            $purchase = Purchase::where('id','=',$invoice->purchase_id)->get();
            if(count($purchase) == 0 ){
                $purchase = '';
            }
            else{
                $purchase = $purchase[0]->purchase_id;
            }
        }
        else{
            $purchase = '';
        }
        // $invoice->content = InvoiceController::replaceEnter(false, $invoice->content);
        if ($invoice->receipt_file != null) $invoice->receipt_file = explode('/', $invoice->receipt_file);
        if ($invoice->detail_file != null) $invoice->detail_file = explode('/', $invoice->detail_file);
        $businessTrips = BusinessTrip::where('invoice_id','=',$invoice->other_invoice_id)->get();
        return view('pm.invoice.showInvoice')->with('data',['invoice'=>$invoice,'purchase'=>$purchase,'businessTrips'=>$businessTrips]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(String $invoice_id)
    {
       
        $type = ['salary','rent','accounting', 'insurance','cash','tax', 'other'];
        $company_name = ['grv', 'grv_2', 'rv'];
        //
        $invoice = OtherInvoice::find($invoice_id);
        foreach($type as $key ){
            $types[$key]['selected'] = ($key == $invoice->type)? "selected": " ";
        }
        // $invoice->content = InvoiceController::replaceEnter(false, $invoice->content);
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->purchases) != 0) {
                array_push($users, $allUser);
            }
        }
        $reviewers = User::where('role','=','supervisor')->get();

        $purchases = Purchase::orderby('purchase_date', 'desc')->with('project')->with('user')->get();
        return view('pm.invoice.editInvoice')->with('data', ['invoice' => $invoice->toArray(),'type' => $type,'types'=>$types,'company_name'=>$company_name,'purchases'=>$purchases,'users'=>$users,'reviewers'=>$reviewers]);
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
        $invoice = OtherInvoice::find($invoice_id);
        //
        $request->validate([
            'type' => 'required|string|min:2|max:255',
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
            'detail_file' => 'nullable|file',
            'reviewer' => 'required|string'

        ]);
        //如果公司有更換
        if($invoice->company_name != $request->input('company_name')){
            $allOtherInvoice = OtherInvoice::orderby('created_at', 'desc')->get();
            $allInvoice = Invoice::orderby('created_at', 'desc')->get();
            //更改本身流水號
            $invoice_ids = OtherInvoice::select('other_invoice_id')->get()->map(function ($otherinvoice) {
                return $otherinvoice->invoice_id;
            })->toArray();
            $id = RandomId::getNewId($invoice_ids); //新的id

            $numbers = Invoice::all();
            $i = 0;
            $max = 0;
            //查看流水號月份是否正確
            $check_id = (date('Y') - 1911) . date("m");
            foreach ($numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == substr($invoice->created_at, 0, 7)) {
                    if($number['company_name'] == $request->input('company_name')&& substr($number['finished_id'],-8,5) == $check_id){
                        $i++;
                        if ($number['number'] > $max) {
                            $max = $number['number'];
                        }
                    }
                }
            }
            $other_numbers = OtherInvoice::all();
            foreach ($other_numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == substr($invoice->created_at, 0, 7)) {
                    if($number['company_name'] == $request->input('company_name')&& substr($number['finished_id'],-8,5) == $check_id){
                        $i++;
                        if ($number['number'] > $max) {
                            $max = $number['number'];
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

            if ($request->hasFile('receipt_file')){
                if ($request->receipt_file->isValid()) {
                    $receipt_file_path = $request->receipt_file->storeAs('receipts',$request->receipt_file->getClientOriginalName());
                }
            }else{
                $receipt_file_path = $invoice->receipt_file;
            }
            if ($request->hasFile('detail_file')){
                if ($request->detail_file->isValid()) {
                    $detail_file_path = $request->detail_file->storeAs('details',$request->detail_file->getClientOriginalName())    ;
                }
            }else{
                $detail_file_path = $invoice->detail_file;
            }
            
            switch($request->input('company_name')){
                case 'rv':
                    $finished_id = "IAR" . (date('Y') - 1911) . substr($invoice->created_at, 5, 2). $var;
                    break;
                case 'grv_2':
                    $finished_id = "IAG" . (date('Y') - 1911) . substr($invoice->created_at, 5, 2) . $var;
                    break;
                case 'grv':
                    $finished_id = "IA" . (date('Y') - 1911) . substr($invoice->created_at, 5, 2) . $var;
                    break;
                default:
                    break;
            }
            $post = OtherInvoice::create([
                'other_invoice_id' => $id,
                'user_id' => $invoice->user_id,
                'type'=>$request->input('type'),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'number' => $i+1,
                // 'content' => InvoiceController::replaceEnter(true, $request->input('content')),
                'company_name' => $request->input('company_name'),
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
                'finished_id'=>$finished_id,
                'purchase_id' => $request->input('purchase_id'),
                'managed' => '',
                'reviewer' => $request->input('reviewer')
    
            ]);
            $invoice->status = 'delete';
            $invoice->save();

            $invoice_id = $id;
        }else{
            $invoice->update($request->except('_method', '_token', 'receipt_file', 'detail_file'));
            if($request->input('remittance_date')!=''){
                $invoice->remittance_date = $request->input('remittance_date');
                $invoice->save();
            }
            // Invoice::where('invoice_id', $invoice_id)->updated_at = now();
    
            if ($request->hasFile('receipt_file')){
                if ($request->receipt_file->isValid()){
                    \Illuminate\Support\Facades\Storage::delete($invoice->receipt_file);
                    $invoice->update(['receipt_file' => $request->receipt_file->store('receipts')]);
                }
            }
            if ($request->hasFile('detail_file')){
                if ($request->detail_file->isValid()){
                    \Illuminate\Support\Facades\Storage::delete($invoice->detail_file);
                    $invoice->update(['detail_file'=> $request->detail_file->store('details')]);
                }
            }
        }
        // if (!$request->input('receipt')){
        //     $event = InvoiceEvent::where('invoice_id', $invoice_id)->get()[0];
        //     EventController::update($event->event_id, $request->input('receipt_date'));
        // }
        return redirect()->route('invoice.review.other', $invoice_id);
    }
    public function fix(Request $request, String $invoice_id)
    {
        $invoice = OtherInvoice::find($invoice_id);
        //
        $request->validate([

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
            'detail_file' => 'nullable|file',
            'reviewer' => 'required|string'
            

        ]);

        if($invoice->company_name != $request->input('company_name')){
            $allOtherInvoice = OtherInvoice::orderby('created_at', 'desc')->get();
            $allInvoice = Invoice::orderby('created_at', 'desc')->get();
            $numbers = Invoice::all();
            $i = 0;
            $max = 0;
            //查看流水號月份是否正確
            $check_id = (date('Y') - 1911) . date("m");
            foreach ($numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == substr($invoice->created_at, 0, 7)) {
                    if($number['company_name'] == $request->input('company_name')&& substr($number['finished_id'],-8,5) == $check_id){
                        $i++;
                        if ($number['number'] > $max) {
                            $max = $number['number'];
                        }
                    }
                }
            }
            $other_numbers = OtherInvoice::all();
            foreach ($other_numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == substr($invoice->created_at, 0, 7)) {
                    if($number['company_name'] == $request->input('company_name')&& substr($number['finished_id'],-8,5) == $check_id){
                        $i++;
                        if ($number['number'] > $max) {
                            $max = $number['number'];
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
            
            switch($request->input('company_name')){
                case 'rv':
                    $finished_id = "IAR" . (date('Y') - 1911) . substr($invoice->created_at, 5, 2) . $var;
                    break;
                case 'grv_2':
                    $finished_id = "IAG" . (date('Y') - 1911) . substr($invoice->created_at, 5, 2) . $var;
                    break;
                case 'grv':
                    $finished_id = "IA" . (date('Y') - 1911) . substr($invoice->created_at, 5, 2) . $var;
                    break;
                default:
                    break;
            }
            $post = OtherInvoice::create([
                'other_invoice_id' => $id,
                'user_id' => \Auth::user()->user_id,
                'type'=>$request->input('type'),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'number' => $i+1,
                // 'content' => InvoiceController::replaceEnter(true, $request->input('content')),
                'company_name' => $request->input('company_name'),
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
                'finished_id'=>$finished_id,
                'purchase_id' => $request->input('purchase_id'),
                'managed' => '',
                'reviewer' => $request->input('reviewer')
    
            ]);
            $invoice->status = 'delete';
            $invoice->save();

            $invoice_id = $id;
        }

        $invoice->update($request->except('_method', '_token', 'receipt_file', 'detail_file'));
        
        // Invoice::where('invoice_id', $invoice_id)->updated_at = now();
        if($invoice->status == "waiting-fix"){
            $invoice->status = "waiting";
            $invoice->save();
            $user_id= 'GRV00002';
        }
        else if($invoice->status == "check-fix"){
            $invoice->status = "check";
            $invoice->save();
            $user_id= $invoice->reviewer;
        }
        
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
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $user_id,
            'title' => \Auth::user()->nickname.' 已修改在 『'.__('customize.'.$invoice->type.'').'』 的一筆請款，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('invoice.review.other', $invoice_id),
            'status' => 'not_read',
        ]);
        $reviewer_data = User::find($user_id);
        $email = 'zx99519567@gmail.com';//$reviewer_data->email
        $maildata = [
            'title' =>\Auth::user()->nickname.' 已修改在 『'.__('customize.'.$invoice->type.'').'』 的一筆請款，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('invoice.review.other', $invoice_id),
        ];
        Mail::to($email)->send(new EventMail($maildata));
       
        return redirect()->route('invoice.review.other', $invoice_id);
    }

    public function withdraw(Request $request, String $invoice_id)
    {
        // return $request->finished_id;
        $invoice = OtherInvoice::find($invoice_id);

        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $invoice->user_id,
            'title' => '您在 『'.__('customize.'.$invoice->type.'').'』 的一筆請款被退回。',
            'reason' => $request->input('reason'),
            'content' => '前往修改',
            'link' => route('invoice.edit.other', $invoice_id),
            'status' => 'not_read',
        ]);
        $reviewer_data = User::find($invoice->user_id);
        $email = 'zx99519567@gmail.com';//$reviewer_data->email
        $maildata = [
            'title' =>'您在 『'.__('customize.'.$invoice->type.'').'』 的一筆請款被退回。',
            'reason' => '',
            'content' => '前往修改',
            'link' => route('invoice.review.other', $invoice_id),
        ];
        Mail::to($email)->send(new EventMail($maildata));
        //accountant
        if ($invoice->status == 'waiting') {
            $invoice->status = 'waiting-fix';
            $invoice->save();
        } elseif ( $invoice->status == 'check') {
            $invoice->status = 'check-fix';
            $invoice->save();
        }
        return redirect()->route('invoice.review.other', $invoice_id);
    }
    /**
     * Match the invoices and update the status by accountant and manager.
     *
     * @param \App\Invoice  $invoice
     */
    public function match(Request $request, String $invoice_id){
        // return $request->finished_id;
        $invoice = OtherInvoice::find($invoice_id);
        
        //accountant
        if ($invoice->status=='waiting'){
            $invoice->status = 'check';
            // $invoice->managed = \Auth::user()->name;
            $invoice->save();
            // Mail::raw(route('invoice.review.other', $invoice_id), function ($message) use ($invoice_id) {
            //     $invoice = Invoice::find($invoice_id);

            //     $message->from('greenreadvision2020@gmail.com', 'greenreadvision');
            //     $message->to('jillianwu@grv.com.tw')->subject('其他/保險/薪資 一筆帳務待審核');
            // });
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => $invoice->reviewer,
                'title' => $invoice->user->nickname.' 在 『'.__('customize.'.$invoice->type.'').'』的一筆請款已通過第一階段審核。',
                'reason' => '',
                'content' => '前往第二階段審核',
                'link' => route('invoice.review.other', $invoice_id),
                'status' => 'not_read',
            ]);
            $reviewer_data = User::find($invoice->reviewer);
            $email = 'zx99519567@gmail.com';//$reviewer_data->email
            $maildata = [
                'title' =>$invoice->user->nickname.' 在 『'.__('customize.'.$invoice->type.'').'』的一筆請款已通過第一階段審核。',
                'reason' => '',
                'content' => '前往第二階段審核',
                'link' => route('invoice.review.other', $invoice_id),
            ];
            Mail::to($email)->send(new EventMail($maildata));
        } else if($invoice->status=='check'){
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
                'user_id' => 'GRV00002',
                'title' => $invoice->user->nickname.' 在 『'.__('customize.'.$invoice->type.'').'』的一筆請款已通過第二階段審核。',
                'reason' => '',
                'content' => '前往第三階段審核',
                'link' => route('invoice.review.other', $invoice_id),
                'status' => 'not_read',
            ]);
            $reviewer_data = User::find('GRV00002');
            $email = 'zx99519567@gmail.com';//$reviewer_data->email
            $maildata = [
                'title' =>$invoice->user->nickname.' 在 『'.__('customize.'.$invoice->type.'').'』的一筆請款已通過第二階段審核。',
                'reason' => '',
                'content' => '前往第三階段審核',
                'link' => route('invoice.review.other', $invoice_id),
            ];
            Mail::to($email)->send(new EventMail($maildata));
        }
        elseif($invoice->status=='managed'){
            $invoice->status = 'matched';
            $invoice->matched = \Auth::user()->name;
            // $invoice->finished_id = $request->finished_id;
            $invoice->save();
        }
        elseif($invoice->status=='matched'){
            if($request->input('matched_date') !=null){
                $nowDate = $request->input('matched_date');
            }else{
                $nowDate = date("Ymd");
            }
            if($request->input('radio_type')=='remittance'){
                $invoice->status = 'complete';
            }
            else if($request->input('radio_type')=='pettyCash'){
                $invoice->status = 'complete_petty';
            }
            $invoice->matched = \Auth::user()->name;
           
            $invoice->remittance_date = $nowDate;
            $invoice->save();
        }
        return redirect()->route('invoice.review.other', $invoice_id);
    }

    public function multipleMatch(Request $request, String $company_name){
        
        $test = $request->input('checkbox');
        foreach($test as $data){
            $invoice = OtherInvoice::find($data);
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


        return redirect()->route('invoice.list.other', $company_name);
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
        $invoice_delete = OtherInvoice::find($invoice_id);
        $invoice_delete->status = 'delete';
        \Illuminate\Support\Facades\Storage::delete([$invoice_delete->receipt_file, $invoice_delete->detail_file]);
        
        $invoice_delete->save();
        return redirect()->route('invoice.index');
    }
   
}
