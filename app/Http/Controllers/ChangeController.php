<?php

namespace App\Http\Controllers;

use App\Change;
use App\Intern;
use App\User;
use App\Functions\RandomId;
use App\Mail\EventMail;

;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ChangeController extends Controller
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
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->invoices) != 0) {
                array_push($users, $allUser);
            }
        }
        $interns = Intern::orderby('intern_id')->get();
        $changes = Change::orderby('created_at', 'desc')->with('user')->get();

        $today = date("Y-m-d");
        foreach($changes as $change){
            $Year = substr($change->created_at, 0,4);
            $Mouth =substr($change->created_at,5,2);
            $Mouth = intval($Mouth);
            $Mouth = $Mouth + 2; 
            if($Mouth > 12){
                $Year = intval($Year);
                $Year = $Year + 1;
                $Year = strval($Year);
                $Mouth = $Mouth - 12;
                $Mouth = strval($Mouth);
            } else if($Mouth < 10){
                $Mouth = strval($Mouth);
                $Mouth = '0'. $Mouth;
            } else {
                $Mouth = strval($Mouth);
            }
            if($change->status != 'delete' && $change->status != 'complete'){
                if($today  >= $Year . '-'. $Mouth .'-10'){
                    $change->status = 'matched';
                    if($change->matched ==null){ //系統更動處理人
                        $matched = User::find('GRV');
                        $change->matched = $matched->name;
                    }    
                    $change->save();
                }
            }
        }
        
        return view('pm.change.index', ['users' => $users, 'changes' => $changes, 'interns'=>$interns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->purchases) != 0) {
                array_push($users, $allUser);
            }
        }
        $interns = Intern::orderby('intern_id')->get();
        return view('pm.change.create')->with('data', ['users' => $users, 'interns'=>$interns]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $change_id = Change::select('id')->get()->map(function ($change) {
            return $change->id;
        })->toArray();

        $request->validate([
            'intern_name' => 'nullable|string',
            'change_type' => 'required|string|min:1|max:100',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'file' => 'nullable|file',
            'urgency' => 'required|date'
        ]);
        

        //查看流水號相關變數
        $id = RandomId::getNewId($change_id);
        //查看流水號月份是否正確

        if(is_null($request->input('Added-time')) ){
            $update = date('Y-m-d');
        }
        else{
            $update = $request->input('Added-time');
        }
        $finished_id = "CH" . (date('Y') - 1911) . date("m") . $id;

        $proprietors = User::where('role', '=', 'proprietor')->get();
        $supervisors = User::where('role','=','supervisor')->get();
        //$administrators = User::where('role', '=', 'administrator')->where('status','=','general')->get();
        $administrators = User::find('GRV00002');
        $intern = '';
        if(\Auth::user()->role =='intern' || \Auth::user()->role =='manager'){
            $intern = $request->input('intern_name');
            echo "<script>console.log($intern)</script>";
        }
        else{
            $intern = NULL;
        }
        
        $responser = ''; //負責處理人
        if($request->change_type == '專案' ||$request->change_type == '其他'){
            $responser = '河馬';
        }

        $file = null;
        if ($request->hasFile('file')) {
            if ($request->file->isValid()) {
                $file = $request->file->storeAs('changeDetail', $finished_id.'_'.$request->file->getClientOriginalName());
            }
        }

        $post = Change::create([
            'id' => $id,
            'user_id' => \Auth::user()->user_id,
            'intern_name' => $intern,
            'change_type' => $request->input('change_type'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'file' => $file,
            'urgency' => $request->input('urgency'),
            'status' => 'first',
            'matched' => $responser,
            'finished_id' => $finished_id,
            'updated_at' => $update
        ]);

        return redirect()->route('change.review', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(String $id)
    {
        //
        $change = Change::find($id);
        
        // $invoice->content = InvoiceController::replaceEnter(false, $invoice->content);
        if ($change->file != null) $change->file = explode('/', $change->file);

        if ($change->status == 'complete' && $change->finished_file != null ){
            $change->finished_file = explode('/', $change->finished_file);
        }

        
        return view('pm.change.show')->with('data',['change'=>$change]);
    }

    
    public function withdraw(Request $request, String $id)
    {
        $change = Change::find($id);
        //accountant
        if ($change->status == 'first') {
            $change->status = 'first-fix';
            $change->withdraw_reason = $request->input('reason');
            $change->save();
        } elseif ($change->status == 'second') {
            $change->status = 'second-fix';
            $change->withdraw_reason = $request->input('reason');
            $change->save();
        }elseif ($change->status == 'third') {
            $change->status = 'third-fix';
            $change->withdraw_reason = $request->input('reason');
            $change->save();
        }
        
        return redirect()->route('change.review', $id);
    }

    public function match(Request $request, String $id)
    {
        $change = Change::find($id);
        if ($change->status == 'first') {
            $change->status = 'second';
            $change->save();

        } elseif ($change->status == 'second') {
            $change->status = 'third';
            $change->managed = $request->input('managed');
            $change->save();

        } elseif ($change->status == 'third') {
            $change->status = 'matched';
            $change->save();
            
        } elseif ($change->status == 'matched') {
            if($request->input('finished_date') !=null){
                $finished_date = $request->input('finished_date');
            }else{
                $finished_date = date("Ymd");
            }
            $change->finished_date = $finished_date;

            // $finished_file = null;
            // if ($request->hasFile('finished_file')) {
            //     if ($request->finished_file->isValid()) {
            //         $finished_file = $request->finished_file->storeAs('changeDetail', $finished_file.'_'.$request->finished_file->getClientOriginalName());
            //     }
            // }
            $change->finished_message = $request->input('finished_message');

            $change->status = 'complete';
            $change->save();
            // $post = Change::where('id', $id)->update(['finished_file' => $finished_file]);
        }
        return redirect()->route('change.review', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(String $id)
    {
        $change = Change::find($id);
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->purchases) != 0) {
                array_push($users, $allUser);
            }
        }
        $interns = Intern::orderby('intern_id')->get();
        return view('pm.change.edit')->with('data', ['change' => $change->toArray(), 'interns'=>$interns]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $id)
    {
        $change = Change::find($id);
        $change->intern_name = $request->input('intern_name');
        $change->change_type = $request->input('change_type');
        $change->title = $request->input('title');
        $change->content = $request->input('content');
        $change->urgency = $request->input('urgency');
        if ($request->hasFile('file')) {
            if ($request->file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($change->file);
                $change->update(['file' => $request->file->storeAs('changeDetail',$request->file->getClientOriginalName())]);
            }
        }

        if($request->input('fix')!=null){
            if($change->status== 'first-fix'){
                $change->status = 'first';
            }elseif($change->status == 'second-fix'){
                $change->status = 'second';
            }elseif($change->status== 'third-fix'){
                $change->status = 'third';
            }
        }

        $change -> save();
        return redirect()->route('change.review', $id);        
    }

    // public function fix(Request $request, String $invoice_id)
    // {
    //     $invoice = Invoice::find($invoice_id);
    //     //
    //     $request->validate([
    //         'intern_name' => 'nullable|string',
    //         'project_id' => 'required|string|exists:projects,project_id|size:11',
    //         'content' => 'required|string|min:1|max:100',
    //         'company_name' => 'required|string|min:2|max:255',
    //         'company' => 'required|string|min:2|max:255',
    //         'bank' => 'required|string|min:2|max:255',
    //         'bank_branch' => 'required|string|min:2|max:255',
    //         'bank_account_number' => 'required|string|min:2|max:255',
    //         'bank_account_name' => 'required|string|min:2|max:255',
    //         'receipt' => 'required|Boolean',
    //         'receipt_date' => 'required|date',
    //         'remuneration' => 'required|integer',
    //         // 'number' => 'required|integer',
    //         'price' => 'required|integer',
    //         'receipt_file' => 'nullable|file',
    //         'detail_file' => 'nullable|file',
    //         'reviewer' => 'required|string'

           
    //         // 'number' => 'required|integer',
            
    //     ]);
    //     //如果公司有更換
    //     if($invoice->company_name != $request->input('company_name')){
    //         //更改本身流水號
    //         $numbers = Invoice::all();
    //         $i = 0;
    //         $max = 0;
    //         //查看流水號月份是否正確
    //         $check_id = (date('Y') - 1911) . date("m");
    //         foreach ($numbers->toArray() as $number) {
    //             if (substr($number['created_at'], 0, 7) == substr($invoice->created_at, 0, 7)) {
    //                 if($number['company_name'] == $request->input('company_name')&& substr($number['finished_id'],-8,5) == $check_id){
    //                     $i++;
    //                     if ($number['number'] > $max) {
    //                         $max = $number['number'];
    //                     }
    //                 }
    //             }
    //         }
    //         $other_numbers = OtherInvoice::all();
    //         foreach ($other_numbers->toArray() as $number) {
    //             if (substr($number['created_at'], 0, 7) == substr($invoice->created_at, 0, 7)) {
    //                 if($number['company_name'] == $request->input('company_name')&& substr($number['finished_id'],-8,5) == $check_id){
    //                     $i++;
    //                     if ($number['number'] > $max) {
    //                         $max = $number['number'];
    //                     }
    //                 }
    //             }
    //         }
    //         if ($max > $i) {
    //             $var = sprintf("%03d", $max + 1);
    //             $i = $max;
    //         } else {
    //             $var = sprintf("%03d", $i + 1);
    //         }
            
    //         switch($request->input('company_name')){
    //             case 'rv':
    //                 $finished_id = "IAR" . (date('Y') - 1911) . substr($invoice->created_at, 5, 2) . $var;
    //                 break;
    //             case 'grv_2':
    //                 $finished_id = "IAG" . (date('Y') - 1911) . substr($invoice->created_at, 5, 2) . $var;
    //                 break;
    //             case 'grv':
    //                 $finished_id = "IA" . (date('Y') - 1911) . substr($invoice->created_at, 5, 2) . $var;
    //                 break;
    //             default:
    //                 break;
    //         }
    //         $invoice->number = $i + 1;
    //         $invoice->finished_id = $finished_id;
    //         $invoice->save();
    //     }

    //     $invoice->update($request->except('_method', '_token', 'receipt_file', 'detail_file'));
    //     // Invoice::where('invoice_id', $invoice_id)->updated_at = now();
    //     if ($invoice->status == "waiting-fix") {
    //         $invoice->status = "waiting";
    //         $invoice->save();
    //         $user_id = 'GRV00002';
    //     } else if ($invoice->status == "check-fix") {
    //         $invoice->status = "check";
    //         $invoice->save();
    //         $user_id = $invoice->reviewer;
            
            
    //     }
    //     $reviewer_data = User::find($user_id);
    //     $email = 'zx99519567@gmail.com';//$reviewer_data->email
    //     $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
    //         return $letter->letter_id;
    //     })->toArray();
    //     $newId = RandomId::getNewId($letter_ids);
    //     $post = Letters::create([
    //         'letter_id' => $newId,
    //         'user_id' => $user_id,
    //         'title' => \Auth::user()->nickname . ' 已修改在 『' . $invoice->project->name . '』 的一筆請款，請重新審核。',
    //         'reason' => '',
    //         'content' => '重新審核',
    //         'link' => route('invoice.review', $invoice_id),
    //         'status' => 'not_read',
    //     ]);
    //     $maildata = [
    //         'title' => \Auth::user()->nickname . ' 已修改在 『' . $invoice->project->name . '』 的一筆請款，請重新審核。',
    //         'reason' => '',
    //         'content' => '重新審核',
    //         'link' => route('invoice.review', $invoice_id),
    //     ];
    //     Mail::to($email)->send(new EventMail($maildata));
        
    //     if ($request->hasFile('receipt_file')) {
    //         if ($request->receipt_file->isValid()) {
    //             \Illuminate\Support\Facades\Storage::delete($invoice->receipt_file);
    //             $invoice->update(['receipt_file' => $request->receipt_file->storeAs('receipts',$request->receipt_file->getClientOriginalName())]);

    //         }
    //     }
    //     if ($request->hasFile('detail_file')) {
    //         if ($request->detail_file->isValid()) {
    //             \Illuminate\Support\Facades\Storage::delete($invoice->detail_file);
    //             $invoice->update(['detail_file' => $request->detail_file->storeAs('details',$request->detail_file->getClientOriginalName())]);                
    //         }
    //     }


    //     return redirect()->route('invoice.review', $invoice_id);
    // }

    function delete($id){
        $change = Change::find($id);
        $change->delete();
        return redirect()->route('change.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    // public function destroy(String $invoice_id)
    // {
    //     //Delete the invoice
    //     $invoice_delete = Invoice::find($invoice_id);

    //     \Illuminate\Support\Facades\Storage::delete([$invoice_delete->receipt_file, $invoice_delete->detail_file]);

    //     $invoice_delete->status = 'delete';
    //     $invoice_delete->save();
    //     return redirect()->route('invoice.index');
    // }
}