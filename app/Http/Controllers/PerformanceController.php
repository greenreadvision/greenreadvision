<?php

namespace App\Http\Controllers;

use App\Functions\RandomId;
use App\Invoice;
use App\Performance;
use App\Project;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function store(Request $request, String $project_id){
        $project = Project::find($project_id);
        $file_path = null;
        $invoice_id = null;
        $deposit_file = null;
        $request->validate([
            'deposit' => 'required|string|min:1|max:20',
            'invoice_id' => 'nullable|string|max:13',
            'deposit_date' => 'date|nullable',
            'PayBack_date' => 'date|nullable',
            'PayBack_file' => 'file|nullable'
        ]);

        $performance_ids = Performance::select('performance_id')->get()->map(function ($performance) {
            return $performance->performance_id;
        })->toArray();
        $newId = RandomId::getNewId($performance_ids);

        if($request->input('invoice_finished_id') != null){
            $invoice = Invoice::where('finished_id','=',$request->input('invoice_finished_id'))->first();
            $deposit_file = $invoice->receipt_file;
            $invoice_id = $invoice->invoice_id;
        }
        if($request->hasFile('payBack_file')){
            if($request->payBack_file->isValid()){
                $file = $request->file('payBack_file');
                $file->storeAs('public/projectPerformance/'.$project->name,$file->getClientOriginalName());
                $file_path = 'projectPerformance/'.$project->name.'/'.$file->getClientOriginalName();
            }
        }

        $post = Performance::create([
            'performance_id' => $newId,
            'project_id' => $project_id,
            'deposit' => $request->input('deposit'),
            'invoice_id' => $invoice_id,
            'invoice_finished_id' => $request->input('invoice_finished_id'),
            'deposit_file' => $deposit_file,
            'deposit_date' => $request->input('deposit_date'),
            'PayBack_file'=> $file_path,
            'PayBack_date' => $request->input('PayBack_date')
        ]);

        $project->performance_id = $newId;
        $project->save();

        return redirect()->route('project.edit', $project_id);


    }

    public function update(Request $request, String $project_id,String $performance_id){
        $performance = Performance::find($performance_id);
        $project = Project::find($project_id);
        $file_path = null;
        $invoice_id =null;
        $deposit_file =null;
        $request->validate([
            'deposit_update' => 'required|string|min:1|max:20',
            'invoice_finished_id_update' => 'nullable|string|max:13',
            'deposit_date_update' => 'date|nullable',
            'payBack_file_update' => 'nullable|file',
            'PayBack_date_update' => 'date|nullable',
            
        ]);
        if($request->input('invoice_id_update') != null){
            $invoice = Invoice::where('finished_id','=',$request->input('invoice_finished_id_update'))->first();
            $deposit_file = $invoice->receipt_file;
            $invoice_id = $invoice->invoice_id;
        }
        if($request->hasFile('payBack_file_update')){
            if($request->payBack_file_update->isValid()){
                \Illuminate\Support\Facades\Storage::delete([$performance->PayBack_file]);
                $file = $request->file('payBack_file_update');
                $file->storeAs('public/projectPerformance/'.$project->name,$file->getClientOriginalName());
                $file_path = 'projectPerformance/'.$project->name.'/'.$file->getClientOriginalName();
                $performance->PayBack_file = $file_path;
            }
        }
        $performance->deposit = $request->input('deposit_update');
        $performance->invoice_id = $invoice_id;
        $performance->invoice_finished_id = $request->input('invoice_finished_id_update');
        $performance->deposit_file = $deposit_file;
        $performance->deposit_date = $request->input('deposit_date_update');
        $performance->PayBack_date = $request->input('PayBack_date_update');

        $performance->save();

        return redirect()->route('project.edit', $project_id);
        
    }
}
