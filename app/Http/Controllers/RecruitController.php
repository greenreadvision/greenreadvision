<?php

namespace App\Http\Controllers;

use App\Functions\RandomId;
use App\Question;
use App\Recruit;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Cast\String_;

class RecruitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pm.recruit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pm.recruit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photo_path = null;
        $front_of_IDcard_path = null;
        $back_of_IDcard_path = null;
        $front_of_healthCard_path = null;
        $back_of_healthCard_path = null;

        $request->validate([
            'user_name_CH' => 'required|string|min:1',
            'sex' => 'required|string',
            'user_name_EN' => 'required|string|min:1',
            'birthday' => 'required|date',
            'nickname' => 'required|string|min:1',
            'work_position' => 'required|string|min:2|max:20',
            'Email' => 'required|string|min:1',
            'photo_path' => 'required|file',
            'contact_person_1_name' => 'required|string|min:1',
            'contact_person_1_phone' => 'required|string|size:10',
            'contact_person_2_name' => 'nullable|string',
            'contact_person_2_phone' => 'nullable|string|size:10',
            'phone' => 'required|string',
            'celephone' => 'required|string|size:10',
            'marry' => 'required|string|size:1',
            'IDcard_number' => 'required|string|size:10',
            'first_day' => 'required|date',
            'residence_address' => 'required|string|max:100',
            'contact_address' => 'required|string|max:100',
            'front_of_IDcard_path' => 'required|file',
            'back_of_IDcard_path' => 'required|file',
            'front_of_healthCard_path' => 'required|file',
            'back_of_healthCard_path' => 'required|file',
        ]);

        $recruit_ids = Recruit::select('Recruit_id')->get()->map(function($recruit){return $recruit->Recruit_id;})->toArray();
        $newId = RandomId::getNewId($recruit_ids);
        $nickname = \Auth::user()->nickname;

        if($request->hasFile('photo_path')){
            if ($request->photo_path->isValid()){
                $request->photo_path->storeAs('public/recruit/'.$nickname,$request->photo_path->getClientOriginalName());
                $photo_path = 'recruit/'.$nickname.'/'.$request->photo_path->getClientOriginalName();
            }
        }
        if($request->hasFile('front_of_IDcard_path')){
            if ($request->front_of_IDcard_path->isValid()){
                $request->front_of_IDcard_path->storeAs('public/recruit/'.$nickname,$request->front_of_IDcard_path->getClientOriginalName());
                $front_of_IDcard_path = 'recruit/'.$nickname.'/'.$request->front_of_IDcard_path->getClientOriginalName();
            }
        }
        if($request->hasFile('back_of_IDcard_path')){
            if ($request->back_of_IDcard_path->isValid()){
                $request->back_of_IDcard_path->storeAs('public/recruit/'.$nickname,$request->back_of_IDcard_path->getClientOriginalName());
                $back_of_IDcard_path = 'recruit/'.$nickname.'/'.$request->back_of_IDcard_path->getClientOriginalName();
            }
        }
        if($request->hasFile('front_of_healthCard_path')){
            if ($request->front_of_healthCard_path->isValid()){
                $request->front_of_healthCard_path->storeAs('public/recruit/'.$nickname,$request->front_of_healthCard_path->getClientOriginalName());
                $front_of_healthCard_path = 'recruit/'.$nickname.'/'.$request->front_of_healthCard_path->getClientOriginalName();
            }
        }
        if($request->hasFile('back_of_healthCard_path')){
            if ($request->back_of_healthCard_path->isValid()){
                $request->back_of_healthCard_path->storeAs('public/recruit/'.$nickname,$request->back_of_healthCard_path->getClientOriginalName());
                $back_of_healthCard_path = 'recruit/'.$nickname.'/'.$request->back_of_healthCard_path->getClientOriginalName();
            }
        }
        $post = Recruit::create([
            'Recruit_id' => $newId,
            'user_id' => \Auth::user()->user_id,
            'user_name_CH' => $request->input('user_name_CH'),
            'sex' => $request->input('sex'),
            'user_name_EN' => $request->input('user_name_EN'),
            'birthday' => $request->input('birthday'),
            'nickname' => $request->input('nickname'),
            'work_position' => $request->input('work_position'),
            'Email' => $request->input('Email'),
            'photo_path' => $photo_path,
            'contact_person_1_name' => $request->input('contact_person_1_name'),
            'contact_person_1_phone' => $request->input('contact_person_1_phone'),
            'contact_person_2_name' => $request->input('contact_person_2_name'),
            'contact_person_2_phone' => $request->input('contact_person_2_phone'),
            'phone' => $request->input('phone'),
            'celephone' => $request->input('celephone'),
            'marry' => $request->input('marry'),
            'IDcard_number' => $request->input('IDcard_number'),
            'first_day' => $request->input('first_day'),
            'residence_address' => $request->input('residence_address'),
            'contact_address' => $request->input('contact_address'),
            'front_of_IDcard_path' => $front_of_IDcard_path,
            'back_of_IDcard_path' =>  $back_of_IDcard_path,
            'front_of_healthCard_path' => $front_of_healthCard_path,
            'back_of_healthCard_path' => $back_of_healthCard_path
        ]);
        return redirect()->route('train.first.show',$newId);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function testCreate(){
        
    }

    public function activeVideo(){
        return view('pm.recruit.activeTrain');
    }

    public function activeTest(){
        $questions = Question::inRandomOrder()->where('type','=','active')->get();
        return view('pm.recruit.test')->with('data',$questions);
    }

    public function activeReview(Request $request){
        $questions = Question::where('type','=','active')->get();
        $questions_value = 100/count($questions);
        $grade = 0;
        $total = [];
        $href = "active";
        foreach($questions as $data){
            $fail=[];
            $answer = $request->input($data->question_id);
            if($answer == $data->answer)
            {
                $grade = $grade+$questions_value;
            }
            else
            {
                array_push($fail,Question::find($data->question_id));
                array_push($fail,$answer);
                array_push($total,$fail);
            }
        }
        return view('pm.recruit.result',['grade'=>$grade,'fail'=>$total,'href'=>$href]);
    }
    
    
    public function pmVideo(){
        return view('pm.recruit.pmTrain');
    }

    public function pmTest(){
        $questions = Question::inRandomOrder()->where('type','=','pm')->get();
        return view('pm.recruit.test')->with('data',$questions);
    }

    public function pmReview(Request $request){
        $questions = Question::where('type','=','pm')->get();   //取得題庫
        $questions_value = 100/count($questions);
        $grade = 0;
        $total = [];
        $href = "pm";
        foreach($questions as $data){
            $fail=[];
            $answer = $request->input($data->question_id);      //回答
            if($answer == $data->answer)
            {
                $grade = $grade+$questions_value;
            }
            else
            {
                array_push($fail,Question::find($data->question_id));
                array_push($fail,$answer);
                array_push($total,$fail);
            }
            
        }
        return view('pm.recruit.result',['grade'=>$grade,'fail'=>$total,'href'=>$href]);
    }

    public function show(String $recruit_id)
    {
        $recruit = Recruit::find($recruit_id);
        return view('pm.recruit.showRecruit', ['recruit' => $recruit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $recruit = Recruit::with('user')->where('user_id','=',\Auth::user()->user_id)->update(['test_complete'=>true]);

        return view('pm.recruit.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function download(){
        return response()->download(storage_path('app/public/' . 'basic_information_file.docx'));
        
    }

    public function upload(Request $request){

        $basic_file_path = null;
        $basic_file_name = "123456";

        $request->validate([
            'basic_information_file' => 'required|file',
            'labor_file' => 'nullable|file',
        ]);

        
        $recruit_ids = Recruit::select('Recruit_id')->get()->map(function($recruit){return $recruit->Recruit_id;})->toArray();
        $newId = RandomId::getNewId($recruit_ids);
        
        if($request->hasFile('basic_information_file')){
            if ($request->basic_information_file->isValid()){
                $basic_file_path = $request->basic_information_file->storeAs('recruit',$request->basic_information_file->getClientOriginalName());
            }
        }

        $post = Recruit::store([
            'Recruit_id' => $newId,
            'user_id' => \Auth::user()->user_id,
            'basic_information_file' => $basic_file_path,
            'labor_file' => $basic_file_name,
        ]);
        return redirect()->route('train.index');

    }
}
