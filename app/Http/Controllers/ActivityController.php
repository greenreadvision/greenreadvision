<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivityType;
use App\Functions\RandomId;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(){
        $users = [];
        $allUsers = User::orderby('user_id')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && count($allUser->invoices) != 0) {
                array_push($users, $allUser);
            }
        }
        $activity_type = ActivityType::orderby('created_at', 'desc')->get();
        
        $activies = Activity::select('name','type','begin_time','end_time','user_id','project_id','activity_id')->orderby('begin_time', 'desc')->with('user')->with('project')->with('project_user')->get();
        return view("grv.CMS.activity.index",['users'=>$users,'actitvies'=>$activies,'types'=>$activity_type]);
    }

    public function create(){
        $activity_type = ActivityType::orderby('created_at', 'desc')->get();
        $projects = Project::select('project_id', 'name')->orderby('created_at', 'desc')->get()->toArray();
        $rv = Project::where('company_name', '=', 'rv')->orderby('created_at', 'desc')->get();
        $grv = Project::where('company_name', '=', 'grv')->orderby('created_at', 'desc')->get();
        $grv2 = Project::where('company_name', '=', 'grv_2')->orderby('created_at', 'desc')->get();
        return view("grv.CMS.activity.create",['types'=>$activity_type,'rv' => $rv,'grv' => $grv,'grv2'=>$grv2, 'projects' => $projects]);
    }

    public function store(Request $request){
        $request->validate([
            'organizer' => 'required|string|max:255',
            'name' => 'required|string|max:191',
            'type' => 'required|string|max:191',
            'ckeditor' => 'required|string|min:1',
            'project_id'  => 'required|exists:projects,project_id|string|max:11',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date',
            'img_path' => 'required|file'
        ]);
        if($request->hasFile('img_path')){
            if ($request->img_path->isValid()){
                $file_path = $request->img_path->storeAs('public/activity',$request->img_path->getClientOriginalName());
                $file_path = $request->img_path->storeAs('/activity',$request->img_path->getClientOriginalName());
            }
        }

        $activity_ids = Activity::select('activity_id')->get()->map(function ($activity) {
            return $activity->activity_id;
        })->toArray();
        $id = RandomId::getNewId($activity_ids);
        $project_user = Project::find($request->input('project_id'));

        $post = Activity::create([
            'activity_id' => $id,
            'user_id' => \Auth::user()->user_id,
            'organizers' => $request->input('organizer'),
            'name' => $request->input('name'),
            'type' =>  $request->input('type'),
            'content' => $request->input('ckeditor'),
            'project_id'  =>  $request->input('project_id'),
            'project_user_id' => $project_user->user_id,
            'begin_time' => $request->input('begin_date') ,
            'end_time' =>  $request->input('end_date'),
            'img_path' => $file_path
        ]);

        return redirect()->route('activity.show', $id);
    }

    public function show(String $activity_id){

        $activity =  Activity::find($activity_id);
        $activity->img_path = explode('/', $activity->img_path);
        $activity_type = ActivityType::orderby('created_at', 'desc')->get();
        $projects = Project::orderby('created_at', 'desc')->get();
        return view("grv.CMS.activity.show",['activity' => $activity , 'projects' => $projects ,'activity_type' => $activity_type]);
    }

    public function update(Request $request, String $id,string $type){
        $activity =  Activity::find($id);

        switch($type){
            case 'project':
                $activity->project_id = $request->input('projectName');
                $activity->save();
                break;
            case 'name':
                $request->validate([
                    'organizer' => 'required|string|min:1|max:255',
                    'name' =>'required|string|min:1|max:255'
                ]);
                $activity->organizers = $request->input('organizer');
                $activity->name = $request->input('name');
                $activity->save();
                break;
            case 'type':
                $activity->update($request->except('_method', '_token'));
                break;
            case 'date':
                if($request->input('choose_date_type') == 'one'){
                    $activity->begin_time = $request->input('begin_date');
                    $activity->end_time = null;
                }else if($request->input('choose_date_type') == 'many'){
                    $activity->begin_time = $request->input('begin_date');
                    $activity->end_time = $request->input('end_date');
                }
                $activity->save();
                break;    
            case 'image':
                if($request->hasFile('img_path')){
                    if ($request->img_path->isValid()){
                        $file_path = $request->img_path->storeAs('public/activity',$request->img_path->getClientOriginalName());
                        $file_path = $request->img_path->storeAs('/activity',$request->img_path->getClientOriginalName());
                    }
                }
                $activity->img_path = $file_path;
                $activity->save();
                break;
            case 'content':
                $request->validate([
                    'ckeditor' => 'required|string|max:5000'
                ]);
                $activity->content = $request->input('ckeditor');
                $activity->save();
                break;
            default:
                break;
        }
        return redirect()->route('activity.show', $id);
    }

    public function detail_show(String $activity_id){
        $activity =  Activity::find($activity_id);
        
        return view("grv.CMS.activity.detail_show",['activity' => $activity]);
    }



    //以下為對外顯示
    public function showList(String $activity_type){
        $activities = Activity::where('type','=',$activity_type)->get();
        $activity_types = ActivityType::orderby('created_at', 'desc')->get();
        /*foreach($activities as $item){
            $item->img_path = explode('/', $item->img_path);
        }*/
        return view("grv.Activity_outside.showList",['activities' => $activities,'activity_types'=>$activity_types,'activity_type' => $activity_type]);

    }

    public function showContent(String  $activity_type ,String $actiity_id){
        $activity = Activity::find($actiity_id);
        $activity_types = ActivityType::orderby('created_at', 'desc')->get();
        return view("grv.Activity_outside.showContent",['activity' => $activity,'activity_types'=>$activity_types,'activity_type' => $activity_type]);
    }
}
