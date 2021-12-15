<?php

namespace App\Http\Controllers;

use App\Functions\RandomId;
use App\Project;
use App\ProjectSOP;
use App\ProjectSOP_item;
use App\User;
use Illuminate\Http\Request;

class ProjectSOPController extends Controller
{
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

        $projectSOPs = ProjectSOP::where('SOPtype','=','project')->orderby('created_at', 'desc')->with('project')->with('user')->get();
        $otherProjectSOPs = ProjectSOP::where('SOPtype','=','other')->orderby('created_at', 'desc')->with('user')->get();
        $project = Project::orderby('created_at', 'desc')->get();
        return view('pm.projectSOP.index',['users'=>$users,'projectSOPs'=>$projectSOPs,'project'=>$project,'otherProjectSOPs'=>$otherProjectSOPs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::orderby('created_at', 'desc')->get();
        $otherProjectSOPs = ProjectSOP::where('SOPtype','=','other')->orderby('created_at', 'desc')->with('user')->get();
        
        return view('pm.projectSOP.create',['projects'=>$projects, 'otherProjectSOPs'=>$otherProjectSOPs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $projectSOP_ids = ProjectSOP::select('projectSOP_id')->get()->map(function ($projectSOP) {
            return $projectSOP->projectSOP_id;
        })->toArray();
        $id = RandomId::getNewId($projectSOP_ids);
        if($request->input('SOPtype')=='project'){
            for($i = 1 ; $i <= $request->input('FileListSave') ; $i++){
                $request->validate([
                    'fileClone_' . $i . '[]' => 'nullable|file',
                ]);
            }
            $request->validate([
                'select-company' => 'required|string|min:1|max:255',
                'select-project' => 'required|string|exists:projects,project_id|size:11',
                'content' => 'required|string|min:1|max:500'
            ]);
            $file_path = null;
            $file_num = 0;
            for($i = 1 ; $i <= $request->input('FileListSave') ; $i++){
                if ($request->hasFile('fileClone_' . $i)) {
                    $files = $request->file('fileClone_' . $i);
                    $porject = Project::find($request->input('select-project'));
                    $each = 0;
                    foreach ($files as $file) {
                        
                        $file->storeAs('public/projectSOP/'.$porject->name,$file->getClientOriginalName());
                        $file_path = 'projectSOP/'.$request->input('select-project').'/'.$file->getClientOriginalName();
                        ProjectSOP_item::create([
                            'projectSOP_id' => $id,
                            'name' => $file->getClientOriginalName(),
                            'file_address' =>$file_path,
                            'content' => $request->input('file-content-'. $i .'-'.$each),
                            'no' => $file_num + 1
                        ]);
                        $each++;
                        $file_num = $file_num+1;
                    }
                }
            }

            $post = ProjectSOP::create([
                'projectSOP_id' => $id,
                'user_id' => \Auth::user()->user_id,
                'SOPtype' => $request->input('SOPtype'),
                'company_name' => $request->input('select-company'),
                'project_id' => $request->input('select-project'),
                'content' => $request->input('content'),
                'item_num' => $file_num +1
            ]);
        }
        else if($request->input('SOPtype') == 'other'){
            for($i = 1 ; $i <= $request->input('FileListSave') ; $i++){
                $request->validate([
                    'fileClone_' . $i . '[]' => 'nullable|file',
                ]);
            }
            $request->validate([
                'select-other-company' => 'required|string|min:1|max:255',
                'select-other-type' => 'required|string|min:1|max:255',
                'otherContent' => 'required|string|min:1|max:500'
            ]);
            $other_file_path = null;
            $file_num = 0;
            for($i = 1 ; $i <= $request->input('FileListSave') ; $i++){
                if ($request->hasFile('fileClone_'. $i)) {
                    $other_files = $request->file('fileClone_'. $i);
                    $each = 0;
                    foreach ($other_files as $file) {
                        $file->storeAs('public/otherSOP/'.$request->input('select-other-type'),$file->getClientOriginalName());
                        $other_file_path = 'otherSOP/'.$request->input('select-other-type').'/'.$file->getClientOriginalName();
                        ProjectSOP_item::create([
                            'projectSOP_id' => $id,
                            'name' => $file->getClientOriginalName(),
                            'file_address' =>$other_file_path,
                            'content' => $request->input('file-content-'. $i .'-'.$each),
                            'no' => $file_num + 1
                        ]);
                        $each++;
                        $file_num = $file_num+1;
                    }
                }
            }
            $post = ProjectSOP::create([
                'projectSOP_id' => $id,
                'user_id' => \Auth::user()->user_id,
                'SOPtype' => $request->input('SOPtype'),
                'company_name' => $request->input('select-other-company'),
                'type' => $request->input('select-other-type'),
                'content' => $request->input('otherContent'),
                'item_num' => $file_num
            ]);
        }
        return redirect()->route('projectSOP.show', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(String $ProjectSOP_id)
    {
        $projectSOP = ProjectSOP::with('user')->with('project')->with('Sopitem')->get()->find($ProjectSOP_id);
        $projectSOP_items = ProjectSOP_item::where('ProjectSOP_id','=',$ProjectSOP_id)->get();
        foreach($projectSOP_items as $item){
            $item->file_address = explode('/',  $item->file_address);
        }
        return view('pm.projectSOP.show')->with(['projectSOP'=>$projectSOP,'projectSOP_items'=>$projectSOP_items]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(String $ProjectSOP_id)
    {
        $projectSOP = ProjectSOP::with('user')->with('project')->with('Sopitem')->get()->find($ProjectSOP_id);
        $projectSOP_items = ProjectSOP_item::where('ProjectSOP_id','=',$ProjectSOP_id)->get();
        $projects = Project::orderby('created_at', 'desc')->get();
        $otherProjectSOPs = ProjectSOP::where('SOPtype','=','other')->select('type')->distinct()->get();
        return view('pm.projectSOP.edit')->with(['projectSOP'=>$projectSOP,'projectSOP_items'=>$projectSOP_items,'projects'=>$projects, 'otherProjectSOPs'=>$otherProjectSOPs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $ProjectSOP_id)
    {
        $projectSOP = ProjectSOP::with('user')->with('project')->with('Sopitem')->get()->find($ProjectSOP_id);
        $projectSOP_items = ProjectSOP_item::where('ProjectSOP_id','=',$ProjectSOP_id)->get();
        $fileNum = 0;

        if( $request->input('SOPtype') == 'project'){
            $select = $request->input('select-company');
            $project = $request->input('select-project');
            $type = null;
            $content = $request->input('content');
        }
        else if($request->input('SOPtype') == 'other'){
            $select = $request->input('select-other-company');
            $type = $request->input('select-other-type');
            $project = null;
            $content = $request->input('otherContent');
        }
        $projectSOP->SOPtype = $request->input('SOPtype');
        $projectSOP->company_name = $select;
        $projectSOP->type = $type;
        $projectSOP->content = $content;
        $projectSOP->project_id = $project;
        $projectSOP->item_num = $request->input('fileNum');

        $projectSOP->save();

        foreach($projectSOP_items as $item){
            if($request->input('File_no_'.$fileNum) != 'delete'){
                $item->no = $request->input('File_no_'.$fileNum);
                $item->name = $request->input('inputFile_'.$fileNum);
                if ($request->hasFile('file_'.$fileNum)) {
                    $file = $request->file('file_'.$fileNum);
                    if($request->input('SOPtype') == 'project'){
                        $porject = Project::find($request->input('select-project'));
                        $file->storeAs('public/projectSOP/'.$porject->name,$file->getClientOriginalName());
                        $file_path = 'projectSOP/'.$request->input('select-project').'/'.$file->getClientOriginalName();
                        \Illuminate\Support\Facades\Storage::delete( $item->file_address);
                        $item->file_address =$file_path;
                    }
                    else if($request->input('SOPtype') == 'other'){
                        $file->storeAs('public/otherSOP/'.$request->input('select-other-type'),$file->getClientOriginalName());
                        $other_file_path = 'otherSOP/'.$request->input('select-other-type').'/'.$file->getClientOriginalName();
                        \Illuminate\Support\Facades\Storage::delete( $item->file_address);
                        $item->file_address =$other_file_path;
                    }
                }
                $item->content = $request->input('SOPtiem_content_'.$fileNum);
                $item->save();
            }
            else if($request->input('File_no_'.$fileNum) == 'delete'){
                \Illuminate\Support\Facades\Storage::delete( $item->file_address);
                $item->delete();
            }
            $fileNum++;
        }
        for($i = $fileNum;$i<$request->input('fileNum') ; $i++){
            if($request->hasFile('file_'.$i)){
                $file = $request->file('file_'.$i);
                if($request->input('SOPtype') == 'project'){
                    $porject = Project::find($request->input('select-project'));
                    $file->storeAs('public/projectSOP/'.$porject->name,$file->getClientOriginalName());
                    $file_path = 'projectSOP/'.$request->input('select-project').'/'.$file->getClientOriginalName();
                    ProjectSOP_item::create([
                        'projectSOP_id' => $ProjectSOP_id,
                        'name' => $request->input('inputFile_'.$i),
                        'file_address' =>$file_path,
                        'content' => $request->input('SOPtiem_content_'.$i),
                        'no' => $request->input('File_no_'.$i)
                    ]);
                }
                else if($request->input('SOPtype') == 'other'){
                    $file->storeAs('public/otherSOP/'.$request->input('select-other-type'),$file->getClientOriginalName());
                    $other_file_path = 'otherSOP/'.$request->input('select-other-type').'/'.$file->getClientOriginalName();
    
                    ProjectSOP_item::create([
                        'projectSOP_id' => $ProjectSOP_id,
                        'name' => $request->input('inputFile_'.$i),
                        'file_address' =>$other_file_path,
                        'content' => $request->input('SOPtiem_content_'.$i),
                        'no' => $request->input('File_no_'.$i)
                    ]);
                }
            }
        }
        return redirect()->route('projectSOP.show', $ProjectSOP_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $ProjectSOP_id)
    {
        $projectSOP = ProjectSOP::with('user')->with('project')->with('Sopitem')->get()->find($ProjectSOP_id);
        $projectSOP_items = ProjectSOP_item::where('ProjectSOP_id','=',$ProjectSOP_id)->get();

        foreach($projectSOP_items as $item){
            \Illuminate\Support\Facades\Storage::delete( $item->file_address);
            $item->delete();
        }
        $projectSOP->delete();
        return redirect()->route('projectSOP.index');
    }
}
