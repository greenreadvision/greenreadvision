<?php

namespace App\Http\Controllers;

use App\Project;
use App\Finance;
use App\Property;
use App\Functions\RandomId;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $finances = Finance::orderby('date')->with('project')->get();
        // // $finances = Finance::where('user_id', \Auth::user()->user_id)->orderby('project_id')->with('project')->get();
        // $group = [];
        // $content = [];
        // $projects = Project::orderby('deadline_date')->get();
        // foreach ($projects as $project){
        //     array_push($group, [$project->project_id => $content]);
        // }
        // foreach ($finances as $key => $finance){
        //     if(count($finance->toArray()) != 0) array_push($group[$finance['project_id']], ['' => $finance]);
        // }
        return view('pm.finance.indexFinance')->with('finances', $finances);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $projects = Project::select('project_id', 'name')->get()->toArray();
        return view('pm.finance.createFinance')->with('data', $projects);
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
        $finance_ids = Finance::select('finance_id')->get()->map(function($finance) { return $finance->finance_id; })->toArray();

        $post = Finance::create([
            'id' => count(Finance::all()->toArray()),
            'finance_id' => RandomId::getNewId($finance_ids),
            'project_id' => $request->input('project_id'),
            'user_id' => \Auth::user()->user_id,
            'date' => \Carbon\Carbon::now()->toDateString(),
            'name' => $request->input('name'),
            'price' => 0
        ]);
        return redirect()->route('finance.index');

        // return view('pm.finance.createReview')->with('data', [      //use for test.
        //     'finance' => $id,
        //     'project_id' => 'xxxxxxxxxxx',
        //     'user_id' => 'IAmTestUser',
        //     'date' => Carbon::now()->toDateString(),
        //     'name' => $request->input('name'),
        //     'price' => 0
        //     //'test' => $project_id      //use for test data what you want to dump.
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function show(String $finance_id)
    {
        //
        $finance = Finance::where('finance_id', $finance_id)->with('property')->get()->toArray()[0];
        $properties = $finance['property'];
        if (count($properties) == 0) $properties = null;
        return view('pm.finance.property')->with('data', ['finance' => $finance, 'properties' => $properties]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function edit(String $finance_id)
    {
        //
        $finance = Finance::where('finance_id', $finance_id)->get()->toArray()[0];
        $projects = Project::select('project_id', 'name')->get()->toArray();
        foreach($projects as $key => $project){
            if ($project['project_id'] == $finance['project_id']) $projects[$key]['selected'] = "selected";
            else $projects[$key]['selected'] = "";
        }
        return view('pm.finance.editFinance')->with('data', ['finance' => $finance, 'projects' => $projects]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Finance $finance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $finance_id)
    {
        //Delete the finance
        $finance = Finance::where('finance_id', $finance_id);
        foreach ($finance as $contents) { $contents->delete(); }
        $finance->delete();

        return redirect()->route('finance.index');
    }
}
