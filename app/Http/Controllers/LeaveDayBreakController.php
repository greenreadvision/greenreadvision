<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EventController;
use App\LeaveDayBreakEvent;
use App\LeaveDayBreak;
use App\LeaveDay;
use App\Functions\RandomId;
use Illuminate\Http\Request;
use App\Event;
use App\LeaveDayApply;

class LeaveDayBreakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    public function store(Request $request, String $leave_day_id)
    {
        $request->validate([
            'days_long' => 'required|numeric',
            'content' => 'required|string|min:1'
        ]);

        switch ($request->input('length_long')) {
            case 'days':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                $date = date("Y-m-d", strtotime(substr($start_datetime, 0, 10))) . '~' . date("Y-m-d", strtotime(substr($end_datetime, 0, 10)));
                break;
            case 'twoDays':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                $date = date("Y-m-d", strtotime(substr($start_datetime, 0, 10))) . '~' . date("Y-m-d", strtotime(substr($end_datetime, 0, 10)));
                // $date = date("Y-m-d", strtotime(substr($start_datetime, 0, 10))) . '~' . date("Y-m-d", strtotime("$start_datetime +1 day"));
                break;
            case 'day':
                $start_datetime = $request->another_day;
                $end_datetime = $request->another_day;
                $date = date("Y-m-d", strtotime(substr($start_datetime, 0, 10)));
                break;
            case 'half':
                $start_datetime = $request->another_day;
                $end_datetime = $request->another_day;
                $date = date("Y-m-d", strtotime(substr($start_datetime, 0, 10)));
                break;
            case 'hours':
                $start_datetime = $request->another_day . ' ' . $request->start_time;
                $end_datetime = $request->another_day . ' ' . $request->end_time;
                $date = date("Y-m-d", strtotime($request->another_day)) . ' ' . $request->start_time . '~' .  date("Y-m-d", strtotime($request->end_another_day)). ' ' . $request->end_time;

                break;
            default:
                break;
        }
        $leave_day_break_ids = LeaveDayBreak::select('leave_day_break_id')->get()->map(function ($leave_day_break) {
            return $leave_day_break->leave_day_break_id;
        })->toArray();
        $newId = RandomId::getNewId($leave_day_break_ids);
        if ($request->hasFile('prove_path')) {
            if ($request->prove_path->isValid()) {
                $prove = $request->prove_path->storeAs('public/prove', $request->prove_path->getClientOriginalName());
                $prove_route = 'prove/'. $request->prove_path->getClientOriginalName();
            }
        }
        if($request->types =='compensatory_leave_break'){
            $post = LeaveDayBreak::create([
                'leave_day_id' =>  $leave_day_id,
                'leave_day_break_id' => $newId,
                'apply_date' => $date,
                'has_break' => $request->input('days_long'),
                'types' => $request->types,
                'content' => $request->content,
                'type' => $request->length_long,
                'status' => 'waiting'
            ]);
        }else{
            $post = LeaveDayBreak::create([
                'leave_day_id' =>  $leave_day_id,
                'leave_day_break_id' => $newId,
                'apply_date' => $date,
                'has_break' => $request->input('days_long'),
                'types' => $request->types,
                'type' => $request->length_long,
                'content' => $request->content,
                'prove' => $prove_route,
                'status' => 'waiting'
            ]);
        }

        if ($request->length_long == "days" || $request->length_long == "twoDays") {
            $period = \Carbon\CarbonPeriod::create($request->start_day, $request->end_day);
            foreach ($period as $date) {
                EventController::create($date->format('Y-m-d'), __('customize.LeaveDay'),  $request->input('days_long') . '天', __('customize.LeaveDay'), 'leaveDay', $newId);
            }
        } else if ($request->length_long == "hours") {

            EventController::create(substr($start_datetime, 0, 10), __('customize.LeaveDay'), $request->input('days_long') . '天', __('customize.LeaveDay'), 'leaveDay', $newId);
        } else {
            $content = ($request->length_long == 'day' ? '' : ($request->start_hour . "~" . $request->end_hour . "\n")) . $request->content;
            EventController::create($request->input('another_day'), __('customize.LeaveDay'), $request->input('days_long') . '天', __('customize.LeaveDay'), 'leaveDay', $newId);
        }
        return redirect()->route('leaveDay.show', [$leave_day_id, date("Y").'-break']);
    }
    public function create(String $leave_day_id)
    {
        //
        $types = ['compensatory_leave_break', 'bereavement_leave'];
        $selects = ['days','twoDays', 'day', 'half', 'hours'];
        return view('pm.leaveDay.createLeaveDayBreak', ["leaveDayId" => $leave_day_id, 'types' => $types, 'selects' => $selects]);
    }



    public function match(String $leave_day_break_id,String $year)
    {

        $LeaveDayBreak = LeaveDayBreak::find($leave_day_break_id);
        $leaveDayId = $LeaveDayBreak['leave_day_id'];

        $LeaveDayBreak->status = 'managed';
        $LeaveDayBreak->save();


        return redirect()->route('leaveDay.show', [$leaveDayId, $year.'-break']);
    }

    public function destroy(String $leave_day_break_id,String $year)
    {
        $LeaveDayBreak = LeaveDayBreak::find($leave_day_break_id);
        $leaveDayId = $LeaveDayBreak['leave_day_id'];
        foreach ($LeaveDayBreak->LeaveDayBreakEvents as $leaveDayBreakEvent) $leaveDayBreakEvent->event->delete();
        $LeaveDayBreak->delete();


        return redirect()->route('leaveDay.show', [$leaveDayId, $year.'-break']);
    }
}
