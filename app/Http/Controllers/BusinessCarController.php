<?php

namespace App\Http\Controllers;

use App\Project;
use App\Functions\RandomId;
use App\Http\Controllers\EventController;
use App\BusinessCar;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class BusinessCarController extends Controller
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
        //
        $businessCar=BusinessCar::all()->sortBy('created_at');
        return view('pm.businessCar.indexBusinessCar')->with('data', $businessCar);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $projects = Project::select('project_id', 'name','finished')->get()->toArray();
        return view('pm.businessCar.createBusinessCar')->with('data', $projects);
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
            'project_id' => 'required|string|exists:projects,project_id|size:11',
            'driver' =>  'required|string|min:1|max:255',
            'phone_number' => 'required|string|size:10',
            'begin_date' => 'required|date',
            'begin_time' => 'date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'date_format:H:i',
            'begin_location' => 'required|string|min:1|max:255',
            'end_location' => 'required|string|min:1|max:255',
            'content' => 'required|string|min:1|max:255'
        ]);

        $business_car_ids = BusinessCar::select('business_car_id')->get()->map(function ($businessCar) {
            return $businessCar->business_car_id;
        })->toArray();
        $id = RandomId::getNewId($business_car_ids);
        $post = BusinessCar::create([
            'user_id' => \Auth::user()->user_id,
            'business_car_id' => $id,
            'project_id' => $request->input('project_id'),
            'content' => $request->input('content'),
            'driver' => $request->input('driver'),
            'phone_number' => $request->input('phone_number'),
            'begin_location' => $request->input('begin_location'),
            'end_location' => $request->input('end_location'),
            'begin_date' => $request->input('begin_date'),
            'end_date' => $request->input('end_date'),
            'begin_time' => $request->input('begin_time'),
            'end_time' => $request->input('end_time')
        ]);
        return redirect()->route('businessCar.index');
    }

    public function show(String $business_car_id)
    {
        //
        $business_car = BusinessCar::find($business_car_id);
        return view('pm.businessCar.showBusinessCar')->with('data', $business_car);
    }

    public function edit(String $business_car_id)
    {
        $business_car = BusinessCar::find($business_car_id);
        // $invoice->content = InvoiceController::replaceEnter(false, $invoice->content);
        $projects = Project::select('project_id', 'name','finished')->get()->toArray();
        foreach($projects as $key => $project){
            $projects[$key]['selected'] = ($project['project_id'] == $business_car->project_id)? "selected": " ";
        }
        return view('pm.businessCar.editBusinessCar')->with('data', ['business_car' => $business_car->toArray(), 'projects' => $projects]);
    }

    public function update(Request $request, String $business_car_id)
    {
        $business_car = BusinessCar::find($business_car_id);
        //
        $request->validate([
            'driver' =>  'required|string|min:1|max:255',
            'phone_number' => 'required|string|size:10',
            'begin_date' => 'required|date',
            'end_date' => 'required|date',
            'begin_location' => 'required|string|min:1|max:255',
            'end_location' => 'required|string|min:1|max:255',
            'content' => 'required|string|min:1|max:255',
            'begin_mileage'=>'nullable|integer',
            'end_mileage'=>'nullable|integer',
            'oil'=>'nullable|integer',
            'payer'=>'nullable|string|min:1|max:255',

        ]);

        $business_car->update($request->except('_method', '_token'));

        return redirect()->route('businessCar.review', $business_car_id);
    }
    public function destroy(String $business_car_id)
    {
        //Delete the invoice
        $business_car = BusinessCar::find($business_car_id);
    
        $business_car->delete();

        return redirect()->route('businessCar.index');
    }

}
