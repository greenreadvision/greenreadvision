<?php

namespace App\Http\Controllers;
use App\Question;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(){
        $questions = Question::with('user')->orderby('question_id')->get();
        $type = ['active','pm'];
        return view("pm.question.index",['question'=>$questions,'type'=>$type]);
    }

    public function create(){
        return view("pm.question.create");
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:191|min:1',
            'option_1'=>'required|string|max:191|min:1',
            'option_2'=>'required|string|max:191|min:1',
            'option_3'=>'required|string|max:191|min:1',
            'option_4'=>'required|string|max:191|min:1',
            'type' => 'required|string|min:1',
            'answer' =>'required|string|size:8',
            'content'=>'nullable|string',
        ]);
        
        if($request->input('type')=='active'){
            $question = Question::where('type','=','active')->get();
            $title = 'ACQ-';
        }
        elseif($request->input('type')=='pm'){
            $question = Question::where('type','=','pm')->get();
            $title = 'PMQ-';
        }
            
        $ids = [];
        foreach($question as $data){
            $temp = substr($data->question_id,4);
            array_push($ids,$temp);
        }
        $num = (int)last($ids) + 1;
        $newId = $title . (string)$num;
        
        $post = Question::create([
            'question_id' => $newId,
            'user_id' => \Auth::user()->user_id,
            'title' => $request->input('title'),
            'option_1'=>$request->input('option_1'),
            'option_2'=>$request->input('option_2'),
            'option_3'=>$request->input('option_3'),
            'option_4'=>$request->input('option_4'),
            'type' => $request->input('type'),
            'answer' => $request->input('answer'),
            'content'=> $request->input('content')
        ]);
        return redirect()->route('question.index');
       
    }

    public function edit(String $quesiton_id){
        $question = Question::find($quesiton_id);
        return view('pm.question.edit')->with('data', $question);

    }

    public function update(Request $request,String $quesiton_id){
        $request->validate([
            'title' => 'required|string|max:191|min:1',
            'option_1'=>'required|string|max:191|min:1',
            'option_2'=>'required|string|max:191|min:1',
            'option_3'=>'required|string|max:191|min:1',
            'option_4'=>'required|string|max:191|min:1',
            'type' => 'required|string|min:1',
            'answer' =>'required|string|size:8',
            'content'=>'nullable|string',
        ]);

        $question = Question::Where('question_id',$quesiton_id)->update($request->except('_method', '_token'));

        return redirect()->route('question.index');
    }

    public function delete(String $question_id){
        $question = Question::find($question_id);

        $question->delete();

        return redirect()->route('question.index');
    }
}
