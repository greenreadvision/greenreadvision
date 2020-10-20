<?php

namespace App\Http\Controllers;

use App\Home;
use App\Company;
use App\Functions\RandomId;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::orderby('number')->get();
        return view('pm.company.indexCompany')->with('data', $company);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pm.company.createCompany');
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
            'number' => 'required|string|min:2|max:10',
            'name' => 'required|string|min:2|max:20',
            'address'=>'required|string|min:2|max:50',
            'email'=>'required|string|min:2|max:20',
            'phone'=>'required|string|size:10'
        ]);

        $company_ids = Company::select('company_id')->get()->map(function($company) { return $company->company_id; })->toArray();
        $newId = RandomId::getNewId($company_ids);

        $post = Company::create([
            'company_id' => $newId,
            'number' => $request->input('number'),
            'name' => $request->input('name'),
            'address'=>$request->input('address'),
            'email'=>$request->input('email'),
            'phone'=>$request->input(('phone'))
        ]);

        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Home  $project
     * @return \Illuminate\Http\Response
     */
    public function show(String $home_id)
    {
        //
        $home = Home::find($home_id);
        return view('pm.home.showHome')->with('data', $home);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Home  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(String $company_id)
    {
        //
        $company = Company::find($company_id);
        return view('pm.company.editCompany')->with('data', $company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $company_id)
    {
        //
        
        $request->validate([
            'number' => 'required|string|min:2|max:10',
            'name' => 'required|string|min:2|max:20',
            'address'=>'required|string|min:2|max:50',
            'email'=>'required|string|min:2|max:20',
            'phone'=>'required|string|size:10'
        ]);

        $company = Company::where('company_id', $company_id)->update($request->except('_method', '_token'));

        return redirect()->route('company.index');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Home  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $company_id)
    {
        //Delete the project and any following datas.
        $company = Company::find($company_id);
        $company->delete();

        return redirect()->route('company.index');
    }
}
