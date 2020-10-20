<?php

namespace App\Http\Controllers;

use App\Event;
use App\Project;
use App\ProjectEvent;
use App\User;

use App\Functions\RandomId;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = Project::with('user')->with('invoices')->with('todos')->orderby('created_at', 'desc')->get();

        $project = Project::orderby('open_date', 'desc')->get();
        $temp = "";
        $years = [];

        foreach ($project as $data) {
            $state = 0;

            $temp = substr($data->open_date, 0, 4);
            foreach ($years as $year) {
                if (substr($data->open_date, 0, 4) == $year) {
                    $state = 1;
                }
            }
            if ($state == 0) {
                array_push($years, substr($data->open_date, 0, 4));
            }
        }

        return view('pm.project.indexProject', ['data' => $projects, 'years' => $years]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pm.project.createProject');
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
            // 'beginning_date' => 'required|date',
            'company_name' => 'required|string|min:1|max:255',
            'deadline_date' => 'required|date',
            'deadline_time' => 'date_format:H:i',
            'open_date' => 'required|date',
            'open_time' => 'date_format:H:i',
            'closing_date' => 'required|date',
            'bid_bound' => 'required|integer',
            'color' => 'required|string|size:7'
        ]);

        $project_ids = Project::select('project_id')->get()->map(function ($project) {
            return $project->project_id;
        })->toArray();
        $newId = RandomId::getNewId($project_ids);

        $post = Project::create([
            'project_id' => $newId,
            'user_id' => \Auth::user()->user_id,
            'name' => $request->input('name'),
            'company_name' => $request->input('company_name'),
            // 'beginning_date' => $request->input('beginning_date'),
            'deadline_date' => $request->input('deadline_date'),
            'deadline_time' => $request->input('deadline_time'),
            'open_date' => $request->input('open_date'),
            'open_time' => $request->input('open_time'),
            'closing_date' => $request->input('closing_date'),
            'bid_bound' => $request->input('bid_bound'),
            'color' => $request->input('color'),
            'finished' => false
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
        return view('pm.project.showProject')->with('data', $project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(String $project_id)
    {
        //
        $users = User::all();
        $company_name = ['grv', 'rv'];
        $project = Project::find($project_id);
        return view('pm.project.editProject')->with('data', ['project' =>  $project, 'company_name' => $company_name,'users' => $users]);
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

        $project_ = Project::find($project_id);

        if ($request->input('beginning_date') != null && $project_->beginning_date == NULL) {
            EventController::create($request->input('beginning_date'), __('customize.beginning_date'), __('customize.beginning_date'), __('customize.Project'), 'project',  $project_id);
        }
        $request->validate([
            'name' => ['required', 'string', 'min:1', 'max:255', Rule::unique('projects')->ignore($project_id, 'project_id')],
            'beginning_date' => 'nullable|date',
            'deadline_date' => 'required|date',
            'closing_date' => 'required|date',
            'company_name' => 'required|string|min:1|max:255',
            // 'deadline_time' => 'date_format:H:i:s',
            // 'open_time' => 'date_format:H:i:s',
            'open_date' => 'required|date',
            'bid_bound' => 'required|string|max:255',
            'case_num' => 'nullable|string|max:255',
            'default_fine' => 'nullable|string|max:255',
            'total_amount' => 'nullable|string|max:255',
            'estimated_cost' => 'nullable|integer',
            'estimated_profit' => 'nullable|integer',
            'actual_cost' => 'nullable|integer',
            'actual_profit' => 'nullable|integer',
            'effective_interest_rate' => 'nullable|string|max:255',
            'color' => 'required|string|size:7',
            'finished' => 'nullable|boolean'

        ]);

        $project = Project::where('project_id', $project_id)->update($request->except('_method', '_token'));

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

    public function transfer(Request $request,String $project_id){
        $project = Project::find($project_id);
        $project->receiver = $request->input('user');
        $project->save();
        return redirect()->route('project.review', $project_id);
    }

    public function receive(Request $request,String $project_id){
        $project = Project::find($project_id);
        $project->user_id = \Auth::user()->user_id;
        $project->receiver = "";
        $project->save();
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
}
