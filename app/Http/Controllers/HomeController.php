<?php

namespace App\Http\Controllers;

use App\Home;
use App\Board;
use App\User;
use App\Functions\RandomId;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
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
        return view('pm.home.indexHome', ['board'=>$board,'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pm.home.createHome');
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
            'title' => 'required|string|min:2|max:255',
            'content' => 'required|string|min:2|max:255'
        ]);

        $home_ids = Home::select('home_id')->get()->map(function($home) { return $home->home_id; })->toArray();
        $newId = RandomId::getNewId($home_ids);

        $post = Home::create([
            'home_id' => $newId,
            'user_id' => \Auth::user()->user_id,
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);

        return redirect()->route('home.index');
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
    public function edit(String $home_id)
    {
        //
        $home = Home::find($home_id);
        return view('pm.home.editHome')->with('data', $home);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $home_id)
    {
        //
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'content' => 'required|string|min:2|max:255'
        ]);

        $home = Home::where('home_id', $home_id)->update($request->except('_method', '_token'));

        return redirect()->route('home.review', $home_id);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Home  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $home_id)
    {
        //Delete the project and any following datas.
        $home = Home::find($home_id);
        $home->delete();

        return redirect()->route('home.index');
    }
}
