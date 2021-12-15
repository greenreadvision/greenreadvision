<?php

namespace App\Http\Controllers;

use App\Functions\RandomId;
use App\Letters;
use App\Mail\EventMail;
use App\Project;
use App\Seal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SealController extends Controller
{
    public function index(){
        $users = [];
        $company = ['grv_2','rv','grv'];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->invoices) != 0 && $allUser->status !='resign') {
                array_push($users, $allUser);
            }
        }
        $seals = Seal::orderby('created_at', 'desc')->with('user')->with('project')->with('seal_user')->get();
        return view("pm.seal.index",['users'=>$users,'seals'=>$seals,'company' => $company]);
    }

    public function create(){
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->role != 'intern' && $allUser->status !='resign') {
                array_push($users, $allUser);
            }
        }
        $rv = Project::where('company_name', '=', 'rv' ,'and', 'finish','=','0')->orderby('created_at', 'desc')->get();
        $grv = Project::where('company_name', '=', 'grv' ,'and', 'finish','=','0')->orderby('created_at', 'desc')->get();
        $grv2 = Project::where('company_name', '=', 'grv_2','and', 'finish','=','0')->orderby('created_at', 'desc')->get();
        return view("pm.seal.create",['users'=>$users,'rv' => $rv,'grv' => $grv,'grv2'=>$grv2]);
    }

    public function store(Request $request){
        $request->validate([
            "select_project" => 'required|string',
            "object" => 'required|string|max:255|min:1',
            "select_seal" => 'required|string',
            "select_file" => 'required|string',
            "file_other" => 'nullable|string|max:255',
            "content" => 'required|string|max:255|min:1'
        ]);
        if($request->input('date_type') == 'onedate'){
            $firste_date = $request->input('one_date');
            $end_date = null;
        }else if($request->input('date_type') =='manydate'){
            $firste_date =$request->input('first_date');
            $end_date = $request->input('end_date');
        }

        $seal_ids = Seal::select('seal_id')->get()->map(function ($seal) {
            return $seal->seal_id;
        })->toArray();
        $id = RandomId::getNewId($seal_ids);

        if($request->input('select_project')!='other-grv_2' && $request->input('select_project')!='other-rv' && $request->input('select_project')!='other-grv'){
            $project = Project::find($request->input('select_project'));
            $project_id = $project->project_id;
            $project_company_name =  $project-> company_name;
            $project_name = $project->name;
        }
        else{
            $project_id = $request->input('select_project') ;
            $temp = explode('-',$request->input('select_project'));
            $project_company_name =$temp[count($temp) - 1];
            if($request->input('select_project')!='other-grv_2'){
                $project_name = '綠雷德-其他';
            }else if($request->input('select_project')!='other-rv'){
                $project_name = '閱野-其他';
            }else if($request->input('select_project')!='other-grv'){
                $project_name = '綠雷德(舊)-其他';
            }
            
        }
        
        $numbers = Seal::all();
        $i = 0;
        $max = 0;
        foreach ($numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                if($number['company'] == $project_company_name){
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
        switch($project_company_name){
            case 'rv':
                $finished_id = "Rv-" . (date('Y') - 1911) . date("m") . $var;
                break;
            case 'grv_2':
                $finished_id = "Grv-" . (date('Y') - 1911) . date("m") . $var;
                break;
            case 'grv':
                $finished_id = "Grv_Old-" . (date('Y') - 1911) . date("m") . $var;
                break;
            default:
                break;
        }
        $other_content =null;
        if($request->input('file_other') == ""){
            $other_content =null;
        }else{
            $other_content = $request->input('file_other');
        }

        $create_day = date("Y-m-d");

        $post = Seal::create([
            'seal_id' => $id,
            'user_id' => \Auth::user()->user_id,
            'seal_type' => $request->input('select_seal'),
            'file_type' => $request->input('select_file'),
            'file_other_content' => $other_content,
            'number' => $i + 1,
            'object' => $request->input('object'),
            'project_id' => $project_id,
            'company' => $project_company_name,
            'content' => $request->input('content'),
            'seal_user_id' => $request->input('select_user'),
            'final_id' => $finished_id,
            'create_day' => $create_day,
            'contract_first_date' => $firste_date,
            'contract_end_date' => $end_date,
            'status' => 'waiting'
        ]);
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => 'GRV00001',
            'title' => \Auth::user()->nickname . ' 已申請在 『' . $project_name . '』 的用印申請內容，請執行審核。',
            'reason' => '',
            'content' => '執行審核',
            'link' => route('seal.show', $id),
            'status' => 'not_read',
        ]);
        $email = 'zx99519567@gmail.com';
        $maildata = [
            'title' => \Auth::user()->nickname . ' 已申請在 『' . $project_name . '』 的用印申請內容，請執行審核。',
            'reason' => '',
            'content' => '執行審核',
            'link' => route('seal.show', $id)
        ];
        Mail::to($email)->send(new EventMail($maildata));
        return redirect()->route('seal.show', $id);
        
    }

    public function show(string $seal_id){
        $seal = Seal::find($seal_id);
        return view("pm.seal.show",['seal' => $seal]);
    }

    public function edit(string $seal_id){
        $seal = Seal::find($seal_id);
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->role != 'intern' && $allUser->status !='resign') {
                array_push($users, $allUser);
            }
        }
        $rv = Project::where('company_name', '=', 'rv' ,'and', 'finish','=','0')->orderby('created_at', 'desc')->get();
        $grv = Project::where('company_name', '=', 'grv' ,'and', 'finish','=','0')->orderby('created_at', 'desc')->get();
        $grv2 = Project::where('company_name', '=', 'grv_2','and', 'finish','=','0')->orderby('created_at', 'desc')->get();

        return view("pm.seal.edit",['seal' => $seal,'users'=>$users,'rv' => $rv,'grv' => $grv,'grv2'=>$grv2]);
    }

    public function update(Request $request,string $seal_id){
        $seal = Seal::find($seal_id);
        if($request->input('date_type') == 'onedate'){
            $firste_date = $request->input('one_date');
            $end_date = null;
        }else if($request->input('date_type') =='manydate'){
            $firste_date =$request->input('first_date');
            $end_date = $request->input('end_date');
        }
        $request->validate([
            "select_project" => 'required|string',
            "object" => 'required|string|max:255|min:1',
            "select_user" => 'required|string',
            "select_seal" => 'required|string',
            "select_file" => 'required|string',
            "file_other" => 'nullable|string|max:255',
            "content" => 'required|string|max:255|min:1'
        ]);

        if($request->input('select_project')!='other-grv_2' && $request->input('select_project')!='other-rv' && $request->input('select_project')!='other-grv'){
            $project = Project::find($request->input('select_project'));
            $project_id = $project->project_id;
            $project_company_name =  $project-> company_name;
        }
        else{
            $project_id = $request->input('select_project') ;
            $temp = explode('-',$request->input('select_project'));
            $project_company_name =$temp[count($temp) - 1];
        }

        if($seal->company != $project_company_name){
            $numbers = Seal::all();
            $i = 0;
            $max = 0;
            foreach ($numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                    if($number['company'] == $project_company_name){
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
            switch($project_company_name){
                case 'rv':
                    $finished_id = "Rv-" . (date('Y') - 1911) . date("m") . $var;
                    break;
                case 'grv_2':
                    $finished_id = "Grv-" . (date('Y') - 1911) . date("m") . $var;
                    break;
                case 'grv':
                    $finished_id = "Grv_Old-" . (date('Y') - 1911) . date("m") . $var;
                    break;
                default:
                    break;
            }
            $seal->number = $i+1; 
            $seal->final_id = $finished_id;
        }

        $other_content =null;
        if($request->input('file_other') == ""){
            $other_content =null;
        }else{
            $other_content = $request->input('file_other');
        }

        $seal->seal_type = $request->input('select_seal');
        $seal->file_type = $request->input('select_file');
        $seal->file_other_content = $other_content;
        $seal->object = $request->input('object');
        $seal->project_id = $project_id;
        $seal->company = $project_company_name;
        $seal->content = $request->input('content');
        $seal->seal_user_id = $request->input('select_user');
        $seal->contract_first_date = $firste_date;
        $seal->contract_end_date = $end_date;



        $seal->save();

        
        return redirect()->route('seal.show', $seal_id);

    }

    public function fix(Request $request,string $seal_id){
        $seal = Seal::find($seal_id);
        $request->validate([
            "select_project" => 'required|string',
            "object" => 'required|string|max:255|min:1',
            "select_user" => 'required|string',
            "select_seal" => 'required|string',
            "select_file" => 'required|string',
            "file_other" => 'nullable|string|max:255',
            "content" => 'required|string|max:255|min:1'
        ]);

        if($request->input('select_project')!='other-grv_2' && $request->input('select_project')!='other-rv' && $request->input('select_project')!='other-grv'){
            $project = Project::find($request->input('select_project'));
            $project_id = $project->project_id;
            $project_company_name =  $project-> company_name;
        }
        else{
            $project_id = $request->input('select_project') ;
            $temp = explode('-',$request->input('select_project'));
            $project_company_name =$temp[count($temp) - 1];
        }

        if($request->input('date_type') == 'onedate'){
            $firste_date = $request->input('one_date');
            $end_date = null;
        }else if($request->input('date_type') =='manydate'){
            $firste_date =$request->input('first_date');
            $end_date = $request->input('end_date');
        }
        if($seal->company != $project_company_name){
            $numbers = Seal::all();
            $i = 0;
            $max = 0;
            foreach ($numbers->toArray() as $number) {
                if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                    if($number['company'] == $project_company_name){
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
            switch($project_company_name){
                case 'rv':
                    $finished_id = "Rv-" . (date('Y') - 1911) . date("m") . $var;
                    break;
                case 'grv_2':
                    $finished_id = "Grv-" . (date('Y') - 1911) . date("m") . $var;
                    break;
                case 'grv':
                    $finished_id = "Grv_Old-" . (date('Y') - 1911) . date("m") . $var;
                    break;
                default:
                    break;
            }
            $seal->number = $i + 1; 
            $seal->final_id = $finished_id;
        }

        $other_content =null;
        if($request->input('file_other') == ""){
            $other_content =null;
        }else{
            $other_content = $request->input('file_other');
        }

        $seal->seal_type = $request->input('select_seal');
        $seal->file_type = $request->input('select_file');
        $seal->file_other_content = $other_content;
        
        $seal->object = $request->input('object');
        $seal->project_id = $project_id;
        $seal->company = $project_company_name;
        $seal->content = $request->input('content');
        $seal->seal_user_id = $request->input('select_user');
        $seal->contract_first_date = $firste_date;
        $seal->contract_end_date = $end_date;

        $seal->status = 'waiting';

        $seal->save();
        if($seal->project_id=='other-grv_2'){
            $project_name = '綠雷德-其他';
        }else if($seal->project_id == 'other-rv' ){
            $project_name = '閱野-其他';
        }else if($seal->project_id=='other-grv'){
            $project_name = '綠雷德(舊)-其他';
        }else{
            $project_name =  $seal->project->name;
        }

        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => 'GRV00001',
            'title' => \Auth::user()->nickname . ' 已修改在 『' . $project_name . '』 的用印申請內容，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('seal.show', $seal->seal_id),
            'status' => 'not_read',
        ]);
        $email = 'zx99519567@gmail.com';
        $maildata = [
            'title' => \Auth::user()->nickname . ' 已申請在 『' . $project_name . '』 的用印申請內容，請重新審核。',
            'reason' => '',
            'content' => '重新審核',
            'link' => route('seal.show', $seal->seal_id)
        ];
        Mail::to($email)->send(new EventMail($maildata));
        return redirect()->route('seal.show', $seal_id);

    }


    public function match(Request $request,string $seal_id){
        $seal = Seal::find($seal_id);

        if($seal->status == 'waiting'){
            $seal->status = 'managed';
            $seal->managed = \Auth::user()->name;
            $seal->save();
            
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            if($seal->project_id=='other-grv_2'){
                $project_name = '綠雷德-其他';
            }else if($seal->project_id == 'other-rv' ){
                $project_name = '閱野-其他';
            }else if($seal->project_id=='other-grv'){
                $project_name = '綠雷德(舊)-其他';
            }else{
                $project_name =  $seal->project->name;
            }
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => $seal->seal_user_id,
                'title' => $seal->user->nickname . ' 在 『' . $project_name . '』的使用印章申請已經通過。',
                'reason' => '',
                'content' => '已經可以使用印章，使用完記得歸還~',
                'link' => route('seal.show', $seal_id),
                'status' => 'not_read',
            ]);
        }else if($seal->status == 'managed'){
            $seal->status = 'complete';
            $seal->complete = $seal->seal_user->name;
            $seal->complete_day = date("Y-m-d");
            $seal->save();
            $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
                return $letter->letter_id;
            })->toArray();
            if($seal->project_id=='other-grv_2'){
                $project_name = '綠雷德-其他';
            }else if($seal->project_id == 'other-rv' ){
                $project_name = '閱野-其他';
            }else if($seal->project_id=='other-grv'){
                $project_name = '綠雷德(舊)-其他';
            }else{
                $project_name =  $seal->project->name;
            }
            $newId = RandomId::getNewId($letter_ids);
            $post = Letters::create([
                'letter_id' => $newId,
                'user_id' => 'GRV00002',
                'title' => $seal->seal_user->nickname . ' 在 『' . $project_name . '』所借用的印章已經歸還。',
                'reason' => '',
                'content' => '請確認印章是否有歸還！',
                'link' => route('seal.show', $seal_id),
                'status' => 'not_read',
            ]);
        }
        return redirect()->route('seal.show', $seal_id);
        
    }

    public function withdraw(Request $request,string $seal_id){
        $seal = Seal::find($seal_id);
        $letter_ids = Letters::select('letter_id')->get()->map(function ($letter) {
            return $letter->letter_id;
        })->toArray();
        if($seal->project_id=='other-grv_2'){
            $project_name = '綠雷德-其他';
        }else if($seal->project_id == 'other-rv' ){
            $project_name = '閱野-其他';
        }else if($seal->project_id=='other-grv'){
            $project_name = '綠雷德(舊)-其他';
        }else{
            $project_name =  $seal->project->name;
        }
        $newId = RandomId::getNewId($letter_ids);
        $post = Letters::create([
            'letter_id' => $newId,
            'user_id' => $seal->user_id,
            'title' => '您在 『' . $project_name . '』 的使用印章申請失敗。',
            'reason' => $request->input('reason'),
            'content' => '前往修改',
            'link' => route('seal.show', $seal_id),
            'status' => 'not_read',
        ]);

        if ($seal->status == 'waiting') {
            $seal->status = 'waiting-fix';
            $seal->save();
        }
        return redirect()->route('seal.show', $seal_id);
    }

    public function destory(string $seal_id){
        $seal_delete = Seal::find($seal_id);
        $allSeal = Seal::orderby('created_at', 'desc')->get();
        foreach ($allSeal as $seal) {
            if($seal->company == $seal_delete->company && substr($seal->created_at, 0, 7) == substr($seal_delete->created_at, 0, 7)){
                if($seal->number > $seal_delete->number){
                    $var = sprintf("%03d", $seal->number - 1);
                    switch($seal_delete->company){
                        case 'rv':
                            $seal->final_id = "Rv-" . substr($seal->final_id, -8, -3) . $var;
                            break;
                        case 'grv_2':
                            $seal->final_id = "Grv-" . substr($seal->final_id, -8, -3) . $var;
                            break;
                        case 'grv':
                            $seal->final_id = "Grv_Old-" . substr($seal->final_id, -8, -3) . $var;
                            break;
                        default:
                            break;
                    }
                    $seal->number = $seal->number - 1;
                    $seal->save();
                }
            }
        }

        $seal_delete->delete();
        return redirect()->route('seal.index');
    }
}
