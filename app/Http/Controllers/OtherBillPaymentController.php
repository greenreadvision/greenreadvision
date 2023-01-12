<?php

namespace App\Http\Controllers;

use App\BusinessTrip;
use App\User;
use App\BillPayment;
use App\Intern;
use App\Letters;
use App\Purchase;
use App\OtherBillPayment;
use App\Functions\RandomId;
use App\Http\Controllers\EventController;
use App\Mail\EventMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class OtherBillPaymentController extends Controller
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
        // $created_at = now();
        $other_billPayment_ids = OtherBillPayment::select('other_payment_id')->get()->map(function($other_billPayment) { return $other_billPayment->other_billPayment_id; })->toArray();

        $request->validate([
            'intern_name' => 'nullable|string',
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
            'receipt_date_paper' => 'nullable|date',
            'receipt_date' => 'nullable|date',
            'remuneration' => 'required|integer',
            'price' => 'required|integer',
            'receipt_file' => 'nullable|file',
            'detail_file' => 'nullable|file',
            'purchase_id' => 'nullable|string',
            'reviewer' => 'nullable|string',
            'pay_day' => 'required|integer',
            'petty_cash' => 'required|Boolean',
            'pay_date' => 'nullable|date'
        ]);

        $id = RandomId::getNewId($other_billPayment_ids);
        $numbers = BillPayment::all();
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
        $other_numbers = OtherBillPayment::all();
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
        if(\Auth::user()->role =='manager'||"intern"){
            $intern = $request->input('intern_name');
        }
        else{
            $intern = NULL ;
        }

        $receipt_file_path = null;
        $detail_file_path = null;

        if ($request->hasFile('receipt_file')) {
            if ($request->receipt_file->isValid()) {
                $receipt_file_path = $request->receipt_file->storeAs('receipts', $finished_id.'_'.$request->receipt_file->getClientOriginalName());
            }
        }
        if ($request->hasFile('detail_file')) {
            if ($request->detail_file->isValid()) {
                $detail_file_path = $request->detail_file->storeAs('details', $finished_id.'_'.$request->detail_file->getClientOriginalName())    ;
            }
        }
    
       
        $post = OtherBillPayment::create([
            'other_payment_id' => $id,
            'user_id' => \Auth::user()->user_id,
            'intern_name' => $intern,
            'type'=>$request->input('type'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'number' => $i+1,
            // 'content' => BillPaymentController::replaceEnter(true, $request->input('content')),
            'company_name' => $request->input('company_name'),
            'company' => $request->input('company'),
            'bank' => $request->input('bank'),
            'bank_branch' => $request->input('bank_branch'),
            'bank_account_number' => $request->input('bank_account_number'),
            'bank_account_name' => $request->input('bank_account_name'),
            'receipt' => $request->input('receipt'),
            'receipt_date_paper' => $request->input('receipt_date_paper'),
            'receipt_date' => $request->input('receipt_date'),
            'remuneration' => $request->input('remuneration'),
            'price' => $request->input('price'),
            'receipt_file' => $receipt_file_path,
            'detail_file' => $detail_file_path,
            'status' => 'waiting',
            'finished_id'=>$finished_id,
            'purchase_id' => $request->input('purchase_id'),
            'managed' => '',
            'reviewer' => $request->input('reviewer'),
            'pay_day' => $request->input('pay_day'),
            'petty_cash' => $request->input('petty_cash'),
            'pay_date' => $request->input('pay_date')

        ]);

        // if(!$request->input('receipt')){
        //     EventController::create($request->input('receipt_date'), __('customize.receipt'), __('customize.receipt_date'), __('customize.BillPayment'), 'billPayment', $id);
        // }
        // Mail::raw(route('billPayment.review.other', $id), function ($message) {
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
            'link' => route('billPayment.review.other', $id),
            'status' => 'not_read',
        ]);
        $reviewer_data = User::find('GRV00002');
        $email = 'zx99519567@gmail.com';//$reviewer_data->email
        $maildata = [
            'title' => \Auth::user()->nickname.' 在 『'.__('customize.'.$request->input('type').'').'』 新增一筆請款，待審核。',
            'reason' => '',
            'content' => '前往第一階段審核',
            'link' => route('billPayment.review.other', $id),
        ];
        // Mail::to($email)->send(new EventMail($maildata));
        // fix server getting wrong timezone
        // BillPayment::where('billPayment_id', $id)->update(['created_at' => $created_at, 'updated_at' => $created_at,]);
        return redirect()->route('billPayment.review.other', $id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BillPayment  $billPayment
     * @return \Illuminate\Http\Response
     */
    public function show(String $billPayment_id)
    {
        //
        $billPayment = OtherBillPayment::find($billPayment_id);
        if($billPayment->purchase_id!= null){
            $purchase = Purchase::where('id','=',$billPayment->purchase_id)->get();
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
        // $billPayment->content = BillPaymentController::replaceEnter(false, $billPayment->content);
        if ($billPayment->receipt_file != null) $billPayment->receipt_file = explode('/', $billPayment->receipt_file);
        if ($billPayment->detail_file != null) $billPayment->detail_file = explode('/', $billPayment->detail_file);
        $businessTrips = BusinessTrip::where('billPayment_id','=',$billPayment->other_billPayment_id)->get();
        return view('pm.billPayment.showBillPayment')->with('data',['billPayment'=>$billPayment,'purchase'=>$purchase,'businessTrips'=>$businessTrips]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BillPayment  $billPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(String $billPayment_id)
    {
       
        $type = ['salary','rent','accounting', 'insurance','cash','tax', 'other'];
        $company_name = ['grv', 'grv_2', 'rv'];
        //
        $billPayment = OtherBillPayment::find($billPayment_id);
        foreach($type as $key ){
            $types[$key]['selected'] = ($key == $billPayment->type)? "selected": " ";
        }
        // $billPayment->content = BillPaymentController::replaceEnter(false, $billPayment->content);
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->purchases) != 0) {
                array_push($users, $allUser);
            }
        }
        $reviewers = User::where('role','=','supervisor')->get();
        $interns = Intern::orderby('intern_id')->get();
        $purchases = Purchase::orderby('purchase_date', 'desc')->with('project')->with('user')->get();
        return view('pm.billPayment.editBillPayment')->with('data', ['billPayment' => $billPayment->toArray(),'type' => $type,'types'=>$types,'company_name'=>$company_name,'purchases'=>$purchases,'users'=>$users,'reviewers'=>$reviewers,  'interns'=>$interns]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BillPayment  $billPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $billPayment_id)
    {
        $billPayment = OtherBillPayment::find($billPayment_id);
        //
        $request->validate([
            'intern_name' => 'nullable|string',
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
            'receipt_date_paper' => 'nullable|date',
            'receipt_date' => 'nullable|date',
            'remuneration' => 'required|integer',
            // 'number' => 'required|integer',
            'price' => 'required|integer',
            'receipt_file' => 'nullable|file',
            'detail_file' => 'nullable|file',
            'reviewer' => 'nullable|string',
            'pay_day' => 'required|integer',
            'petty_cash' => 'required|Boolean',
            'pay_date' => 'nullable|date'

        ]);
        //如果公司有更換
        if($billPayment->company_name != $request->input('company_name')){
            $allOtherBillPayment = OtherBillPayment::orderby('created_at', 'desc')->get();
            $allBillPayment = BillPayment::orderby('created_at', 'desc')->get();
            //更改本身流水號
            $billPayment_ids = OtherBillPayment::select('other_payment_id')->get()->map(function ($otherbillPayment) {
                return $otherbillPayment->billPayment_id;
            })->toArray();
            $id = RandomId::getNewId($billPayment_ids); //新的id

            $numbers = BillPayment::all();
            $i = 0;
            $max = 0;
            //查看流水號月份是否正確
            $check_id = (date('Y') - 1911) . date("m");
            foreach ($numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == substr($billPayment->created_at, 0, 7)) {
                    if($number['company_name'] == $request->input('company_name')&& substr($number['finished_id'],-8,5) == $check_id){
                        $i++;
                        if ($number['number'] > $max) {
                            $max = $number['number'];
                        }
                    }
                }
            }
            $other_numbers = OtherBillPayment::all();
            foreach ($other_numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == substr($billPayment->created_at, 0, 7)) {
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
                $receipt_file_path = $billPayment->receipt_file;
            }
            if ($request->hasFile('detail_file')){
                if ($request->detail_file->isValid()) {
                    $detail_file_path = $request->detail_file->storeAs('details',$request->detail_file->getClientOriginalName())    ;
                }
            }else{
                $detail_file_path = $billPayment->detail_file;
            }
            
            switch($request->input('company_name')){
                case 'rv':
                    $finished_id = "IAR" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2). $var;
                    break;
                case 'grv_2':
                    $finished_id = "IAG" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                case 'grv':
                    $finished_id = "IA" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                default:
                    break;
            }
            $post = OtherBillPayment::create([
                'other_payment_id' => $id,
                'user_id' => $billPayment->user_id,
                'type'=>$request->input('type'),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'number' => $i+1,
                // 'content' => BillPaymentController::replaceEnter(true, $request->input('content')),
                'company_name' => $request->input('company_name'),
                'company' => $request->input('company'),
                'bank' => $request->input('bank'),
                'bank_branch' => $request->input('bank_branch'),
                'bank_account_number' => $request->input('bank_account_number'),
                'bank_account_name' => $request->input('bank_account_name'),
                'receipt' => $request->input('receipt'),
                'receipt_date_paper' => $request->input('receipt_date_paper'),
                'receipt_date' => $request->input('receipt_date'),
                'remuneration' => $request->input('remuneration'),
                'price' => $request->input('price'),
                'receipt_file' => $receipt_file_path,
                'detail_file' => $detail_file_path,
                'status' => 'waiting',
                'finished_id'=>$finished_id,
                'purchase_id' => $request->input('purchase_id'),
                'managed' => '',
                'reviewer' => $request->input('reviewer'),
                'pay_day' => $request->input('pay_day'),
                'petty_cash' => $request->input('petty_cash'),
                'pay_date' => $request->input('pay_date')
        
            ]);
            $billPayment->status = 'delete';
            $billPayment->save();

            $billPayment_id = $id;
        }else{
            $billPayment->update($request->except('_method', '_token', 'receipt_file', 'detail_file'));
            if($request->input('remittance_date')!=''){
                $billPayment->remittance_date = $request->input('remittance_date');
                $billPayment->save();
            }
            // BillPayment::where('billPayment_id', $billPayment_id)->updated_at = now();
    
            if ($request->hasFile('receipt_file')){
                if ($request->receipt_file->isValid()){
                    \Illuminate\Support\Facades\Storage::delete($billPayment->receipt_file);
                    $billPayment->update(['receipt_file' => $request->receipt_file->store('receipts')]);
                }
            }
            if ($request->hasFile('detail_file')){
                if ($request->detail_file->isValid()){
                    \Illuminate\Support\Facades\Storage::delete($billPayment->detail_file);
                    $billPayment->update(['detail_file'=> $request->detail_file->store('details')]);
                }
            }
        }
        // if (!$request->input('receipt')){
        //     $event = BillPaymentEvent::where('billPayment_id', $billPayment_id)->get()[0];
        //     EventController::update($event->event_id, $request->input('receipt_date'));
        // }
        return redirect()->route('billPayment.review.other', $billPayment_id);
    }
    public function fix(Request $request, String $billPayment_id)
    {
        $billPayment = OtherBillPayment::find($billPayment_id);
        //
        $request->validate([
            'intern_name' => 'nullable|string',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'company_name' => 'required|string|min:2|max:255',
            'company' => 'required|string|min:2|max:255',
            'bank' => 'required|string|min:2|max:255',
            'bank_branch' => 'required|string|min:2|max:255',
            'bank_account_number' => 'required|string|min:2|max:255',
            'bank_account_name' => 'required|string|min:2|max:255',
            'receipt' => 'required|Boolean',
            'receipt_date_paper' => 'nullable|date',
            'receipt_date' => 'nullable|date',
            'remuneration' => 'required|integer',
            // 'number' => 'required|integer',
            'price' => 'required|integer',
            'receipt_file' => 'nullable|file',
            'detail_file' => 'nullable|file',
            'reviewer' => 'nullable|string',
            'pay_day' => 'required|integer',
            'petty_cash' => 'required|Boolean',
            'pay_date' => 'nullable|date'
            

        ]);

        if($billPayment->company_name != $request->input('company_name')){
            $allOtherBillPayment = OtherBillPayment::orderby('created_at', 'desc')->get();
            $allBillPayment = BillPayment::orderby('created_at', 'desc')->get();
            $numbers = BillPayment::all();
            $i = 0;
            $max = 0;
            //查看流水號月份是否正確
            $check_id = (date('Y') - 1911) . date("m");
            foreach ($numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == substr($billPayment->created_at, 0, 7)) {
                    if($number['company_name'] == $request->input('company_name')&& substr($number['finished_id'],-8,5) == $check_id){
                        $i++;
                        if ($number['number'] > $max) {
                            $max = $number['number'];
                        }
                    }
                }
            }
            $other_numbers = OtherBillPayment::all();
            foreach ($other_numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == substr($billPayment->created_at, 0, 7)) {
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
                    $finished_id = "IAR" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                case 'grv_2':
                    $finished_id = "IAG" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                case 'grv':
                    $finished_id = "IA" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                default:
                    break;
            }
            $post = OtherBillPayment::create([
                'other_payment_id' => $id,
                'user_id' => \Auth::user()->user_id,
                'type'=>$request->input('type'),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'number' => $i+1,
                // 'content' => BillPaymentController::replaceEnter(true, $request->input('content')),
                'company_name' => $request->input('company_name'),
                'company' => $request->input('company'),
                'bank' => $request->input('bank'),
                'bank_branch' => $request->input('bank_branch'),
                'bank_account_number' => $request->input('bank_account_number'),
                'bank_account_name' => $request->input('bank_account_name'),
                'receipt' => $request->input('receipt'),
                'receipt_date_paper' => $request->input('receipt_date_paper'),
                'receipt_date' => $request->input('receipt_date'),
                'remuneration' => $request->input('remuneration'),
                'price' => $request->input('price'),
                'receipt_file' => $receipt_file_path,
                'detail_file' => $detail_file_path,
                'status' => 'waiting',
                'finished_id'=>$finished_id,
                'purchase_id' => $request->input('purchase_id'),
                'managed' => '',
                'reviewer' => $request->input('reviewer'),
                'pay_day' => $request->input('pay_day'),
                'petty_cash' => $request->input('petty_cash'),
                'pay_date' => $request->input('pay_date')
    
            ]);
            $billPayment->status = 'delete';
            $billPayment->save();

            $billPayment_id = $id;
        }

        $billPayment->update($request->except('_method', '_token', 'receipt_file', 'detail_file'));
        
        // BillPayment::where('billPayment_id', $billPayment_id)->updated_at = now();
        if($billPayment->status == "waiting-fix"){
            $billPayment->status = "waiting";
            $billPayment->save();
            $user_id= 'GRV00002';
        }
        else if($billPayment->status == "check-fix"){
            $billPayment->status = "check";
            $billPayment->save();
            $user_id= $billPayment->reviewer;
        }
        
        if ($request->hasFile('receipt_file')) {
            if ($request->receipt_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($billPayment->receipt_file);
                $billPayment->update(['receipt_file' => $request->receipt_file->store('receipts')]);
            }
        }
        if ($request->hasFile('detail_file')) {
            if ($request->detail_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($billPayment->detail_file);
                $billPayment->update(['detail_file' => $request->detail_file->store('details')]);
            }
        }
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $user_id,
            'title' => \Auth::user()->nickname.' 已修改在 『'.__('customize.'.$billPayment->type.'').'』 的一筆請款，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('billPayment.review.other', $billPayment_id),
            'status' => 'not_read',
        ]);
        $reviewer_data = User::find($user_id);
        $email = 'zx99519567@gmail.com';//$reviewer_data->email
        $maildata = [
            'title' =>\Auth::user()->nickname.' 已修改在 『'.__('customize.'.$billPayment->type.'').'』 的一筆請款，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('billPayment.review.other', $billPayment_id),
        ];
        Mail::to($email)->send(new EventMail($maildata));
       
        return redirect()->route('billPayment.review.other', $billPayment_id);
    }

    public function withdraw(Request $request, String $billPayment_id)
    {
        // return $request->finished_id;
        $billPayment = OtherBillPayment::find($billPayment_id);

        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $billPayment->user_id,
            'title' => '您在 『'.__('customize.'.$billPayment->type.'').'』 的一筆請款被退回。',
            'reason' => $request->input('reason'),
            'content' => '前往修改',
            'link' => route('billPayment.edit.other', $billPayment_id),
            'status' => 'not_read',
        ]);
        $reviewer_data = User::find($billPayment->user_id);
        $email = 'zx99519567@gmail.com';//$reviewer_data->email
        $maildata = [
            'title' =>'您在 『'.__('customize.'.$billPayment->type.'').'』 的一筆請款被退回。',
            'reason' => '',
            'content' => '前往修改',
            'link' => route('billPayment.review.other', $billPayment_id),
        ];
        Mail::to($email)->send(new EventMail($maildata));
        //accountant
        if ($billPayment->status == 'waiting') {
            $billPayment->status = 'waiting-fix';
            $billPayment->save();
        } elseif ( $billPayment->status == 'check') {
            $billPayment->status = 'check-fix';
            $billPayment->save();
        }
        return redirect()->route('billPayment.review.other', $billPayment_id);
    }
    /**
     * Match the billPayments and update the status by accountant and manager.
     *
     * @param \App\BillPayment  $billPayment
     */
    public function match(Request $request, String $billPayment_id){
        // return $request->finished_id;
        $billPayment = OtherBillPayment::find($billPayment_id);
        
        //accountant
        if ($billPayment->status=='waiting'){
            $billPayment->status = 'check';
            // $billPayment->managed = \Auth::user()->name;
            $billPayment->save();
            // Mail::raw(route('billPayment.review.other', $billPayment_id), function ($message) use ($billPayment_id) {
            //     $billPayment = BillPayment::find($billPayment_id);

            //     $message->from('greenreadvision2020@gmail.com', 'greenreadvision');
            //     $message->to('jillianwu@grv.com.tw')->subject('其他/保險/薪資 一筆帳務待審核');
            // });
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => $billPayment->reviewer,
                'title' => $billPayment->user->nickname.' 在 『'.__('customize.'.$billPayment->type.'').'』的一筆請款已通過第一階段審核。',
                'reason' => '',
                'content' => '前往第二階段審核',
                'link' => route('billPayment.review.other', $billPayment_id),
                'status' => 'not_read',
            ]);
            $reviewer_data = User::find($billPayment->reviewer);
            $email = 'zx99519567@gmail.com';//$reviewer_data->email
            $maildata = [
                'title' =>$billPayment->user->nickname.' 在 『'.__('customize.'.$billPayment->type.'').'』的一筆請款已通過第一階段審核。',
                'reason' => '',
                'content' => '前往第二階段審核',
                'link' => route('billPayment.review.other', $billPayment_id),
            ];
            Mail::to($email)->send(new EventMail($maildata));
        } else if($billPayment->status=='check'){
            $billPayment->status = 'managed';
            $billPayment->managed = \Auth::user()->name;
            $billPayment->reviewer = \Auth::user()->user_id;
            // $billPayment->finished_id = $request->finished_id;
            $billPayment->save();
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => 'GRV00002',
                'title' => $billPayment->user->nickname.' 在 『'.__('customize.'.$billPayment->type.'').'』的一筆請款已通過第二階段審核。',
                'reason' => '',
                'content' => '前往第三階段審核',
                'link' => route('billPayment.review.other', $billPayment_id),
                'status' => 'not_read',
            ]);
            $reviewer_data = User::find('GRV00002');
            $email = 'zx99519567@gmail.com';//$reviewer_data->email
            $maildata = [
                'title' =>$billPayment->user->nickname.' 在 『'.__('customize.'.$billPayment->type.'').'』的一筆請款已通過第二階段審核。',
                'reason' => '',
                'content' => '前往第三階段審核',
                'link' => route('billPayment.review.other', $billPayment_id),
            ];
            Mail::to($email)->send(new EventMail($maildata));
        }
        elseif($billPayment->status=='managed'){
            $billPayment->status = 'matched';
            $billPayment->matched = \Auth::user()->name;
            // $billPayment->finished_id = $request->finished_id;
            $billPayment->save();
        }
        elseif($billPayment->status=='matched'){
            if($request->input('matched_date') !=null){
                $nowDate = $request->input('matched_date');
            }else{
                $nowDate = date("Ymd");
            }
            if($request->input('radio_type')=='remittance'){
                $billPayment->status = 'complete';
            }
            else if($request->input('radio_type')=='pettyCash'){
                $billPayment->status = 'complete_petty';
            }
            $billPayment->matched = \Auth::user()->name;
           
            $billPayment->remittance_date = $nowDate;
            $billPayment->save();
        }
        return redirect()->route('billPayment.review.other', $billPayment_id);
    }

    public function multipleMatch(Request $request, String $company_name){
        
        $test = $request->input('checkbox');
        foreach($test as $data){
            $billPayment = OtherBillPayment::find($data);
            if (\Auth::user()->role == 'manager' && $billPayment->status == 'check') {
                $billPayment->status = 'managed';
                $billPayment->managed = \Auth::user()->name;
                // $billPayment->finished_id = $request->finished_id;
                $billPayment->save();
            } elseif (\Auth::user()->role == 'accountant' && $billPayment->status == 'managed') {
                $nowDate = date("Ymd");
                $billPayment->status = 'matched';
                $billPayment->matched = \Auth::user()->name;
                $billPayment->save();
            } elseif (\Auth::user()->role == 'accountant' && $billPayment->status == 'matched') {
                $nowDate = date("Ymd");
                $billPayment->status = 'complete';
                $billPayment->matched = \Auth::user()->name;
                $billPayment->remittance_date = $nowDate;
                $billPayment->save();
            }
        }


        return redirect()->route('billPayment.list.other', $company_name);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BillPayment  $billPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $billPayment_id)
    {
        //Delete the billPayment
        $billPayment_delete = OtherBillPayment::find($billPayment_id);
        $billPayment_delete->status = 'delete';
        \Illuminate\Support\Facades\Storage::delete([$billPayment_delete->receipt_file, $billPayment_delete->detail_file]);
        
        $billPayment_delete->save();
        return redirect()->route('billPayment.index');
    }
   
}
