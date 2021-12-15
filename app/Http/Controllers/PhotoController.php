<?php

namespace App\Http\Controllers;

use App\Event;
use App\Photos;
use App\PhotosEvent;
use App\Functions\RandomId;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $photos = Photos::orderby('name')->get();
        $type=[['name'=>'客家文化','type'=>'hakka'],['name'=>'閱讀','type'=>'read'],['name'=>'親子活動','type'=>'child'],['name'=>'營運類','type'=>'operation']];
        //
        // $projects = Project::with('user')->with('invoices')->with('todos')->orderby('deadline_date')->get();
        foreach($photos as $data){
           $data->path = explode('/', $data->path);

        }
        return view('pm.photo.index', ["photos" => $photos,"type"=>$type]);
    }

    public function create()
    {
        //
        return view('pm.photo.createPhoto');
    }

    public function store(Request $request)
    {
        $file_path=null;

        $request->validate([
            'name' => 'required|unique:photos|min:2|max:255',
            'type' => 'required|string',
            'path' => 'required|file',
        ]);

        $photo_ids = Photos::select('photo_id')->get()->map(function($photo) { return $photo->photo_id; })->toArray();
        $newId = RandomId::getNewId($photo_ids);

        if ($request->hasFile('path')){
            if ($request->path->isValid()){
                $file_path = $request->path->storeAs('photo',$request->path->getClientOriginalName());
            }
        }
        
        $post = Photos::create([
            'name' => $request->input('name'),
            'user_id' => \Auth::user()->user_id,
            'photo_id' => $newId,
            'type' => $request->input('type'),
            'path' => $file_path,
        ]);
        return redirect()->route('photo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(String $photo_id)
    {
        //
        $photo = Photos::find($photo_id);
        $photo->path = explode('/', $photo->path);
        $image=PhotosEvent::all();
        foreach($image as $data){
            $data->path = explode('/', $data->path);
         }
        return view('pm.photo.showPhoto',['photo'=>$photo,'image'=>$image,'photo_id'=>$photo_id]);
    }

    public function showCreate(Request $request,String $photo_id)
    {

        for($i=0 ; $i<count($request->path) ; $i++){
            $file_path=null;

            $image_ids = PhotosEvent::select('image_id')->get()->map(function($photo) { return $photo->image_id; })->toArray();
            $newId = RandomId::getNewId($image_ids);

            // $request->validate([
            //     'path[$i]' => 'required|file',
            // ]);


            if ($request->hasFile('path')){
                if ($request->path[$i]->isValid()){
                    $file_path = $request->path[$i]->storeAs('photo',$request->path[$i]->getClientOriginalName());
                }
            }
            $post = PhotosEvent::create([
                'image_id' => $newId,
                'photo_id' => $photo_id,
                'path' => $file_path,
            ]);
        }
        

        return redirect()->route('photo.review',$photo_id);
    }

    public function destroy(String $photo_id)
    {
        //Delete the invoice
        $photo = Photos::find($photo_id);
        \Illuminate\Support\Facades\Storage::delete([$photo->path]);
        foreach ($photo->photoEvents as $photoEvent){
            $photoEvent->delete();
            \Illuminate\Support\Facades\Storage::delete([$photoEvent->path]);
        } 

        $photo->delete();

        return redirect()->route('photo.index');
    }

    public function destroyImage(Request $request,String $photo_id)
    {
        $test = $request->input('checkbox');
        $photoEvent = PhotosEvent::all();
        foreach($test as $data){
           foreach($photoEvent as $image){
               if($image['image_id']==$data){
                $image->delete();
                \Illuminate\Support\Facades\Storage::delete([$image->path]);
               }
           }
            
        }
        return redirect()->route('photo.review',$photo_id);
    }
}
