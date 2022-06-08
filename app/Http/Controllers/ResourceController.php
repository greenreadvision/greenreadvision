<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

App::make('files')->link(storage_path('app/public'), public_path('storage'));

use App\Resource;
use App\Ckeditor;
use App\Functions\RandomId;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Null_;
use SebastianBergmann\Environment\Console;

class ResourceController extends Controller{
    function index(){
        $types = ['host', 'performance', 'stall_food', 'stall_ngo', 'tour', 'manufacturer'];
        $datas = Resource::select('id','name','type','phone','email', 'intro',)->orderby('created_at', 'desc')->get();
        return view('pm.resource.index', ['datas'=>$datas, 'types'=>$types ]);
    }

    function create(){
        $types = ['host', 'performance', 'stall_food', 'stall_ngo', 'tour', 'manufacturer'];
        return view('pm.resource.create',['types' => $types]);
    }

    function store(Request $request){
        $resource_ids = Resource::select('id')->get()->map(function ($resource) {
            return $resource->id;
        })->toArray();

        $request -> validate([
            'name' => 'required|string|min:1',
            'type' => 'required|string|min:1',
            'phone' => 'required|string|min:8',
            'email' => 'nullable|string',
            'intro' => 'nullable|string',
            'ckeditor' => 'nullable|string'
        ]);

        $id = RandomId::getNewId($resource_ids);
        // $numbers = Resource::all();
        // $i = 0;
        // $max = 0;
        
        // foreach ($numbers->toArray() as $number) {
        //     if (substr($number['created_at'], 0, 7) == date("Y-m")) {
        //         $i++;
        //         if ($number['number'] > $max) {
        //             $max = $number['number'];
        //         }
        //     }
        // }
        // if ($max > $i) {
        //     $var = sprintf("%03d", $max + 1);
        //     $i = $max;
        // } else {
        //     $var = sprintf("%03d", $i + 1);
        // }

        // $finished_id = "R" . (date('Y') - 1911) . date("m") . $var;

        $post = Resource::create([
            'id' => $id,
            'name' => $request -> input('name'),
            'type' => $request -> input('type'),
            'phone' => $request -> input('phone'),
            'email' => $request -> input('email'),
            'intro' => $request -> input('intro'),
            'note' => str_replace('"',"'",$request->input('ckeditor'))
        ]);
        return redirect()->route('resource.show', $id);
    }

    function show(String $id){
        $data = Resource::find($id);
        $types = ['host', 'performance', 'stall_food', 'stall_ngo', 'tour', 'manufacturer'];
        return view('pm.resource.show')->with(['data'=>$data, 'types'=> $types]);
    }

    function update(Request $request, String $id,string $type){
        $resource = Resource::find($id);
        switch($type){
            case 'name':
                $resource->name = $request->input('name');
                $resource->save();
                break;
            case 'type':
                $resource->type = $request->input('type');
                $resource->save();
                break;
            case 'phone':
                $resource->phone = $request->input('phone');
                $resource->save();
                break;
            case 'email':
                $resource->email = $request->input('email');
                $resource->save();
                break;
            case 'intro':
                $resource->intro = $request->input('intro');
                $resource->save();
                break;      
            case 'note':
                $request->validate([
                    'ckeditor' => 'required|string|max:5000'
                ]);
                $resource->note = $request->input('ckeditor');
                $resource->save();
                break;
            default:
                break;
        }
        return redirect()->route('resource.show', $id);
    }
    
    function delete($id){
        $resource = Resource::find($id);
        $resource->delete();
        return redirect()->route('resource.index');
    }
}