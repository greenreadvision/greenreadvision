<?php

namespace App\Http\Controllers;

use App\Gding;
use Illuminate\Http\Request;

class GdingController extends Controller
{
    public function store(Request $request, String $project_id){
        $item_total_num = $request->input('item_total_num');
        $gdings = Gding::all();
        $j = 0;
        $max = 0;
        foreach ($gdings->toArray() as $number) {
            
            if ($number['project_id'] == $project_id) {
                $j++;
                if ($number['num'] > $max) {
                    $max = $number['num'];
                }
            }
        }
        if ($max > $j) {
            $j = $max;
        }
        
        for($i = 0 ; $i < $item_total_num ; $i++){
            if($request->input('title-' . $i) != ''){
                $j++;
                $request->validate([
                    'title-' . $i => 'required|min:1|string',
                    'note-' . $i => 'required|string|min:1',
                    'price-' . $i => 'required',
                    'note-' . $i => 'nullable|string'
                ]); 
                $max++;
                Gding::create([
                    'num' => $j,
                    'project_id' => $project_id,
                    'title' => $request->input('title-' . $i),
                    'note' => $request->input('note-' . $i),
                    'price' => $request->input('price-' . $i),
                ]);
            }
            
        }
        return redirect()->route('project.edit', $project_id);
    }

    public function update(Request $request,String $project_id,String $id){
        $gding_item = Gding::find($id);
        $request->validate([
            'EditDging_title' => 'required|min:1|string',
            'EditDging_note' => 'required|string|min:1',
            'EditDging_price' => 'required'
        ]); 

        $gding_item->title = $request->input('EditDging_title');
        $gding_item->note = $request->input('EditDging_note');
        $gding_item->price = $request->input('EditDging_price');
        $gding_item->save();
        return redirect()->route('project.edit', $project_id);
    }

    public function delete(Request $request,String $project_id,String $id){
        $gding_item = Gding::find($id);
        $gding_all = Gding::all();
        foreach($gding_all as $item){
            if($item['num'] > $gding_item['num']){
                $j = $item['num'];
                $j--;
                $item->num = $j;
                $item->save();
            }
        }
        $gding_item->delete();

        return redirect()->route('project.edit', $project_id);
    }

}
