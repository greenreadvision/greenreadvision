<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

App::make('files')->link(storage_path('app/public'), public_path('storage'));

use App\Board;
use App\Ckeditor;
use App\Functions\RandomId;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Null_;
use SebastianBergmann\Environment\Console;

class BoardController extends Controller
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
        $users=[];
        $allUsers = User::orderby('user_id')->get();
        $board = Board::select('board_id','user_id','title','newTypes','updata_date')->orderby('created_at', 'desc')->with('user')->get();
        
        foreach($allUsers as $allUser){
            //if ($allUser->role != 'manager' &&count($allUser->boards) != 0) {
            if (count($allUser->boards) != 0) {
                array_push($users, $allUser);
            }
        }

        return view('grv.CMS.board.index',['users'=>$users,'board'=>$board]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        public function create(){
            return view('grv.CMS.board.create');
        }

    public function show(String $board_id){
        $board = Board::find($board_id);
        $types = ['news', 'service', 'question'];
        return view('grv.CMS.board.show')->with(['board'=>$board, 'types'=>$types]);
    }

    public function store(Request $request)
    {
        $board_ids = Board::select('board_id')->get()->map(function ($board) {
            return $board->board_id;
        })->toArray();

        $request->validate([
            'Added-title'=>'required|string',
            'type' =>'required|string',
            'Added-time' => 'nullable|date',
            'Added-title' => 'required|string|max:100',
            'ckeditor' => 'required|'
        ]);

        $id = RandomId::getNewId($board_ids);
        $numbers = Board::all();
        $i = 0;
        $max = 0;
        $body_content = $request->input('ckeditor');
        
        foreach ($numbers->toArray() as $number) {
            if (substr($number['created_at'], 0, 7) == date("Y-m")) {
                $i++;
                if ($number['number'] > $max) {
                    $max = $number['number'];
                }
            }
        }
        if ($max > $i) {
            $var = sprintf("%03d", $max + 1);
            $i = $max;
        } else {
            $var = sprintf("%03d", $i + 1);
        }

        if(is_null($request->input('Added-time')) ){
            $update = date('Y-m-d');
        }
        else{
            $update = $request->input('Added-time');
        }

        $body_content = str_replace('"',"'",$body_content);

        $finished_id = "B" . (date('Y') - 1911) . date("m") . $var;
        $post = Board::create([
            'board_id' => $finished_id,
            'user_id' => \Auth::user()->user_id, 
            'title' => $request->input('Added-title'),
            'number' => $i+1, 
            'newTypes' => $request->input('type'),
            'updata_date' => $update,
            'content' => $body_content
        ]);
        

        return redirect()->route('board.show', $finished_id);
    }

    public function update(Request $request, String $id,string $type)
    {
        $board = Board::find($id);
        switch($type){
            case 'title':
                $board->title = $request->input('title');
                $board->save();
                break;
            case 'type':
                $board->newTypes = $request->input('type');
                $board->save();
                break;
            case 'content':
                $request->validate([
                    'ckeditor' => 'required|string|max:5000'
                ]);
                $board->content = $request->input('ckeditor');
                $board->save();
                break;
            default:
                break;
        }
        return redirect()->route('board.show', $id);
    }
    function delete($id){
        $board = Board::find($id);
        $board->delete();
        return redirect()->route('board.index');
    }

}
