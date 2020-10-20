<?php

namespace App\Http\Controllers;

use App\LeaveDayApply;
use App\LeaveDay;
use App\Functions\RandomId;
use Illuminate\Http\Request;

class LeaveDayApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }


    public function accountantStore(Request $request,String $leaveDayId)
    {
        //
        $leaveDays = LeaveDay::all();

        $request->validate([
            'content' => 'required|max:255',
            'apply_date' => 'required|date',
            // 'should_break'=>'required|integer'
        ]);

        $leave_day_apply_ids = LeaveDayApply::select('leave_day_apply_id')->get()->map(function($leave_day_apply) { return $leave_day_apply->leave_day_apply_id; })->toArray();
        $newId = RandomId::getNewId($leave_day_apply_ids);

        $post = LeaveDayApply::create([
            'leave_day_id' =>  $leaveDayId,
            'leave_day_apply_id' =>$newId,
            'content' => $request->input('content'),
            'apply_date' => $request->input('apply_date'),
            'should_break' => $request->input('should_break'),
            'status' => 'waiting'
        ]);

        return redirect()->route('leaveDay.accountantIndex',$leaveDayId);
    }

    public function store(Request $request)
    {
        //
        $leaveDays = LeaveDay::all();
        foreach($leaveDays as $leaveDay){
            if($leaveDay['user_id']==\Auth::user()->user_id){
                $leaveDayId = $leaveDay['leave_day_id'];
            }
        }
        $request->validate([
            'content' => 'required|max:255',
            'apply_date' => 'required|date',
            // 'should_break'=>'required|integer'
        ]);

        $leave_day_apply_ids = LeaveDayApply::select('leave_day_apply_id')->get()->map(function($leave_day_apply) { return $leave_day_apply->leave_day_apply_id; })->toArray();
        $newId = RandomId::getNewId($leave_day_apply_ids);

        $post = LeaveDayApply::create([
            'leave_day_id' =>  $leaveDayId,
            'leave_day_apply_id' =>$newId,
            'content' => $request->input('content'),
            'apply_date' => $request->input('apply_date'),
            'should_break' => $request->input('should_break'),
            'status' => 'waiting'
        ]);

        return redirect()->route('leaveDay.index');
    }
    public function addStore(Request $request,String $leaveDayId)
    {
        //
        $leaveDays = LeaveDay::all();

        $request->validate([
            'apply_date' => 'required|date',
            // 'should_break'=>'required|integer'
        ]);

        $leave_day_apply_ids = LeaveDayApply::select('leave_day_apply_id')->get()->map(function($leave_day_apply) { return $leave_day_apply->leave_day_apply_id; })->toArray();
        $newId = RandomId::getNewId($leave_day_apply_ids);

        $post = LeaveDayApply::create([
            'leave_day_id' =>  $leaveDayId,
            'leave_day_apply_id' =>$newId,
            'content' => '特休',
            'apply_date' => $request->input('apply_date'),
            'should_break' => $request->input('should_break'),
            'status' => 'managed'
        ]);

        return redirect()->route('leaveDay.accountantIndex',$leaveDayId);
    }
    public function create()
    {
        return view('pm.leaveDay.createLeaveDayApply');
    }
    public function accountantCreate(String $leave_day_id)
    {
        return view('pm.leaveDay.createLeaveDayApply',["leaveDayId" => $leave_day_id]);
    }
    public function add(String $leave_day_id)
    {
        return view('pm.leaveDay.addLeaveDayApply',["leaveDayId" => $leave_day_id]);
    }
    
    public function match(String $leave_day_apply_id)
    {
        $LeaveDayApply=LeaveDayApply::find($leave_day_apply_id);
        $leaveDayId=$LeaveDayApply['leave_day_id'];
        if (\Auth::user()->role == 'accountant'||\Auth::user()->role == 'manager') {
            $LeaveDayApply->status = 'managed';
            $LeaveDayApply->save();
        }
        $LeaveDay=LeaveDay::find($LeaveDayApply->leave_day_id);
        $AllLeaveDayApply=LeaveDayApply::all();
        $shouldTemp=0;
        foreach($AllLeaveDayApply as $data){
            if($data['leave_day_id']==$LeaveDayApply->leave_day_id && $data['status']=='managed'){
                $shouldTemp+=$data['should_break'];
            }
        }
        $LeaveDay->should_break=$shouldTemp;
        $LeaveDay->not_break=$LeaveDay->should_break-$LeaveDay->has_break;
        $LeaveDay->save();
        return redirect()->route('leaveDay.accountantIndex',$leaveDayId);
    }
    public function destroy(String $leave_day_apply_id)
    {
        $LeaveDayApply=LeaveDayApply::find($leave_day_apply_id);
        $leaveDayId=$LeaveDayApply['leave_day_id'];
        $LeaveDayApply->delete();

        $LeaveDay=LeaveDay::find($LeaveDayApply->leave_day_id);
        $AllLeaveDayApply=LeaveDayApply::all();
        $shouldTemp=0;
        foreach($AllLeaveDayApply as $data){
            if($data['leave_day_id']==$LeaveDayApply->leave_day_id && $data['status']=='managed'){
                $shouldTemp+=$data['should_break'];
            }
        }
        $LeaveDay->should_break=$shouldTemp;
        $LeaveDay->not_break=$LeaveDay->should_break-$LeaveDay->has_break;
        $LeaveDay->save();
        return redirect()->route('leaveDay.accountantIndex',$leaveDayId);
    }
}
