<?php

namespace App\Http\Controllers;

use App\Acceptance;
use App\DefaultItem;
use App\Event;
use App\Project;
use App\ProjectEvent;
use App\User;

use App\Functions\RandomId;
use App\Gding;
use App\Http\Controllers\EventController;
use App\Invoice;
use App\BillPayment;
use App\Letters;
use App\OtherInvoice;
use App\Performance;
use App\ProjectSOP_item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Letter;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = [];
        $allUsers = User::orderby('nickname')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->status != 'resign') {
                array_push($users, $allUser);
            }
        }
        $projects = Project::orderby('open_date', 'desc')->with('user')->with('agent')->get();
        return view('pm.project.indexProject', ['users' => $users, 'projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = [];
        $allUsers = User::orderby('nickname')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->status != 'resign' && $allUser->role != 'intern' ) {
                array_push($users, $allUser);
            }
        }
        return view('pm.project.createProject',['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:projects|min:1|max:255',
            'user_id'=> 'required',
            'agent_id'=>'nullable',
            'agent_type'=>'nullable',
            // 'beginning_date' => 'required|date',
            'company_name' => 'required|string|min:1|max:255',
            'deadline_date' => 'required|date',
            'deadline_time' => 'date_format:H:i',
            'open_date' => 'required|date',
            'open_time' => 'date_format:H:i',
            'closing_date' => 'required|date',
            'color' => 'required|string|size:7'
        ]);

        $project_ids = Project::select('project_id')->get()->map(function ($project) {
            return $project->project_id;
        })->toArray();
        $newId = RandomId::getNewId($project_ids);

        $post = Project::create([
            'project_id' => $newId,
            'user_id' => $request->input('user_id'),
            'agent_id'=> $request->input('agent_id'),
            'agent_type'=> $request->input('agent_type'),
            'name' => $request->input('name'),
            'company_name' => $request->input('company_name'),
            // 'beginning_date' => $request->input('beginning_date'),
            'deadline_date' => $request->input('deadline_date'),
            'deadline_time' => $request->input('deadline_time'),
            'open_date' => $request->input('open_date'),
            'open_time' => $request->input('open_time'),
            'closing_date' => $request->input('closing_date'),
            'contract_value' => $request->input('contract_value'),
            'color' => $request->input('color'),
            'status' => 'unacceptable'
        ]);

        // EventController::create($request->input('beginning_date'), __('customize.beginning_date'), __('customize.beginning_date'), __('customize.Project'), 'project', $newId);
        EventController::create($request->input('deadline_date'), __('customize.deadline_date'), __('customize.deadline_date'), __('customize.Project'), 'project', $newId);
        EventController::create($request->input('closing_date'), __('customize.closing_date'), __('customize.closing_date'), __('customize.Project'), 'project', $newId);
        EventController::create($request->input('open_date'), __('customize.open_date'), __('customize.open_date'), __('customize.Project'), 'project', $newId);

        return redirect()->route('project.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(String $project_id)
    {
        //
        $project = Project::find($project_id);
        $project_sop_item = ProjectSOP_item::all();
        if($project->performance_id!=null){
            if ($project['performance']->deposit_file != null) $project['performance']->deposit_file = explode('/', $project['performance']->deposit_file);
            if ($project['performance']->PayBack_file != null) $project['performance']->PayBack_file = explode('/',$project['performance']->PayBack_file);
            
        }
        if ($project->jianhao_statement != null) $project->jianhao_statement = explode('/',$project->jianhao_statement);
        if ($project->income_statement != null) $project->income_statement = explode('/',$project->income_statement);
        $gding = Gding::where('project_id','=',$project_id)->orderby('id')->get();
        $invoice = Invoice::where('project_id','=',$project_id)->orderby('created_at','desc')->get();
        $billPayment = BillPayment::where('project_id','=',$project_id)->orderby('created_at','desc')->get();
        

        return view('pm.project.showProject',['data'=> $project,'invoice_table'=>$invoice,'gding_table'=>$gding,'billPayment_table'=>$billPayment,'project_sop_item'=>$project_sop_item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(String $project_id)
    {
        $company_name = ['grv_2', 'rv','grv'];
        $project = Project::find($project_id);
        $project_sop_item = ProjectSOP_item::all();
        $gding = Gding::where('project_id','=',$project_id)->orderby('id')->get();
        $invoice = Invoice::where('project_id','=',$project_id)->orderby('created_at','desc')->get();
        $billPayment = BillPayment::where('project_id','=',$project_id)->orderby('created_at','desc')->get();


        if($project->performance_id!=null){
            if ($project['performance']->deposit_file != null) $project['performance']->deposit_file = explode('/', $project['performance']->deposit_file);
            if ($project['performance']->PayBack_file != null) $project['performance']->PayBack_file = explode('/',$project['performance']->PayBack_file);
        }
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->status != 'resign' && $allUser->role != 'intern' ) {
                array_push($users, $allUser);
            }
        }
        return view('pm.project.editProject')->with('data', ['project' =>  $project,'gding_table'=>$gding,'billPayment_table'=>$billPayment,'company_name' => $company_name,'users' => $users,'invoice_table' => $invoice,'project_sop_item'=>$project_sop_item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $project_id)
    {

        $project = Project::find($project_id);

        if ($request->input('beginning_date') != null && $project->beginning_date == NULL) {
            EventController::create($request->input('beginning_date'), __('customize.beginning_date'), __('customize.beginning_date'), __('customize.Project'), 'project',  $project_id);
        }
        $request->validate([
            'name' => ['required', 'string', 'min:1', 'max:255', Rule::unique('projects')->ignore($project_id, 'project_id')],
            'agent_id'=>'nullable|string',
            'agent_type' =>'nullable|string',
            'beginning_date' => 'nullable|date',
            'deadline_date' => 'required|date',
            'closing_date' => 'required|date',
            'company_name' => 'required|string|min:1|max:255',
            // 'deadline_time' => 'date_format:H:i:s',
            // 'open_time' => 'date_format:H:i:s',
            'open_date' => 'required|date',
            'contract_value' => 'required|string|max:255',
            'case_num' => 'nullable|string|max:255',
            'default_fine' => 'nullable|string|max:255',
            'estimated_cost' => 'nullable|integer',
            'estimated_profit' => 'nullable|integer',
            'actual_cost' => 'nullable|integer',
            'actual_profit' => 'nullable|integer',
            'effective_interest_rate' => 'nullable|string|max:255',
            'color' => 'required|string|size:7',
            'status' => 'nullable|string',
            'project_note' => 'nullable|string',
            'Acceptance_times' => 'required|string|size:1',
            'jianhao_statement' => 'nullable|file',
            'income_statement' => 'nullable|file'
        ]);


        //專案驗收日期更新
        $Acceptance_times = $request->input('Acceptance_times');
        $Acceptance = Acceptance::where('project_id','=',$project_id)->get();


        for($i = 1 ; $i <=$Acceptance_times ;$i++){
            $request->validate([
                'acceptance_date_' . $i =>'nullable|date',
                'acceptance_persen_' . $i =>'nullable|string|max:3'
            ]);
        }
        $i = 1;
        if($Acceptance_times>= count($Acceptance)){     //更新後得期數比更新前多或一樣
            $i = 1;
            foreach($Acceptance as $item){
            
                if($i <= count($Acceptance)){
                    $item->no = $i;
                    $item->persen = $request->input('acceptance_persen_' . $i);
                    $item->acceptance_date = $request->input('acceptance_date_' . $i);
                    $i++;
                    $item->save();
                }
                       
            }
            for($j = count($Acceptance)+ 1 ; $j<=$Acceptance_times;$j++){
                Acceptance::create([
                    'no' => $j,
                    'project_id' => $project_id,
                    'persen'=> $request->input('acceptance_persen_' . $j),
                    'acceptance_date' =>$request->input('acceptance_date_' . $j)
                    
                ]);
            }
        }else if($Acceptance_times< count($Acceptance)){
            $i = 1;
            foreach($Acceptance as $item){
            
                if($i <= $Acceptance_times){
                    $item->no = $i;
                    $item->persen = $request->input('acceptance_persen_' . $i);
                    $item->acceptance_date = $request->input('acceptance_date_' . $i);
                    $i++;
                    $item->save();
                }
                else if($i> $Acceptance_times){
                    $item->delete();
                    $i++;
                }
            }
        }

        $file_path =null;
        if($request->hasFile('jianhao_statement')){
            if($request->jianhao_statement->isValid()){
                $file = $request->file('jianhao_statement');
                $file->storeAs('public/project/'.$project->name,$file->getClientOriginalName());
                $file_path = 'project/'.$project->name.'/'.$file->getClientOriginalName();
                $project->jianhao_statement = $file_path;
            }
        }
        
        if($request->hasFile('income_statement')){
            if($request->income_statement->isValid()){
                $file = $request->file('income_statement');
                $file->storeAs('public/project/'.$project->name,$file->getClientOriginalName());
                $file_path = 'project/'.$project->name.'/'.$file->getClientOriginalName();
                $project->income_statement = $file_path;
            }
        }

        

        
        //專案本體更新
        $project->case_num = $request->input('case_num');
        $project->color = $request->input('color');
        $project->company_name = $request->input('company_name');
        $project->name = $request->input('name');
        $project->Acceptance_times = $request->input('Acceptance_times');
        $project->deadline_date = $request->input('deadline_date');
        $project->deadline_time = $request->input('deadline_time');
        $project->open_date = $request->input('open_date');
        $project->open_time = $request->input('open_time');
        $project->beginning_date = $request->input('beginning_date');
        $project->closing_date = $request->input('closing_date');
        $project->contract_value = $request->input('contract_value');
        $project->default_fine = $request->input('default_fine');
        $project->estimated_cost = $request->input('estimated_cost');
        $project->estimated_profit = $request->input('estimated_profit');
        $project->actual_cost = $request->input('actual_cost');
        $project->actual_profit = $request->input('actual_profit');
        $project->effective_interest_rate = $request->input('effective_interest_rate');
        $project->project_note = $request->input('project_note');
        $project->agent_id = $request->input('agent_id');
        $project->agent_type = $request->input('agent_type');
        $project->save();
        

        $events = ProjectEvent::where('project_id', $project_id)->get();

        foreach ($events as $key => $event) {
            $newDate = '';
            if ($event) {
            }

            switch ($key) {
                case 0:
                    $newDate = $request->input('deadline_date');
                    break;
                case 1:
                    $newDate = $request->input('closing_date');
                    break;
                case 2:
                    $newDate = $request->input('open_date');
                    break;
                case 3:
                    $newDate = $request->input('beginning_date');
                    break;
                default:
                    break;
            }
            EventController::update($event->event_id, $newDate, null, null, null);
        }
        return redirect()->route('project.review', $project_id);
    }

    public function updateStatus(Request $request, String $project_id)
    {

        $project = Project::find($project_id);
        $project->status = $request->input('status');
        $project->save();
        return redirect()->route('project.edit', $project_id);
    }

    public function transfer(Request $request,String $project_id){
        $project = Project::find($project_id);
        if($project->user_id == \Auth::user()->user_id && $request->input('user') == $project->agent_id){
            $project->user_id = $request->input('user');
            $project->agent_id = \Auth::user()->user_id;
            $project->save();
        }
        else if($project->agent_id == \Auth::user()->user_id && $request->input('user') == $project->user_id){
            $project->agent_id = $request->input('user');
            $project->user_id = \Auth::user()->user_id;
            $project->save();
        }
        else{
            $project->receiver = $request->input('user');
            $project->save();
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => $request->input('user'),
                'title' => \Auth::user()->nickname . ' 將 『' . $project->name . '』 此轉讓給您，請前往查核並同意',
                'reason' => '',
                'content' => '前往接受轉讓專案',
                'link' => route('project.review', $project_id),
                'status' => 'not_read',
            ]);
        }
        return redirect()->route('project.review', $project_id);
    }

    public function receive(Request $request,String $project_id,String $tranfer_answer){
        if($tranfer_answer == "refuse"){
            $project = Project::find($project_id);

            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => $project->user_id,
                'title' => \Auth::user()->nickname . ' 拒絕成為『' . $project->name . '』 此專案負責人',
                'reason' => '',
                'content' => '專案遭受拒絕，拒絕原因：' . $request->input('refuse_content'),
                'link' => route('project.review', $project_id),
                'status' => 'not_read',
            ]);

            $project->receiver = "";
            $project->save();
        }else if($tranfer_answer == "agree"){
            $project = Project::find($project_id);

            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => $project->user_id,
                'title' => \Auth::user()->nickname . ' 已經同意並成為『' . $project->name . '』 此專案負責人',
                'reason' => '',
                'content' => '確定轉讓結果',
                'link' => route('project.review', $project_id),
                'status' => 'not_read',
            ]);

            $project->user_id = \Auth::user()->user_id;
            $project->receiver = "";
            $project->save();
        }
        return redirect()->route('project.review', $project_id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $project_id)
    {
        //Delete the project and any following datas.
        $project = Project::find($project_id);
        foreach ($project->projectEvents as $projectEvent) $projectEvent->event->delete();
        foreach ($project->invoices as $invoice) if (isset($invoice->invoiceEvent->event)) $invoice->invoiceEvent->event->delete();
        foreach ($project->todos as $todo) $todo->todoEvent->event->delete();

        $project->delete();

        return redirect()->route('project.index');
    }

    public function setCost(String $project_id){
        
        $project = Project::find($project_id);
        $gding = Gding::where('project_id','=',$project_id)->get();
        $invoices = Invoice::where('project_id','=',$project_id)->get();
        $billPayments = BillPayment::where('project_id','=',$project_id)->get();
        $default = DefaultItem::where('project_id','=',$project_id)->get();
        $performance = Performance::where('project_id','=',$project_id)->get();
        $total_cost = 0;
        foreach($gding as $item){
            $total_cost += $item->price;
        }
        foreach($invoices as $item){
            if($item -> prepay == 0 || $item -> prepay == null){
                $total_cost += $item->price;
            }
        }
        //foreach($billPayments as $item){
        //    $total_cost -= $item->price;
        //}
        foreach($default as $item){
            $contract_value = $project->contract_value;
            $total_cost = $total_cost + ($contract_value*$item->persen/100);
        }
        foreach($performance as $item){
            $project->actual_cost = $total_cost - $item->deposit;
        }
        $project->actual_profit = $project->contract_value - $total_cost;
        $project->save();

        return redirect()->route('project.edit', $project_id);
    }
}
