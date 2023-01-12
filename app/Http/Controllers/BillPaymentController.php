<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Project;
use App\BillPayment;
use App\Intern;
use App\Bank;
use App\BusinessTrip;
use App\User;
use App\Letters;
use App\Functions\RandomId;
use App\Mail\EventMail;
use App\OtherBillPayment;
;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Nullable;
use ZipArchive;

class BillPaymentController extends Controller
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
            if ($allUser->role != 'manager' && count($allUser->billPayments) != 0) {
                array_push($users, $allUser);
            }
        }
        $interns = Intern::orderby('intern_id')->get();
        $billPayments = BillPayment::orderby('created_at', 'desc')->with('project')->with('user')->get();
        
        $otherBillPayments = OtherBillPayment::orderby('created_at', 'desc')->with('user')->get();

        $today = date("Y-m-d");
        foreach($billPayments as $billPayment){
            $Year = substr($billPayment->created_at,0,4);
            $Mouth =substr($billPayment->created_at,5,2);
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
            if($billPayment->status != 'delete' && $billPayment->status != 'complete' && $billPayment->status != 'complete_petty'){
                if($today  >= $Year . '-'. $Mouth .'-10'){
                    $billPayment->status = 'matched';
                    if($billPayment->reviewer !=null){
                        $reviewer = User::find('GRV00002');
                        $billPayment->managed = $reviewer->name;
                    }
                    if($billPayment->matched ==null){
                        $matched = User::find('GRV00002');
                        $billPayment->matched = $matched->name;
                    }
                    $billPayment->save();
                }
            }
        }
        foreach($otherBillPayments as $otherBillPayment){
            $Year = substr($otherBillPayment->created_at, 0,4);
            $Mouth =substr($otherBillPayment->created_at,5,2);
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
            
            
            
            if($otherBillPayment->status != 'delete' && $otherBillPayment->status != 'complete'){
                if($today  >= $Year . '-'. $Mouth .'-10'){
                    $otherBillPayment->status = 'matched';
                    if($otherBillPayment->reviewer !=null){
                        $reviewer = User::find('GRV00002');
                        $otherBillPayment->managed = $reviewer->name;
                    }
                    if($otherBillPayment->matched ==null){
                        $matched = User::find('GRV00002');
                        $otherBillPayment->matched = $matched->name;    
                    }
                    $otherBillPayment->save();
                }
            }
        }
        
        return view('pm.billPayment.indexBillPayment', ['users' => $users, 'billPayments' => $billPayments, 'otherBillPayments' => $otherBillPayments,'ZipCount' => $fileNum, 'interns'=>$interns]);
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

        return view('pm.billPayment.createBillPayment')->with('data', ['projects' => $projects,  'bank' => $bank,  'rv' => $rv,  'grv' => $grv, 'grv2' => $grv2,'users' => $users, 'interns'=>$interns]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $created_at = now();
        $payment_ids = BillPayment::select('payment_id')->get()->map(function ($billPayment) {
            return $billPayment->payment_id;
        })->toArray();

        $request->validate([
            'intern_name' => 'nullable|string',
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'remittancer' => 'required|string',
            'bank' => 'required|string|min:2|max:255',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'receipt' => 'required|Boolean',
            'receipt_date' => 'nullable|date',
            'receipt_number' => 'required|integer',
            'price' => 'required|integer',
            'receipt_file' => 'nullable|file',
            'detail_file' => 'nullable|file',
        ]);
        

        //查看流水號相關變數
        $id = RandomId::getNewId($payment_ids);
        $project = Project::find($request->input('project_id'));
        $numbers = BillPayment::all();
        $i = 0;
        $max = 0;
        //查看流水號月份是否正確
        $check_id = (date('Y') - 1911) . date("m");
        

        //設定最新流水編號
        foreach ($numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                if(substr($number['finished_id'],-8,5) == $check_id){
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
                if($number['bank'] == $project->company_name && substr($number['finished_id'],-8,5) == $check_id){
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
                $finished_id = "BPAR" . (date('Y') - 1911) . date("m") . $var;
                break;
            case 'grv_2':
                $finished_id = "BPAG" . (date('Y') - 1911) . date("m") . $var;
                break;
            case 'grv':
                $finished_id = "BPA" . (date('Y') - 1911) . date("m") . $var;
                break;
            default:
                break;
        }
        $intern = '';
        
        if(\Auth::user()->role =='manager'||'intern'){
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
                $receipt_file_path = $request->receipt_file->storeAs('billPayment_receipts', $finished_id.'_'.$request->receipt_file->getClientOriginalName());
            }
        }
        if ($request->hasFile('detail_file')) {
            if ($request->detail_file->isValid()) {
                $detail_file_path = $request->detail_file->storeAs('billPayment_details', $finished_id.'_'.$request->detail_file->getClientOriginalName())    ;
            }
        }
    
        
        $post = billPayment::create([
            'payment_id' => $id,
            'user_id' => \Auth::user()->user_id,
            'intern_name' => $intern,
            'project_id' => $request->input('project_id'),
            'remittancer' => $request->input('remittancer'),
            'bank' => $request->input('bank'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'receipt' => $request->input('receipt'),
            'receipt_date' => $request->input('receipt_date'),
            'receipt_number' => $request->input('receipt_number'),
            'price' => $request->input('price'),
            'receipt_file' => $receipt_file_path,
            'detail_file' => $detail_file_path,
            'status' => 'waiting',
            'number' => $i + 1,
            'finished_id' => $finished_id,
            'review_date' => $request->input('review_date'),
        ]);



       
        $project_ids = BillPayment::select('project_id')->orderby('project_id')->distinct()->get();
        $billPayment_groups = [];
        foreach ($project_ids->toArray() as $project_id) {
            array_push($billPayment_groups, BillPayment::where('project_id', $project_id)->orderby('created_at', 'desc')->with('project')->get());
        }
      
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => 'GRV00002',
            'title' => \Auth::user()->nickname . ' 在 『' . $project->name . '』 新增一筆繳款，待審核。',
            'reason' => '',
            'content' => '前往審核',
            'link' => route('billPayment.review', $id),
            'status' => 'not_read',
        ]);
        $reviewer_data = User::find('GRV');//GRV00002
        $email = $reviewer_data->email;
        $maildata = [
            'title' => \Auth::user()->nickname . ' 在 『' . $project->name . '』 新增一筆繳款，待審核。',
            'reason' => '',
            'content' => '前往審核',
            'link' => route('billPayment.review', $id),
        ];
        // Mail::to($email)->send(new EventMail($maildata));

        return redirect()->route('billPayment.review', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BillPayment  $billPayment
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
        $fileName = storage_path("app/public/"."zip/" .  $today."_". $fileNum . '.zip');
        if ($zip->open($fileName, ZipArchive::CREATE) === TRUE){
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
        return redirect()->route('billPayment.index');
    }

    public function show(String $billPayment_id)
    {
        //
        $billPayment = BillPayment::find($billPayment_id);
        
        
        // $billPayment->content = BillPaymentController::replaceEnter(false, $billPayment->content);
        if ($billPayment->receipt_file != null) $billPayment->receipt_file = explode('/', $billPayment->receipt_file);
        if ($billPayment->detail_file != null) $billPayment->detail_file = explode('/', $billPayment->detail_file);

        
        return view('pm.billPayment.showBillPayment')->with('data',['billPayment'=>$billPayment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BillPayment  $billPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(String $billPayment_id)
    {
        //
        $type = ['salary','rent','accounting', 'insurance','cash','tax', 'other'];
        $company_name = ['grv', 'grv_2', 'rv'];
        $billPayment = BillPayment::find($billPayment_id);
        // $billPayment->content = BillPaymentController::replaceEnter(false, $billPayment->content);
        $projects = Project::select('project_id', 'name', 'status')->get()->toArray();
        foreach ($projects as $key => $project) {
            $projects[$key]['selected'] = ($project['project_id'] == $billPayment->project_id) ? "selected" : " ";
        }
        $rv = Project::where('company_name', '=', 'rv')->where('status','=','running')->orderby('created_at', 'desc')->get();
        $grv = Project::where('company_name', '=', 'grv')->where('status','=','running')->orderby('created_at', 'desc')->get();
        $grv2 = Project::where('company_name', '=', 'grv_2')->where('status','=','running')->orderby('created_at', 'desc')->get();

        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->purchases) != 0) {
                array_push($users, $allUser);
            }
        }
        $interns = Intern::orderby('intern_id')->get();
        $purchases = Purchase::orderby('purchase_date', 'desc')->with('project')->with('user')->get();
        return view('pm.billPayment.editBillPayment', ['billPayment_id' => $billPayment_id])->with('data', ['billPayment' => $billPayment->toArray(), 'projects' => $projects, 'type' => $type, 'company_name' => $company_name,'rv' => $rv,  'grv' => $grv , 'grv2' =>$grv2 ,'purchases'=>$purchases,'users'=>$users, 'interns'=>$interns]);
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
        $billPayment = BillPayment::find($billPayment_id);
        //
        $request->validate([
            'intern_name' => 'nullable|string',
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'remittancer' => 'required|string',
            'bank' => 'required|string|min:2|max:255',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'receipt' => 'required|Boolean',
            'receipt_date' => 'nullable|date',
            'receipt_number' => 'required|integer',
            'price' => 'required|integer',
            'receipt_file' => 'nullable|file',
            'detail_file' => 'nullable|file',
        ]);
        if($billPayment->company_name != $request->input('company_name')){  //如果有更改公司
            
            $billPayment_ids = BillPayment::select('billPayment_id')->get()->map(function ($billPayment) {
                return $billPayment->billPayment_id;
            })->toArray();
            $id = RandomId::getNewId($billPayment_ids); //新的id
            $project = Project::find($request->input('project_id'));
            $numbers = BillPayment::all();
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
                    $finished_id = "BPAR" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                case 'grv_2':
                    $finished_id = "BPAG" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                case 'grv':
                    $finished_id = "BPA" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                default:
                    break;
            }

            $intern = '';
        
            if(\Auth::user()->role =='manager'||'intern'){
                $intern = $request->input('intern_name');
                echo "<script>console.log($intern)</script>";
            }
            else{
                $intern = NULL;
            }

            $post = billPayment::create([
                'payment_id' => $id,
                'user_id' => \Auth::user()->user_id,
                'intern_name' => $intern,
                'project_id' => $request->input('project_id'),
                'remittancer' => $request->input('remittancer'),
                'bank' => $request->input('bank'),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'receipt' => $request->input('receipt'),
                'receipt_date' => $request->input('receipt_date'),
                'receipt_number' => $request->input('receipt_number'),
                'price' => $request->input('price'),
                'receipt_file' => $receipt_file_path,
                'detail_file' => $detail_file_path,
                'status' => 'waiting',
                'number' => $i + 1,
                'finished_id' => $finished_id,
                'review_date' => $request->input('review_date'),
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
            if ($request->hasFile('receipt_file')) {
                if ($request->receipt_file->isValid()) {
                    \Illuminate\Support\Facades\Storage::delete($billPayment->receipt_file);
                    $billPayment->update(['receipt_file' => $request->receipt_file->storeAs('receipts',$request->receipt_file->getClientOriginalName())]);
                }
            }
            if ($request->hasFile('detail_file')) {
                if ($request->detail_file->isValid()) {
                    \Illuminate\Support\Facades\Storage::delete($billPayment->detail_file);
                    $billPayment->update(['detail_file' => $request->detail_file->storeAs('details',$request->detail_file->getClientOriginalName())]);
                }
            }

            
        }

        return redirect()->route('billPayment.review', $billPayment_id)->with('data', ['billPayment' => $billPayment]);
        // BillPayment::where('billPayment_id', $billPayment_id)->updated_at = now();
    
        

        // if (!$request->input('receipt')){
        //     $event = BillPaymentEvent::where('billPayment_id', $billPayment_id)->get()[0];
        //     EventController::update($event->event_id, $request->input('receipt_date'));
        // }
        
    }
    public function fix(Request $request, String $billPayment_id)
    {
        $billPayment = BillPayment::find($billPayment_id);
        //
        $request->validate([
            'intern_name' => 'nullable|string',
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'remittancer' => 'required|string',
            'bank' => 'required|string|min:2|max:255',
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:100',
            'receipt' => 'required|Boolean',
            'receipt_date' => 'nullable|date',
            'receipt_number' => 'required|integer',
            'price' => 'required|integer',
            'receipt_file' => 'nullable|file',
            'detail_file' => 'nullable|file',
        ]);
        //如果公司有更換
        if($billPayment->company_name != $request->input('company_name')){
            //更改本身流水號
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
                    $finished_id = "BPAR" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                case 'grv_2':
                    $finished_id = "BPAG" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                case 'grv':
                    $finished_id = "BPA" . (date('Y') - 1911) . substr($billPayment->created_at, 5, 2) . $var;
                    break;
                default:
                    break;
            }
            $billPayment->number = $i + 1;
            $billPayment->finished_id = $finished_id;
            $billPayment->save();
        }

        $billPayment->update($request->except('_method', '_token', 'receipt_file', 'detail_file'));
        // BillPayment::where('billPayment_id', $billPayment_id)->updated_at = now();
        if ($billPayment->status == "waiting-fix") {
            $billPayment->status = "waiting";
            $billPayment->save();
            $user_id = 'GRV00002';
        }
        // $reviewer_data = User::find($user_id);
        $email = '2421882aa@gmail.com';//$reviewer_data->email
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $user_id,
            'title' => \Auth::user()->nickname . ' 已修改在 『' . $billPayment->project->name . '』 的一筆繳款，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('billPayment.review', $billPayment_id),
            'status' => 'not_read',
        ]);
        $maildata = [
            'title' => \Auth::user()->nickname . ' 已修改在 『' . $billPayment->project->name . '』 的一筆繳款，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('billPayment.review', $billPayment_id),
        ];
        Mail::to($email)->send(new EventMail($maildata));
        
        if ($request->hasFile('receipt_file')) {
            if ($request->receipt_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($billPayment->receipt_file);
                $billPayment->update(['receipt_file' => $request->receipt_file->storeAs('receipts',$request->receipt_file->getClientOriginalName())]);

            }
        }
        if ($request->hasFile('detail_file')) {
            if ($request->detail_file->isValid()) {
                \Illuminate\Support\Facades\Storage::delete($billPayment->detail_file);
                $billPayment->update(['detail_file' => $request->detail_file->storeAs('details',$request->detail_file->getClientOriginalName())]);                
            }
        }


        return redirect()->route('billPayment.review', $billPayment_id);
    }
    public function withdraw(Request $request, String $billPayment_id)
    {
        // return $request->finished_id;
        $billPayment = BillPayment::find($billPayment_id);

        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $billPayment->user_id,
            'title' => '您在 『' . $billPayment->project->name . '』 的一筆繳款被退回。',
            'reason' => $request->input('reason'),
            'content' => '前往修改',
            'link' => route('billPayment.edit', $billPayment_id),
            'status' => 'not_read',
        ]);
        //accountant
        if ($billPayment->status == 'waiting') {
            $billPayment->status = 'waiting-fix';
            $billPayment->save();
        } 
        $reviewer_data = User::find($billPayment->user_id);
        $email = '2421882aa@gmail.com';//$reviewer_data->email
        $maildata = [
            'title' => '您在 『' . $billPayment->project->name . '』 的一筆繳款被退回。',
            'reason' => '',
            'content' => '前往修改',
            'link' => route('billPayment.edit', $billPayment_id),
        ];
        Mail::to($email)->send(new EventMail($maildata));


        return redirect()->route('billPayment.review', $billPayment_id);
    }
    /**
     * Match the billPayments and update the status by accountant and manager.
     *
     * @param \App\BillPayment  $billPayment
     */
    public function managed(Request $request, String $billPayment_id)
    {
        // return $request->finished_id;
        $billPayment = BillPayment::find($billPayment_id);

        //accountant
        if ($billPayment->status == 'waiting') {
            $billPayment->status = 'managed';
            $nowDate = date("Y-m-d H:i:s");
            $billPayment->review_date = $nowDate;
            $billPayment->save();
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => 'GRV00002',
                'title' => $billPayment->user->nickname . ' 在 『' . $billPayment->project->name . '』的一筆繳款已通過審核。',
                'reason' => '',
                'content' => '前往查看',
                'link' => route('billPayment.review', $billPayment_id),
                'status' => 'not_read',
            ]);
            $email = '2421882aa@gmail.com';//$reviewer_data->email
            $maildata = [
                'title' => $billPayment->user->nickname . ' 在 『' . $billPayment->project->name . '』的一筆繳款已通過審核。',
                'reason' => '',
                'content' => '前往查看',
                'link' => route('billPayment.review', $billPayment_id),
            ];
            Mail::to($email)->send(new EventMail($maildata));
        }
        return redirect()->route('billPayment.review', $billPayment_id);
    }
    // public function multipleMatch(Request $request, String $project_id)
    // {

    //     $test = $request->input('checkbox');
    //     foreach ($test as $data) {
    //         $billPayment = BillPayment::find($data);
    //         if (\Auth::user()->role == 'manager' && $billPayment->status == 'check') {
    //             $billPayment->status = 'managed';
    //             $billPayment->managed = \Auth::user()->name;
    //             // $billPayment->finished_id = $request->finished_id;
    //             $billPayment->save();
    //         } elseif (\Auth::user()->role == 'accountant' && $billPayment->status == 'managed') {
    //             $nowDate = date("Ymd");
    //             $billPayment->status = 'matched';
    //             $billPayment->matched = \Auth::user()->name;
    //             $billPayment->save();
    //         } elseif (\Auth::user()->role == 'accountant' && $billPayment->status == 'matched') {
    //             $nowDate = date("Ymd");
    //             $billPayment->status = 'complete';
    //             $billPayment->matched = \Auth::user()->name;

    //             $billPayment->remittance_date = $nowDate;
    //             $billPayment->save();
    //         }
    //     }


    //     return redirect()->route('billPayment.list', $project_id);
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BillPayment  $billPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $billPayment_id)
    {
        //Delete the billPayment
        $billPayment_delete = BillPayment::find($billPayment_id);

        \Illuminate\Support\Facades\Storage::delete([$billPayment_delete->receipt_file, $billPayment_delete->detail_file]);

        $billPayment_delete->status = 'delete';
        $billPayment_delete->save();
        return redirect()->route('billPayment.index');
    }
}