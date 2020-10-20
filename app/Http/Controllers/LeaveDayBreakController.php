<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EventController;
use App\LeaveDayBreakEvent;
use App\LeaveDayBreak;
use App\LeaveDay;
use App\Functions\RandomId;
use Illuminate\Http\Request;
use App\Event;

class LeaveDayBreakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
    public function add(String $leave_day_id)
    {
        $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'half'=>''];
        return view('pm.leaveDay.createLeaveDayBreak', ['selected' => $selected,'leaveDayId'=>$leave_day_id]);
    }
    public function addstore(Request $request,String $leave_day_id)
    {
       
        $leaveDays = LeaveDay::all();
        foreach($leaveDays as $leaveDay){
            if($leaveDay['user_id']==\Auth::user()->user_id){
                $leaveDayId = $leaveDay['leave_day_id'];
            }
        }
        switch ($request->length) {
            case 'days':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                $days=(strtotime($end_datetime) - strtotime($start_datetime))/ (60*60*24)+1;
                $date=substr($start_datetime,0,10).'~'.substr($end_datetime,0,10);
                break;
            case 'twoDays':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                $days=2;
                $date=substr($start_datetime,0,10).'~'.substr($end_datetime,0,10);
                break;
            case 'day':
                $start_datetime = $request->another_day;
                $end_datetime = $request->another_day;
                $days=1;
                $date=substr($start_datetime,0,10);
                break;
            case 'half':
                $start_datetime = $request->another_day;
                $end_datetime = $request->another_day;
                $days=0.5;
                $date=substr($start_datetime,0,10);
                break;
            default:
                break;
        }
        $leave_day_break_ids = LeaveDayBreak::select('leave_day_break_id')->get()->map(function($leave_day_break) { return $leave_day_break->leave_day_break_id; })->toArray();
        $newId = RandomId::getNewId($leave_day_break_ids);

        $post = LeaveDayBreak::create([
            'leave_day_id' =>  $leave_day_id,
            'leave_day_break_id' =>$newId,
            'start_datetime'=>$start_datetime,
            'end_datetime'=>$end_datetime,
            'apply_date'=>$date,
            'has_break' => $days,
            'type' => $request->length,
            'status' => 'managed'
        ]);
        if ($request->length == "days"||$request->length == "twoDays") {
            $period = \Carbon\CarbonPeriod::create($request->start_day, $request->end_day);
            foreach ($period as $date) {
                EventController::create($date->format('Y-m-d'), __('customize.LeaveDay'),  $days.'天', __('customize.LeaveDay'), 'leaveDay', $newId);
            }
        }
        else {
            $content = ($request->length=='day'? '':($request->start_hour."~".$request->end_hour."\n")).$request->content;
            EventController::create($request->input('another_day'), __('customize.LeaveDay'), $days.'天', __('customize.LeaveDay'), 'leaveDay', $newId);
        }
        return redirect()->route('leaveDay.accountantIndex',$leave_day_id);
    }
    // public function add(Request $request,String $leaveDayId)
    // {
    //     $leaveDays = LeaveDay::all();
    //     $leave_day_break_ids = LeaveDayBreak::select('leave_day_break_id')->get()->map(function($leave_day_break) { return $leave_day_break->leave_day_break_id; })->toArray();
    //     $newId = RandomId::getNewId($leave_day_break_ids);

    //     $post = LeaveDayBreak::create([
    //         'leave_day_id' =>  $leaveDayId,
    //         'leave_day_break_id' =>$newId,
    //         'start_datetime'=>'2019-01-01 00:00:00',
    //         'end_datetime'=>'2019-01-01 00:00:00',
    //         'apply_date'=>'2019-01-01',
    //         'has_break' => $request->input('has_break'),
    //         'type' => '休假輸入',
    //         'status' => 'managed'
    //     ]);
        
    //     return redirect()->route('leaveDay.accountantIndex',$leaveDayId);
    // }
    public function accountantStore(Request $request,String $leaveDayId)
    {
        $leaveDays = LeaveDay::all();
        switch ($request->length) {
            case 'days':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                $days=(strtotime($end_datetime) - strtotime($start_datetime))/ (60*60*24)+1;
                $date=substr($start_datetime,0,10).'~'.substr($end_datetime,0,10);
                break;
            case 'twoDays':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                $days=2;
                $date=substr($start_datetime,0,10).'~'.substr($end_datetime,0,10);
                break;
            case 'day':
                $start_datetime = $request->another_day;
                $end_datetime = $request->another_day;
                $days=1;
                $date=substr($start_datetime,0,10);
                break;
            case 'half':
                $start_datetime = $request->another_day;
                $end_datetime = $request->another_day;
                $days=0.5;
                $date=substr($start_datetime,0,10);
                break;
            default:
                break;
        }
        $leave_day_break_ids = LeaveDayBreak::select('leave_day_break_id')->get()->map(function($leave_day_break) { return $leave_day_break->leave_day_break_id; })->toArray();
        $newId = RandomId::getNewId($leave_day_break_ids);

        $post = LeaveDayBreak::create([
            'leave_day_id' =>  $leaveDayId,
            'leave_day_break_id' =>$newId,
            'start_datetime'=>$start_datetime,
            'end_datetime'=>$end_datetime,
            'apply_date'=>$date,
            'has_break' => $days,
            'type' => $request->length,
            'status' => 'waiting'
        ]);
        $leaveDay = LeaveDay::find($leaveDayId);

        if ($request->length == "days"||$request->length == "twoDays") {
            $period = \Carbon\CarbonPeriod::create($request->start_day, $request->end_day);
            foreach ($period as $date) {
                EventController::createLeaveDay($date->format('Y-m-d'), __('customize.LeaveDay'),  $days.'天', __('customize.LeaveDay'), 'leaveDay', $newId,$leaveDay->user->user_id);
            }
        }
        else {
            $content = ($request->length=='day'? '':($request->start_hour."~".$request->end_hour."\n")).$request->content;
            EventController::createLeaveDay($request->input('another_day'), __('customize.LeaveDay'), $days.'天', __('customize.LeaveDay'), 'leaveDay', $newId,$leaveDay->user->user_id);
        }
        return redirect()->route('leaveDay.accountantIndex',$leaveDayId);
    }

    public function store(Request $request)
    {
       
        $leaveDays = LeaveDay::all();
        foreach($leaveDays as $leaveDay){
            if($leaveDay['user_id']==\Auth::user()->user_id){
                $leaveDayId = $leaveDay['leave_day_id'];
            }
        }
        switch ($request->length) {
            case 'days':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                $days=(strtotime($end_datetime) - strtotime($start_datetime))/ (60*60*24)+1;
                $date=substr($start_datetime,0,10).'~'.substr($end_datetime,0,10);
                break;
            case 'twoDays':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                $days=2;
                $date=substr($start_datetime,0,10).'~'.substr($end_datetime,0,10);
                break;
            case 'day':
                $start_datetime = $request->another_day;
                $end_datetime = $request->another_day;
                $days=1;
                $date=substr($start_datetime,0,10);
                break;
            case 'half':
                $start_datetime = $request->another_day;
                $end_datetime = $request->another_day;
                $days=0.5;
                $date=substr($start_datetime,0,10);
                break;
            default:
                break;
        }
        $leave_day_break_ids = LeaveDayBreak::select('leave_day_break_id')->get()->map(function($leave_day_break) { return $leave_day_break->leave_day_break_id; })->toArray();
        $newId = RandomId::getNewId($leave_day_break_ids);

        $post = LeaveDayBreak::create([
            'leave_day_id' =>  $leaveDayId,
            'leave_day_break_id' =>$newId,
            'start_datetime'=>$start_datetime,
            'end_datetime'=>$end_datetime,
            'apply_date'=>$date,
            'has_break' => $days,
            'type' => $request->length,
            'status' => 'waiting'
        ]);
        if ($request->length == "days"||$request->length == "twoDays") {
            $period = \Carbon\CarbonPeriod::create($request->start_day, $request->end_day);
            foreach ($period as $date) {
                EventController::create($date->format('Y-m-d'), __('customize.LeaveDay'),  $days.'天', __('customize.LeaveDay'), 'leaveDay', $newId);
            }
        }
        else {
            $content = ($request->length=='day'? '':($request->start_hour."~".$request->end_hour."\n")).$request->content;
            EventController::create($request->input('another_day'), __('customize.LeaveDay'), $days.'天', __('customize.LeaveDay'), 'leaveDay', $newId);
        }
        return redirect()->route('leaveDay.index');
    }
    public function create()
    {
        //
        $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'half'=>''];
        return view('pm.leaveDay.createLeaveDayBreak', ['selected' => $selected]);
    }
    
    public function createTwo(Request $request)
    {
        $selected = [];
        $hidden = [];
        $names = ["start_day", "end_day", "another_day"];
        $types = ["date", "date", "date"];
        switch ($request->length) {
            case 'days':
                $selected = ['days'=>'selected','twoDays'=>'', 'day'=>'', 'half'=>''];
                $hidden = ["", "", "hidden"];
                break;
            case 'twoDays':
                $selected = ['days'=>'','twoDays'=>'selected', 'day'=>'', 'half'=>''];
                $hidden = ["", "", "hidden"];
                break;
            case 'day':
                $selected = ['days'=>'', 'twoDays'=>'','day'=>'selected', 'half'=>''];
                $hidden = ["hidden", "hidden", ""];
                break;
            case 'half':
                $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'half'=>'selected'];
                $hidden = ["hidden", "hidden", ""];
                break;
            default:
                $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'half'=>''];
                $hidden = ["", "", "", "", ""];
                break;
        }
        return view('pm.leaveDay.createLeaveDayBreak', ['length' => $request->length, 'selected' => $selected, 'names' => $names, 'types' => $types, 'hidden' => $hidden]);
    }
    public function accountantCreateTwo(Request $request,String $leaveDayId)
    {
        $selected = [];
        $hidden = [];
        $names = ["start_day", "end_day", "another_day"];
        $types = ["date", "date", "date"];
        switch ($request->length) {
            case 'days':
                $selected = ['days'=>'selected','twoDays'=>'', 'day'=>'', 'half'=>''];
                $hidden = ["", "", "hidden"];
                break;
            case 'twoDays':
                $selected = ['days'=>'','twoDays'=>'selected', 'day'=>'', 'half'=>''];
                $hidden = ["", "", "hidden"];
                break;
            case 'day':
                $selected = ['days'=>'', 'twoDays'=>'','day'=>'selected', 'half'=>''];
                $hidden = ["hidden", "hidden", ""];
                break;
            case 'half':
                $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'half'=>'selected'];
                $hidden = ["hidden", "hidden", ""];
                break;
            default:
                $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'half'=>''];
                $hidden = ["", "", "", "", ""];
                break;
        }
        return view('pm.leaveDay.createLeaveDayBreak', ['leaveDayId'=>$leaveDayId,'length' => $request->length, 'selected' => $selected, 'names' => $names, 'types' => $types, 'hidden' => $hidden]);
    }
    public function accountantCreate(String $leave_day_id)
    {
        $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'half'=>''];
        return view('pm.leaveDay.createLeaveDayBreak',["leaveDayId" => $leave_day_id,'selected' => $selected]);
    }
    public function match(String $leave_day_break_id)
    {
        
        $LeaveDayBreak=LeaveDayBreak::find($leave_day_break_id);
        $leaveDayId=$LeaveDayBreak['leave_day_id'];
        if (\Auth::user()->role == 'accountant'||\Auth::user()->role == 'manager') {
            $LeaveDayBreak->status = 'managed';
            $LeaveDayBreak->save();
        }
        $LeaveDay=LeaveDay::find($LeaveDayBreak->leave_day_id);
        $AllLeaveDayBreak=LeaveDayBreak::all();
        $hasTemp=0;
        foreach($AllLeaveDayBreak as $data){
            if($data['leave_day_id']==$LeaveDayBreak->leave_day_id && $data['status']=='managed'){
                $hasTemp+=$data['has_break'];
            }
        }
        $LeaveDay->has_break=$hasTemp;
        $LeaveDay->not_break=$LeaveDay->should_break-$LeaveDay->has_break;
        $LeaveDay->save();
        return redirect()->route('leaveDay.accountantIndex',$leaveDayId);
    }

    public function destroy(String $leave_day_break_id)
    {
        $LeaveDayBreak=LeaveDayBreak::find($leave_day_break_id);
        $leaveDayId=$LeaveDayBreak['leave_day_id'];
        foreach ($LeaveDayBreak->LeaveDayBreakEvents as $leaveDayBreakEvent) $leaveDayBreakEvent->event->delete();
        $LeaveDayBreak->delete();
        
        $LeaveDay=LeaveDay::find($LeaveDayBreak->leave_day_id);
        $AllLeaveDayBreak=LeaveDayBreak::all();
        $hasTemp=0;
        foreach($AllLeaveDayBreak as $data){
            if($data['leave_day_id']==$LeaveDayBreak->leave_day_id && $data['status']=='managed'){
                $hasTemp+=$data['has_break'];
            }
        }
        $LeaveDay->has_break=$hasTemp;
        $LeaveDay->not_break=$LeaveDay->should_break-$LeaveDay->has_break;
        $LeaveDay->save();
        return redirect()->route('leaveDay.accountantIndex',$leaveDayId);
    }
}
