<?php

namespace App\Http\Controllers;

use App\Functions\RandomId;
use App\Group;
use App\GroupActive;
use App\Project;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(){
        $types = Group::select('type')->distinct()->get();
        $group_address = Group::orderby('address')->get();
        $group = Group::orderby('type', 'desc')->orderby('address')->get();
        return view('pm.group.index',['types'=>$types,'group'=>$group,'group_address'=>$group_address]);
    }

    public function create(){
        $projects = Project::select('name')->orderby('created_at', 'desc')->get();
        $types = Group::select('type')->distinct()->get();
        $group = Group::orderby('created_at', 'desc')->get();
        return view('pm.group.createGroup',['types'=>$types, 'group'=>$group , 'projects'=>$projects]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|min:1|max:255',//類別選單
            'new_type'=>'nullable|string|max:255',
            'new_item_type'=>'nullable|string|max:255',
            'item_type' => 'nullable|string|min:1|max:255',//細項選單
            'item_type_new'=>'nullable|string|max:255',
            'name'=> 'required|string|min:1|max:255',
            'phone'=> 'nullable|string|max:15',
            'telephone'=> 'nullable|string|size:10',
            'fax'=> 'nullable|string|max:15',
            'webAddress' => 'nullable|string|max:255',
            'address'=> 'required|string|min:1|max:10',
            'content' => 'nullable|string|max:500',
            'simple_content' => 'required|string|min:1|max:50'
        ]);
        $group_ids = Group::select('group_id')->get()->map(function ($group) {
            return $group->group_id;
        })->toArray();
        $newId = RandomId::getNewId($group_ids);
        $type = $request->input('type');
        $item_type = $request->input('item_type');
        if($type =='other'){
            $type = $request->input('new_type');
            $item_type = $request->input('new_item_type');
        }
        if($item_type == 'other'){
            $item_type = $request->input('item_type_new');
        }

        $j = 0;
        for($j = 0 ; $j < 50 ; $j++){
            if($request->input('projectName-'.$j) != null){
                $request->validate([
                    'projectName-' . $j => 'required|string|min:1|max:100',
                    'activeName-' . $j => 'required|string|min:1|max:100'
                ]);
                GroupActive::create([
                    'group_id' => $newId,
                    'projectName' => $request->input('projectName-' . $j),
                    'activeName' => $request->input('activeName-' . $j)
                ]);
            }else{
                break;
            }
        }


        $post = Group::create([
            'group_id' => $newId,
            'type' => $type,
            'item_type' =>  $item_type,
            'name'=> $request->input('name'),
            'phone'=> $request->input('phone'),
            'telephone'=> $request->input('telephone'),
            'fax'=> $request->input('fax'),
            'address'=> $request->input('address'),
            'webAddress'=>$request->input('webAddress'),
            'simpleContent'=>$request->input('simple_content'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('group.index');
    }

    public function show(String $group_id){

        $group = Group::find($group_id);
        $group_active = GroupActive::where('group_id', $group_id)->orderby('projectName','desc')->get();
        $group_active_projectName = GroupActive::where('group_id', $group_id)->select('projectName')->distinct()->get();
        $i = 0;
        foreach ($group_active as $data) {
            $i++;
        }
        return view('pm.group.show', ['group' => $group, 'group_active' => $group_active, 'i' => $i, 'group_active_projectName'=>$group_active_projectName]);
    }

    public function edit(String $group_id){
        $projects = Project::select('name')->orderby('created_at', 'desc')->get();
        $types = Group::select('type')->distinct()->get();
        $groups = Group::orderby('created_at', 'desc')->get();
        $group = Group::find($group_id);
        $group_active = GroupActive::where('group_id', $group_id)->orderby('projectName','desc')->get();
        return view('pm.group.edit',['group'=>$group,'group_active'=>$group_active,'projects'=>$projects,'types'=>$types,'groups'=>$groups]);
    }

    public function update(Request $request, String $group_id){
        $request->validate([
            'type' => 'required|string|min:1|max:255',//類別選單
            'new_type'=>'nullable|string|max:255',
            'new_item_type'=>'nullable|string|max:255',
            'item_type' => 'nullable|string|min:1|max:255',//細項選單
            'item_type_new'=>'nullable|string|max:255',
            'name'=> 'required|string|min:1|max:255',
            'phone'=> 'nullable|string|max:15',
            'telephone'=> 'nullable|string|size:10',
            'fax'=> 'nullable|string|max:15',
            'webAddress' => 'nullable|string|max:255',
            'address'=> 'required|string|min:1|max:10',
            'content' => 'nullable|string|max:500',
            'simple_content'=>'required|string|min:1|max:50'
        ]);

        $group = Group::Where('group_id',$group_id)->update($request->except('_method', '_token'));

        $j = 0;
        for($j = 0 ; $j < 50 ; $j++){
            if($request->input('projectName-'.$j) != null){
                $request->validate([
                    'projectName-' . $j => 'required|string|min:1|max:100',
                    'activeName-' . $j => 'required|string|min:1|max:100'
                ]);
                $group = GroupActive::Where('group_id',$group_id)->update($request->except('_method', '_token'));
                
            }else{
                break;
            }
        }

        return redirect()->route('group.show',['group_id'=>$group_id]);
    }
}
