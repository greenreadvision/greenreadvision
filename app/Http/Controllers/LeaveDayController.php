<?php

namespace App\Http\Controllers;

use App\Event;
use App\LeaveDay;
use App\LeaveDayApply;
use App\LeaveDayBreak;
use App\LeaveDayBreakEvent;
use App\Functions\RandomId;
use Illuminate\Http\Request;

class LeaveDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(String $id, String $year)
    {   
        $temp = explode("-",$year);
        $status = $temp[1];
        $year = $temp[0];

        $leave_day = LeaveDay::find($id);
        $leave_day_applies = $leave_day->leaveDayApply;
        $leave_day_breaks = $leave_day->leaveDayBreak;
        $s = 0;
        $h = 0;
        $year_has_break = ['compensatory_leave_break'=>0,'bereavement_leave'=>0];
        $total_has_break =  ['compensatory_leave_break'=>0,'bereavement_leave'=>0];
        $year_should_break = 0;
        $total_should_break = 0;
        $months = ["01" => '一月', "02" => '二月', "03" => '三月', "04" => '四月', "05" => '五月', "06" => '六月', "07" => '七月', "08" => '八月', "09" => '九月', "10" => '十月', "11" => '十一月', "12" => '十二月'];
        $month_has_breaks = ["01" => 0, "02" => 0, "03" => 0, "04" => 0, "05" => 0, "06" => 0, "07" => 0, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0];
        $half_has_breaks = ["01" => '', "02" => '', "03" => '', "04" => '', "05" => '', "06" => '', "07" => '', "08" => '', "09" => '', "10" => '', "11" => '', "12" => ''];
        $has_breaks = ["01" => '', "02" => '', "03" => '', "04" => '', "05" => '', "06" => '', "07" => '', "08" => '', "09" => '', "10" => '', "11" => '', "12" => ''];
        $has_breaks_temp = [];
        foreach ($leave_day_applies as $key => $data) {
            if ($data['status'] == 'managed' && $data['leave_day_id'] == $id) {
                $s += $data['should_break'];
            }
            if (substr($leave_day_applies[$key]['apply_date'], 0, 4) == $year) {
                if ($data['status'] == 'managed') {
                    $year_should_break = $year_should_break + $leave_day_applies[$key]['should_break'];
                }
            }
            if ($data['status'] == 'managed') {
                $total_should_break = $total_should_break + $leave_day_applies[$key]['should_break'];
            }

        }
       
        foreach ($leave_day_breaks as $key => $data) {
           
            if ($data['status'] == 'managed' && $data['leave_day_id'] == $id) {
                $h += $data['has_break'];
            }
            if (substr($leave_day_breaks[$key]['apply_date'], 0, 4) == $year) {
                if ($data['status'] == 'managed') {
                    $year_has_break[$data->types] = $year_has_break[$data->types] + $leave_day_breaks[$key]['has_break'];
                    $month_has_breaks[substr($leave_day_breaks[$key]['apply_date'], 5, 2)] = $month_has_breaks[substr($leave_day_breaks[$key]['apply_date'], 5, 2)] + $leave_day_breaks[$key]['has_break'];
                    if ($leave_day_breaks[$key]['type'] == 'half') {
                        $half_has_breaks[substr($leave_day_breaks[$key]['apply_date'], 5, 2)] = substr($leave_day_breaks[$key]['apply_date'], 8, 2) . " " . $half_has_breaks[substr($leave_day_breaks[$key]['apply_date'], 5, 2)];
                    }
                    else{
                        foreach ($leave_day_breaks[$key]->LeaveDayBreakEvents as $LeaveDayBreakEvent) {
                            array_push($has_breaks_temp,substr($LeaveDayBreakEvent->event->date, 5, 5));
                        }
                        
                        
                    }
                }
            }
            if ($data['status'] == 'managed') {
                $total_has_break[$data->types] = $total_has_break[$data->types] + $leave_day_breaks[$key]['has_break'];
            }
        }

        $total_wait_break = $total_should_break - $total_has_break['compensatory_leave_break'];
        
        sort($has_breaks_temp);
        foreach($has_breaks_temp as $temp){
            $has_breaks[substr($temp, 0, 2)] =  $has_breaks[substr($temp, 0, 2)] . " " . substr($temp, 3, 2);
        }
       
        $leave_day->save();
        $leaveDays = LeaveDay::all();
        return view('pm.leaveDay.indexLeaveDay', ["leave_day" => $leave_day, "leaveDays" => $leaveDays, "has_breaks" => $has_breaks, "half_has_breaks" => $half_has_breaks, "year_should_break" => $year_should_break, "year_has_break" => $year_has_break,'total_wait_break' => $total_wait_break, "month_has_breaks" => $month_has_breaks, "leave_day_breaks" => $leave_day_breaks, "leave_day_applies" => $leave_day_applies, "year" => $year, "months" => $months, "leaveDayId" => $id,"status"=>$status]);
    }
}
