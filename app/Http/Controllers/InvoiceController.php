<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Project;
use App\Invoice;
use App\Intern;
use App\Bank;
use App\BusinessTrip;
use App\User;
use App\Letters;
use App\Functions\RandomId;
use App\Mail\EventMail;

;
use App\OtherInvoice;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        $ZipDir = storage_path("app/public/"."zip/");
        $fileNum = count(glob("$ZipDir/*.*"));
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->invoices) != 0) {
                array_push($users, $allUser);
            }
        }
        $interns = Intern::orderby('intern_id')->get();
        $invoices = Invoice::orderby('created_at', 'desc')->with('project')->with('user')->get();
        $otherInvoices = OtherInvoice::orderby('created_at', 'desc')->with('user')->get();

        $today = date("Y-m-d");
        foreach($invoices as $invoice){
            $Year = substr($invoice->created_at, 0,4);
            $Mouth =substr($invoice->created_at,5,2);
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
            if($invoice->status != 'delete' && $invoice->status != 'complete' && $invoice->status != 'complete_petty'){
                if($today  >= $Year . '-'. $Mouth .'-10'){
                    $invoice->status = 'matched';
                    if($invoice->reviewer !=null){
                        $reviewer = User::find($invoice->reviewer);
                        $invoice->managed = $reviewer->name;
                    }
                    if($invoice->matched ==null){
                        $matched = User::find('GRV00002');
                        $invoice->matched = $matched->name;
                    }    
                    $invoice->save();
                }
            }
        }
        foreach($otherInvoices as $otherInvoice){
            $Year = substr($otherInvoice->created_at, 0,4);
            $Mouth =substr($otherInvoice->created_at,5,2);
            $Mouth = intval($Mouth);
            $Mouth = $Mouth + 2;  
            if($Mouth > 12){
                $Year = intval($Year);
                $Year = $Year + 1;
                $Year = strval($Year);
                $Mouth = $Mouth - 12;
                $Mouth = strval($Mouth);
                $Mouth = '0'. $Mouth;
            } else if($Mouth < 10){
                $Mouth = strval($Mouth);
                $Mouth = '0'. $Mouth;
            } else {
                $Mouth = strval($Mouth);
            }
            
            
            
            if($otherInvoice->status != 'delete' && $otherInvoice->status != 'complete' && $otherInvoice->status != 'complete_petty' ){
                if($today  >= $Year . '-'. $Mouth .'-10'){
                    $otherInvoice->status = 'matched';
                    if($otherInvoice->reviewer !=null){
                        $reviewer = User::find($otherInvoice->reviewer);
                        $otherInvoice->managed = $reviewer->name;
                    }
                    if($otherInvoice->matched ==null){
                        $matched = User::find('GRV00002');
                        $otherInvoice->matched = $matched->name;    
                    }
                    $otherInvoice->save();
                }
            }
        }
        
        return view('pm.invoice.indexInvoice', ['users' => $users, 'invoices' => $invoices,'otherInvoices' => $otherInvoices,'ZipCount' => $fileNum, 'interns'=>$interns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $bank = Bank::orderby('name')->get();
        $projects = Project::select('project_id', 'name', 'status')->orderby('created_at', 'desc')->get()->toArray();
        $rv = Project::where('company_name', '=', 'rv')->where('status','!=','close')->orderby('created_at', 'desc')->get();
        $grv = Project::where('company_name', '=', 'grv')->where('status','!=','close')->orderby('created_at', 'desc')->get();
        $grv2 = Project::where('company_name', '=', 'grv_2')->where('status','!=','close')->orderby('created_at', 'desc')->get();

        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->purchases) != 0) {
                array_push($users, $allUser);
            }
        }

        
        $interns = Intern::orderby('intern_id')->get();

        $reviewers = User::where('role','=','supervisor')->get();
        $purchases = Purchase::orderby('purchase_date', 'desc')->with('project')->with('user')->get();
        return view('pm.invoice.createInvoice')->with('data', ['projects' => $projects,  'bank' => $bank,  'rv' => $rv,  'grv' => $grv, 'grv2' => $grv2,'purchases'=>$purchases,'users' => $users,'reviewers'=>$reviewers, 'interns'=>$interns]);
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
        $bank_status = 0;
        $bank = Bank::all();
        foreach($bank as $b){
            if($b->name == $request->input('company') && $b->bank_account_name == $request->input('bank_account_name')){
                $bank_status = 1;
            }
        }

        if($bank_status == 0){
            $bank_ids = Bank::select('bank_id')->get()->map(function ($bank) {
                return $bank->bank_id;
            })->toArray();
            $request->validate([
                'company' => 'required|string|min:1|max:255',
                'bank' => 'required|string|min:2|max:255',
                'bank_branch' => 'required|string|min:2|max:255',
                'bank_account_number' => 'required|string|min:2|max:255',
                'bank_account_name' => 'required|string|min:2|max:255'
            ]);


            $id = RandomId::getNewId($bank_ids);
            $post = Bank::create([
                'bank_id' => $id,
                'name' => $request->input('company'),
                'bank_account_name' => $request->input('bank_account_name'),
                'bank' => $request->input('bank'),
                'bank_branch' => $request->input('bank_branch'),
                'bank_account_number' => $request->input('bank_account_number'),
            ]);
        }   
        
        // $created_at = now();
        $invoice_ids = Invoice::select('invoice_id')->get()->map(function ($invoice) {
            return $invoice->invoice_id;
        })->toArray();

        $request->validate([
            'intern_name' => 'nullable|string',
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
            'purchase_id' => 'nullable|string',
            'reviewer' => 'required|string'
        ]);
        

        //查看流水號相關變數
        $id = RandomId::getNewId($invoice_ids);
        $project = Project::find($request->input('project_id'));
        $numbers = Invoice::all();
        $i = 0;
        $max = 0;
        //查看流水號月份是否正確
        $check_id = (date('Y') - 1911) . date("m");
        

        //設定最新流水編號
        foreach ($numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                if($number['company_name'] == $project->company_name && substr($number['finished_id'],-8,5) == $check_id){
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
                if($number['company_name'] == $project->company_name && substr($number['finished_id'],-8,5) == $check_id){
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
        //設定流水號
        switch($project->company_name){
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
        
        if(\Auth::user()->role =='manager'){
            $intern = $request->input('intern_name');
            echo "<script>console.log($intern)</script>";
        }
        else{
            $intern = NULL;
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
    
        
        $post = Invoice::create([
            'invoice_id' => $id,
            'user_id' => \Auth::user()->user_id,
            'intern_name' => $intern,
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
            'purchase_id' => $request->input('purchase_id'),
            'reviewer' => $request->input('reviewer')
        ]);



       
        $project_ids = Invoice::select('project_id')->orderby('project_id')->distinct()->get();
        $invoice_groups = [];
        foreach ($project_ids->toArray() as $project_id) {
            array_push($invoice_groups, Invoice::where('project_id', $project_id)->orderby('created_at', 'desc')->with('project')->get());
        }
      
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => 'GRV00002',
            'title' => \Auth::user()->nickname . ' 在 『' . $project->name . '』 新增一筆請款，待審核。',
            'reason' => '',
            'content' => '前往第一階段審核',
            'link' => route('invoice.review', $id),
            'status' => 'not_read',
        ]);
        $reviewer_data = User::find('GRV00021');//GRV00002
        $email = $reviewer_data->email;
        $maildata = [
            'title' => \Auth::user()->nickname . ' 在 『' . $project->name . '』 新增一筆請款，待審核。',
            'reason' => '',
            'content' => '前往第一階段審核',
            'link' => route('invoice.review', $id),
        ];
        // Mail::to($email)->send(new EventMail($maildata));

        return redirect()->route('invoice.review', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function downLoadZip(Request $request){
        $today = substr(now()->toDateTimeString('Y-m-d'), 0, 10);
        $ZipDir = storage_path("app/public/"."zip/");
        $fileNum = count(glob("$ZipDir/*.*"));
        $file = '';
        $msg = '';
        $path = [];
        $data =json_decode($request->input('file'));
        $zip = new ZipArchive();
        $fileName = storage_path("a pp/public/"."zip/" .  $today."_". $fileNum . '.zip');
        if ($zip->open($fileName, ZIPARCHIVE::CREATE) === TRUE){
            foreach($data as $key => $item){
                if ($item->receipt_file != null) {
                    $file = '';
                    $path = [];
                    $path = explode('/', $item->receipt_file);
                    $file = storage_path("app/" . $path[0] . "/" . $path[1]);
                    $relativeNameInZipFile = $item->finished_id . "_發票影本_".$path[1] ;
                    $zip->addFile($file, $relativeNameInZipFile);
                }
                if ($item->detail_file != null){
                    $file = '';
                    $path = [];
                    $path = explode('/', $item->detail_file);
                    $file = storage_path("app/" . $path[0] . "/" . $path[1]);
                    $relativeNameInZipFile = $item->finished_id . "_費用明細表_" .  $path[1];
                    $zip->addFile($file, $relativeNameInZipFile);
                } 
            }
        }
        $zip->close();
        return "download/" . "zip/" .  $today."_". $fileNum . '.zip';        
    }

    public function deleteZip(){
        $ZipDir = storage_path("app/public/"."zip/");
        $fileNum = count(glob("$ZipDir/*.*"));
        if($fileNum > 0 ){
            Storage::delete(Storage::files('public/zip'));
            $dirs = Storage::directories('public/zip');
            foreach($dirs as $dir){
                Storage::deleteDirectory($dir);
            }
        }
        return redirect()->route('invoice.index');
    }

    public function show(String $invoice_id)
    {
        //
        $invoice = Invoice::find($invoice_id);
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

        $businessTrips = BusinessTrip::where('invoice_id','=',$invoice->invoice_id)->get();

        
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
        //
        $type = ['salary','rent','accounting', 'insurance','cash','tax', 'other'];
        $company_name = ['grv', 'grv_2', 'rv'];
        $invoice = Invoice::find($invoice_id);
        // $invoice->content = InvoiceController::replaceEnter(false, $invoice->content);
        $projects = Project::select('project_id', 'name', 'status')->get()->toArray();
        foreach ($projects as $key => $project) {
            $projects[$key]['selected'] = ($project['project_id'] == $invoice->project_id) ? "selected" : " ";
        }
        $rv = Project::where('company_name', '=', 'rv')->where('status','!=','close')->orderby('created_at', 'desc')->get();
        $grv = Project::where('company_name', '=', 'grv')->where('status','!=','close')->orderby('created_at', 'desc')->get();
        $grv2 = Project::where('company_name', '=', 'grv_2')->where('status','!=','close')->orderby('created_at', 'desc')->get();

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
        return view('pm.invoice.editInvoice')->with('data', ['invoice' => $invoice->toArray(), 'projects' => $projects, 'type' => $type, 'company_name' => $company_name,'rv' => $rv,  'grv' => $grv , 'grv2' =>$grv2 ,'purchases'=>$purchases,'users'=>$users,'reviewers'=>$reviewers, 'interns'=>$interns]);
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
            'intern_name' => 'nullable|string',
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
            'detail_file' => 'nullable|file',
            'remittance_date' => 'nullable|date',
            'reviewer' => 'required|string'
        ]);
        if($invoice->company_name != $request->input('company_name')){  //如果有更改公司
            
            $invoice_ids = Invoice::select('invoice_id')->get()->map(function ($invoice) {
                return $invoice->invoice_id;
            })->toArray();
            $id = RandomId::getNewId($invoice_ids); //新的id
            $project = Project::find($request->input('project_id'));
            $numbers = Invoice::all();
            $i = 0;
            $max = 0;

            $receipt_file_path = null;
            $detail_file_path = null;

            if ($request->hasFile('receipt_file')) {
                if ($request->receipt_file->isValid()) {
                    $receipt_file_path = $request->receipt_file->storeAs('receipts',$request->receipt_file->getClientOriginalName());
                }
            }
            if ($request->hasFile('detail_file')) {
                if ($request->detail_file->isValid()) {
                    $detail_file_path = $request->detail_file->storeAs('details',$request->detail_file->getClientOriginalName())    ;
                }
            }
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
            $post = Invoice::create([
                'invoice_id' => $id,
                'user_id' => $invoice->user_id,
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
                'status' => $invoice->status,
                'finished_id' => $finished_id,
                'purchase_id' => $request->input('purchase_id'),
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
            if ($request->hasFile('receipt_file')) {
                if ($request->receipt_file->isValid()) {
                    \Illuminate\Support\Facades\Storage::delete($invoice->receipt_file);
                    $invoice->update(['receipt_file' => $request->receipt_file->storeAs('receipts',$request->receipt_file->getClientOriginalName())]);
                }
            }
            if ($request->hasFile('detail_file')) {
                if ($request->detail_file->isValid()) {
                    \Illuminate\Support\Facades\Storage::delete($invoice->detail_file);
                    $invoice->update(['detail_file' => $request->detail_file->storeAs('details',$request->detail_file->getClientOriginalName())]);
                }
            }

            
        }

        return redirect()->route('invoice.review', $invoice_id);
        // Invoice::where('invoice_id', $invoice_id)->updated_at = now();
    
        

        // if (!$request->input('receipt')){
        //     $event = InvoiceEvent::where('invoice_id', $invoice_id)->get()[0];
        //     EventController::update($event->event_id, $request->input('receipt_date'));
        // }
        
    }
    public function fix(Request $request, String $invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        //
        $request->validate([
            'intern_name' => 'nullable|string',
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
            'detail_file' => 'nullable|file',
            'reviewer' => 'required|string'

           
            // 'number' => 'required|integer',
            
        ]);
        //如果公司有更換
        if($invoice->company_name != $request->input('company_name')){
            //更改本身流水號
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
            $invoice->number = $i + 1;
            $invoice->finished_id = $finished_id;
            $invoice->save();
        }

        $invoice->update($request->except('_method', '_token', 'receipt_file', 'detail_file'));
        // Invoice::where('invoice_id', $invoice_id)->updated_at = now();
        if ($invoice->status == "waiting-fix") {
            $invoice->status = "waiting";
            $invoice->save();
            $user_id = 'GRV00002';
        } else if ($invoice->status == "check-fix") {
            $invoice->status = "check";
            $invoice->save();
            $user_id = $invoice->reviewer;
            
            
        }
        $reviewer_data = User::find($user_id);
        $email = 'zx99519567@gmail.com';//$reviewer_data->email
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $user_id,
            'title' => \Auth::user()->nickname . ' 已修改在 『' . $invoice->project->name . '』 的一筆請款，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('invoice.review', $invoice_id),
            'status' => 'not_read',
        ]);
        $maildata = [
            'title' => \Auth::user()->nickname . ' 已修改在 『' . $invoice->project->name . '』 的一筆請款，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('invoice.review', $invoice_id),
        ];
        Mail::to($email)->send(new EventMail($maildata));
        
        if ($request->hasFile('receipt_file')) {
            if ($request->receipt_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($invoice->receipt_file);
                $invoice->update(['receipt_file' => $request->receipt_file->storeAs('receipts',$request->receipt_file->getClientOriginalName())]);

            }
        }
        if ($request->hasFile('detail_file')) {
            if ($request->detail_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($invoice->detail_file);
                $invoice->update(['detail_file' => $request->detail_file->storeAs('details',$request->detail_file->getClientOriginalName())]);                
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
            'title' => '您在 『' . $invoice->project->name . '』 的一筆請款被退回。',
            'reason' => $request->input('reason'),
            'content' => '前往修改',
            'link' => route('invoice.edit', $invoice_id),
            'status' => 'not_read',
        ]);
        //accountant
        if ($invoice->status == 'waiting') {
            $invoice->status = 'waiting-fix';
            $invoice->save();
        } elseif ($invoice->status == 'check') {
            $invoice->status = 'check-fix';
            $invoice->save();
        }
        $reviewer_data = User::find($invoice->user_id);
        $email = 'zx99519567@gmail.com';//$reviewer_data->email
        $maildata = [
            'title' => '您在 『' . $invoice->project->name . '』 的一筆請款被退回。',
            'reason' => '',
            'content' => '前往修改',
            'link' => route('invoice.edit', $invoice_id),
        ];
        Mail::to($email)->send(new EventMail($maildata));


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
        if ($invoice->status == 'waiting') {
            $invoice->status = 'check';

            // $invoice->finished_id = $request->finished_id;
            // $invoice->managed = \Auth::user()->name;
            $invoice->save();
            // Mail::raw(route('invoice.review', $invoice_id), function ($message) use ($invoice_id) {
            //     $invoice = Invoice::find($invoice_id);

            //     $message->from('greenreadvision2020@gmail.com', 'greenreadvision');
            //     $message->to('jillianwu@grv.com.tw')->subject($invoice->project->name . '的一筆帳務待審核');
            // });
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => $invoice->reviewer,
                'title' => $invoice->user->nickname . ' 在 『' . $invoice->project->name . '』的一筆請款已通過第一階段審核。',
                'reason' => '',
                'content' => '前往第二階段審核',
                'link' => route('invoice.review', $invoice_id),
                'status' => 'not_read',
            ]);
            $reviewer_data = User::find($invoice->reviewer);
            $email = 'zx99519567@gmail.com';//$reviewer_data->email
            $maildata = [
                'title' => $invoice->user->nickname . ' 在 『' . $invoice->project->name . '』的一筆請款已通過第一階段審核。',
                'reason' => '',
                'content' => '前往第二階段審核',
                'link' => route('invoice.review', $invoice_id),
            ];
            Mail::to($email)->send(new EventMail($maildata));
        } else if ($invoice->status == 'check') {
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
                'title' => $invoice->user->nickname . ' 在 『' . $invoice->project->name . '』的一筆請款已通過第二階段審核。',
                'reason' => '',
                'content' => '前往第三階段審核',
                'link' => route('invoice.review', $invoice_id),
                'status' => 'not_read',
            ]);
            $reviewer_data = User::find('GRV00002');
            $email = 'zx99519567@gmail.com';//$reviewer_data->email
            $maildata = [
                'title' => $invoice->user->nickname . ' 在 『' . $invoice->project->name . '』的一筆請款已通過第二階段審核。',
                'reason' => '',
                'content' => '前往第三階段審核',
                'link' => route('invoice.review', $invoice_id),
            ];
            Mail::to($email)->send(new EventMail($maildata));

        } elseif ($invoice->status == 'managed') {
            $invoice->status = 'matched';
            $invoice->matched = \Auth::user()->name;
            $invoice->save();
        } elseif ( $invoice->status == 'matched') {
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
        return redirect()->route('invoice.review', $invoice_id);
    }
    // public function multipleMatch(Request $request, String $project_id)
    // {

    //     $test = $request->input('checkbox');
    //     foreach ($test as $data) {
    //         $invoice = Invoice::find($data);
    //         if (\Auth::user()->role == 'manager' && $invoice->status == 'check') {
    //             $invoice->status = 'managed';
    //             $invoice->managed = \Auth::user()->name;
    //             // $invoice->finished_id = $request->finished_id;
    //             $invoice->save();
    //         } elseif (\Auth::user()->role == 'accountant' && $invoice->status == 'managed') {
    //             $nowDate = date("Ymd");
    //             $invoice->status = 'matched';
    //             $invoice->matched = \Auth::user()->name;
    //             $invoice->save();
    //         } elseif (\Auth::user()->role == 'accountant' && $invoice->status == 'matched') {
    //             $nowDate = date("Ymd");
    //             $invoice->status = 'complete';
    //             $invoice->matched = \Auth::user()->name;

    //             $invoice->remittance_date = $nowDate;
    //             $invoice->save();
    //         }
    //     }


    //     return redirect()->route('invoice.list', $project_id);
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $invoice_id)
    {
        //Delete the invoice
        $invoice_delete = Invoice::find($invoice_id);

        \Illuminate\Support\Facades\Storage::delete([$invoice_delete->receipt_file, $invoice_delete->detail_file]);

        $invoice_delete->status = 'delete';
        $invoice_delete->save();
        return redirect()->route('invoice.index');
    }
}