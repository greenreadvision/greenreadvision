<?php

namespace App\Http\Controllers;

use App\DefaultItem;
use App\Gding;
use App\Invoice;
use App\Performance;
use App\Project;
use Illuminate\Http\Request;

class DefaultController extends Controller
{

    public function store(Request $request, String $project_id){
        //專案Default建立
        $request->validate([
            'default_persen' =>'required|string',
            'default_date' => 'required|string',
            'default_content' => 'required|string',
        ]);
        $gdings = DefaultItem::all();
        $j = 0;
        $max = 0;
        foreach ($gdings->toArray() as $number) {
            
            if ($number['project_id'] == $project_id) {
                $j++;
                if ($number['no'] > $max) {
                    $max = $number['no'];
                }
            }
        }
        if ($max > $j) {
            $j = $max;
        }
        $j = $j+1;
        DefaultItem::create([
            'no' => $j,
            'project_id' => $project_id,
            'persen'=> $request->input('default_persen' ),
            'content' => $request->input('default_content'),
            'default_date' =>$request->input('default_date')
            
        ]);
        return redirect()->route('project.setCost', $project_id);
    }
    public function update(Request $request,String $project_id,String $default_id){
        $request->validate([
            'edit_default_persen' =>'required|string',
            'edit_default_date' => 'required|string',
            'edit_default_content' => 'required|string',
        ]);

        $default_item = DefaultItem::find($default_id);
        $default_item->content = $request->input('edit_default_content');
        $default_item->persen = $request->input('edit_default_persen');
        $default_item->default_date = $request->input('edit_default_date');
        $default_item->save();


        return redirect()->route('project.setCost', $project_id);
    }

    public function destory(Request $request,String $project_id,String $default_id){
        $default_item = DefaultItem::find($default_id);
        
        $default_all = DefaultItem::where('project_id','=',$project_id)->get();
        foreach($default_all as $item){
            if($item['no'] > $default_item['no']){
                $j = $item['no'];
                $j--;
                $item->no = $j;
                $item->save();
            }
        }
        $default_item->delete();
        return redirect()->route('project.setCost', $project_id);

    }

    
}
