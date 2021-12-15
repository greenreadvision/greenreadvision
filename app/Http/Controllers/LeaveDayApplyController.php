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

    public function store(Request $request, String $leaveDayId)
    {
        $request->validate([
            'days_long' => 'required|numeric',
            'contents' => 'required|string'
        ]);

        $leave_day_apply_ids = LeaveDayApply::select('leave_day_apply_id')->get()->map(function ($leave_day_apply) {
            return $leave_day_apply->leave_day_apply_id;
        })->toArray();
        $newId = RandomId::getNewId($leave_day_apply_ids);

        
        
        if ($request->input('length_long') == 'days') {
            $apply_date = date("Y-m-d", strtotime($request->input('start_day'))) . '~' . date("Y-m-d", strtotime($request->input('end_day')));
        } else if ($request->input('length_long') == 'day' || $request->input('length_long') == 'half') {
            $apply_date = date("Y-m-d", strtotime($request->input('another_day')));
        } else if ($request->input('length_long') == 'hours') {
            $apply_date = date("Y-m-d", strtotime($request->input('another_day'))) . ' ' . $request->input('start_time') . '~' . $request->input('end_time');
        }

        $post = LeaveDayApply::create([
            'leave_day_id' =>  $leaveDayId,
            'leave_day_apply_id' => $newId,
            'type' => $request->input('type'),
            'content' => $request->input('contents'),
            'apply_date' => $apply_date,
            'should_break' => $request->input('days_long'),
            'status' => 'waiting'
        ]);

        return redirect()->route('leaveDay.show', [$leaveDayId, date("Y").'-apply']);
    }

    public function addStore(Request $request, String $leaveDayId)
    {
        //
        $request->validate([
            'apply_date' => 'required|date',
            // 'should_break'=>'required|integer'
        ]);

        $leave_day_apply_ids = LeaveDayApply::select('leave_day_apply_id')->get()->map(function ($leave_day_apply) {
            return $leave_day_apply->leave_day_apply_id;
        })->toArray();
        $newId = RandomId::getNewId($leave_day_apply_ids);

        $post = LeaveDayApply::create([
            'leave_day_id' =>  $leaveDayId,
            'leave_day_apply_id' => $newId,
            'content' => '特休',
            'apply_date' => $request->input('apply_date'),
            'should_break' => $request->input('should_break'),
            'status' => 'managed'
        ]);

        return redirect()->route('leaveDay.show', [$leaveDayId, date("Y")]);
    }
    public function create(String $leave_day_id)
    {
        $selects = ['days', 'day', 'half', 'houes'];

        return view('pm.leaveDay.createLeaveDayApply', ["leaveDayId" => $leave_day_id, 'selects' => $selects]);
    }

    public function add(String $leave_day_id)
    {
        return view('pm.leaveDay.addLeaveDayApply', ["leaveDayId" => $leave_day_id]);
    }

    public function match(String $leave_day_apply_id, String $year)
    {
        $LeaveDayApply = LeaveDayApply::find($leave_day_apply_id);
        $leaveDayId = $LeaveDayApply['leave_day_id'];
        $LeaveDayApply->status = 'managed';
        $LeaveDayApply->save();

        return redirect()->route('leaveDay.show', [$leaveDayId, $year.'-apply']);
    }
    public function destroy(String $leave_day_apply_id, String $year)
    {
        $LeaveDayApply = LeaveDayApply::find($leave_day_apply_id);
        $leaveDayId = $LeaveDayApply['leave_day_id'];
        $LeaveDayApply->delete();

        return redirect()->route('leaveDay.show', [$leaveDayId, $year.'-apply']);
    }
}
