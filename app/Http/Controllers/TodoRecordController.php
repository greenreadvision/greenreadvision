<?php

namespace App\Http\Controllers;

use App\User;
use App\TodoRecord;
use App\Functions\RandomId;
use Illuminate\Http\Request;

class TodoRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::orderby('nickname')->with('todoRecords')->get();
        return view('pm.todoRecord.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createToday(Request $request)
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s');
        foreach(explode("\n",$request->input('event')) as $event){
            if($event != ''){
                $post=TodoRecord::create([
                    'user_id' => \Auth::user()->user_id,
                    'title' => $request->input('title'),
                    'event' => $event,
                    'status' => True,
                    'finish' => $date
                ]);
            }
            
        }
        return redirect()->route('todoRecord.index');
    }

    public function createNextday(Request $request)
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s', strtotime("+1 day"));
        foreach(explode("\n",$request->input('event')) as $event){
            if($event != ''){
                $post=TodoRecord::create([
                    'user_id' => \Auth::user()->user_id,
                    'title' => $request->input('title'),
                    'event' => $event,
                    'status' => false,
                    'finish' => $date
                ]);
            }
            
        }
        return redirect()->route('todoRecord.index');

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
        $request->validate([
            'project_id' => 'required|exists:projects,project_id|size:11',
            'name' => 'required|min:2|max:255',
            'content' => 'required|max:255',
            'deadline' => 'required|date'
        ]);

        $todo_ids = Todo::select('todo_id')->get()->map(function($todo) { return $todo->todo_id; })->toArray();
        $newId = RandomId::getNewId($todo_ids);

        $post = Todo::create([
            'todo_id' => $newId,
            'project_id' => $request->input('project_id'),
            'user_id' => \Auth::user()->user_id,
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'deadline' => $request->input('deadline'),
            'finished' => false
        ]);

        EventController::create($request->input('deadline'), $request->input('name'), $request->input('content'), __('customize.Todo'), 'todo', $newId);

        return redirect()->route('todo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(String $todo_id)
    {
        //
        // $todos = \App\Todo::where('todo_id', $todo_id)->get()->toArray()[0];
        $todos = Todo::find($todo_id);
        return view('pm.todo.showTodo')->with('data', $todos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(String $todo_id)
    {
        //
        $todo = \App\Todo::find($todo_id);
        $projects = Project::select('project_id', 'name')->get()->toArray();
        foreach($projects as $key => $project){
            $projects[$key]['selected'] = ($project['project_id'] == $todo->project_id)? "selected": " ";
        }
        return view('pm.todo.editTodo')->with('data', ['todo' => $todo->toArray(), 'projects' => $projects]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $todo_id)
    {
        //
        $request->validate([
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'name' => 'required|min:2|max:255',
            // 'name' => ['required', 'string', 'min:2', 'max:255', \Illuminate\Validation\Rule::unique('todos')->ignore($todo_id, 'todo_id')],
            'content' => 'required|string|min:2|max:255',
            'deadline' => 'required|date'
        ]);

        $todo = Todo::where('todo_id', $todo_id);
        $todo->update($request->except('_method', '_token'));

        $event = TodoEvent::where('todo_id', $todo_id)->get()[0];
        EventController::update($event->event_id, $request->input('deadline'), $request->input('name'), $request->input('content'));

        return redirect()->route('todo.review', $todo_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $todo_id)
    {
        //
        $todo = Todo::find($todo_id);
        $todo->todoEvent->event->delete();
        $todo->delete();

        return redirect()->route('todo.index');
    }
}
