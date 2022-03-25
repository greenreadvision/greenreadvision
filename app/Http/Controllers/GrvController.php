<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivityType;
use App\Board;
use App\RealName;
use App\Photos;
use App\PhotosEvent;
use App\Products;
use Illuminate\Http\Request;
use App\Functions\RandomId;

class GrvController extends Controller
{
    //
    public function SearchYears($path)
    {
        if ($pathOpen = opendir($path)) {
            while ($name = readdir($pathOpen)) {
                if ($name == "." || $name == "..") {     //跳過./與../資料夾目錄
                    continue;
                } elseif (is_dir($path . $name)) {           //找到資料夾，存取名稱
                    $years[] = $name;
                }
            }
        }
        return $years;
    }
    public function SearchEventPictures($path, $target)
    {
        $newPath = "$path$target/";
        if ($pathOpen = opendir($newPath)) {
            $keyName = $target;
            $isVision = false;
            $isPic = false;
            while ($name = readdir($pathOpen)) {
                if ($name == "." || $name == "..") {     //跳過./與../資料夾目錄
                    continue;
                } elseif (is_dir($newPath . $name)) {        //找到資料夾進入下一層
                    $events[] = GrvController::SearchEventPictures($newPath, $name);
                } else {                                   //到達最底層，開始尋找圖檔
                    switch (pathinfo($name, PATHINFO_FILENAME)) {
                        case "keyVision":
                            $isVision = true;
                            $keyVision = $newPath . $name;
                            break;
                        case "keyPic":
                            $isPic = true;
                            $keyPic = $newPath . $name;
                            break;
                        default:
                            // continue;
                            break;
                    }
                }
            }
            if ($isVision && $isPic) {
                $events = array("name" => $keyName, "keyVision" => $keyVision, "keyPic" => $keyPic);
            }
        }
        return $events;
    }

    public function index()
    {
        $board = Board::select('board_id','user_id','title','newTypes','updata_date')->orderby('created_at', 'desc')->with('user')->get();
        $products = Products::orderby('order')->get();
        foreach($products as $data){
            $data->path = explode('/', $data->path);
         }

        $activities = Activity::orderby('created_at', 'desc')->get();
        $activity_type = ActivityType::orderby('created_at', 'desc')->get();
        foreach($activities as $data){
            $data->img_path = explode('/', $data->img_path);
 
        }
        return view('grv.index',['products'=>$products,'board'=>$board,'types'=>$activity_type,'activities' =>$activities]);
    }
    public function about()
    {
        return view('grv.about');
    }
    public function history()
    {
        $allYears = GrvController::SearchYears("./img/history/");
        $arr = GrvController::SearchEventPictures("./img/", "history");
        return view('grv.history')->with('data', ['allYears' => $allYears, 'arr' => $arr]);
    }
    public function events()
    {
        return view('grv.events');
    }
    public function goods()
    {
        return view('grv.goods');
    }
    public function video()
    {
        return view('grv.video');
    }
    public function contact()
    {
        return view('grv.contact');
    }
    public function eventpage()
    {
        return view('grv.eventpage');
    }
    public function show(String $type)
    {
        $photo = Photos::orderby('name', 'desc')->get();
        $photos = [];
        foreach ($photo as $data) {
            if ($data['type'] == $type) {
                array_push($photos, $data);
            }
        }
        foreach ($photos as $data) {
            $data->path = explode('/', $data->path);
        }
        return view('grv.showevent', ['photos' => $photos, 'type' => $type]);
    }

    public function grvCode()
    {
        return view('pm.grvCode.index');
    }

    public function grvCodeShow(String $real_name_id)
    {
        return view('pm.grvCode.show',["real_name_id"=>$real_name_id]);
    }

    public function grvCodeStore(Request $request)
    {

        $grvCodes = RealName::all();
        $state = 0;
        foreach ($grvCodes as $data) {
            if ($data->identity_card == strtoupper($request->input('identity_card'))) {
                $state = 1;
                $temp = RealName::find($data->real_name_id);
            }
        }
        $request->validate([
            'identity_card' => 'required|string|size:10'
        ]);
        $grvCode_ids = RealName::select('real_name_id')->get()->map(function ($real_name) {
            return $real_name->real_name_id;
        })->toArray();
        $newId = RandomId::getNewId($grvCode_ids);

        if ($state == 0) {

            $post = RealName::create([
                'real_name_id' => $newId,
                'name' => $request->input('name'),
                'identity_card' => strtoupper($request->input('identity_card')),
            ]);
        } else {

            $temp->real_name_id = $newId;
            $temp->name = $request->input('name');
            $temp->save();
        }
        return redirect()->route('grvCode.show', $newId);
    }

    public function view(String $type, String $photo_id)
    {
        $photo = Photos::find($photo_id);
        $photo_event = PhotosEvent::all();
        $photo_events = [];
        foreach ($photo_event as $data) {
            if ($data['photo_id'] == $photo_id) {
                array_push($photo_events, $data);
            }
        }
        foreach ($photo_events as $data) {
            $data->path = explode('/', $data->path);
        }
        return view('grv.event', ['data' => $photo_events, 'type' => $type, 'photo' => $photo]);
    }
}
