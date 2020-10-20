<?php

namespace App\Http\Controllers;

use App\Event;
use App\OffDay;
use App\OffDayEvent;
use Illuminate\Http\Request;
use App\Functions\RandomId;
use App\Http\Controllers\EventController;

class OffDayController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $off_days = OffDay::all();
        return view('pm.calendar.indexOffDay', ["off_days" => $off_days]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'hours'=>''];
        return view('pm.calendar.createOffDay', ['selected' => $selected]);
    }

    public function createTwo(Request $request)
    {
        //
        // [start_day, end_day, another_day, start_hour, end_hour]
        $selected = [];
        $hidden = [];
        $names = ["start_day", "end_day", "another_day", "start_hour", "end_hour"];
        $types = ["date", "date", "date", "time", "time"];
        switch ($request->length) {
            case 'days':
                $selected = ['days'=>'selected','twoDays'=>'', 'day'=>'', 'hours'=>''];
                $hidden = ["", "", "hidden", "hidden", "hidden"];
                break;
            case 'twoDays':
                $selected = ['days'=>'','twoDays'=>'selected', 'day'=>'', 'hours'=>''];
                $hidden = ["", "", "hidden", "hidden", "hidden"];
                break;
            case 'day':
                $selected = ['days'=>'', 'twoDays'=>'','day'=>'selected', 'hours'=>''];
                $hidden = ["hidden", "hidden", "", "hidden", "hidden"];
                break;
            case 'hours':
                $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'hours'=>'selected'];
                $hidden = ["hidden", "hidden", "", "", ""];
                break;
            default:
                $selected = ['days'=>'','twoDays'=>'', 'day'=>'', 'hours'=>''];
                $hidden = ["", "", "", "", ""];
                break;
        }
        return view('pm.calendar.createOffDay', ['length' => $request->length, 'selected' => $selected, 'names' => $names, 'types' => $types, 'hidden' => $hidden]);
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
            'length' => 'required|string|max:10',
            'start_day' => 'nullable|date',
            'end_day' => 'nullable|date',
            'another_day' => 'nullable|date',
            'start_hour' => 'nullable|date_format:H:i',
            'end_hour' => 'nullable|date_format:H:i|after:start_hour',
            'content' => 'nullable|string|max:255'
        ]);

        $off_day_ids = OffDay::where('user_id', \Auth::user()->user_id)->get()->map(function($off_day) { return $off_day->off_day_id; })->toArray();
        $start_datetime = "";
        $end_datetime = "";

        switch ($request->length) {
            case 'days':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                break;
            case 'twoDays':
                $start_datetime = $request->start_day;
                $end_datetime = $request->end_day;
                break;
            case 'day':
                $start_datetime = $request->another_day;
                $end_datetime = $request->another_day;
                break;
            case 'hours':
                $start_datetime = date($request->another_day.' '.$request->start_hour);
                $end_datetime = date($request->another_day.' '.$request->end_hour);
                break;
            default:
                break;
        }

        $newId = RandomId::getNewId($off_day_ids);

        OffDay::create([
            'off_day_id' => $newId,
            'user_id' => \Auth::user()->user_id,
            'type' => $request->length,
            'start_datetime' => $start_datetime,
            'end_datetime' => $end_datetime,
            'status' => 'waiting'
        ]);

        if ($request->length == "days"||$request->length == "twoDays") {
            $period = \Carbon\CarbonPeriod::create($request->start_day, $request->end_day);
            foreach ($period as $date) {
                EventController::create($date->format('Y-m-d'), __('customize.OffDay'), $request->content, __('customize.OffDay'), 'offDay', $newId);
            }
        }
        else {
            $content = ($request->length=='day'? '':($request->start_hour."~".$request->end_hour."\n")).$request->content;
            EventController::create($request->input('another_day'), __('customize.OffDay'), $content, __('customize.OffDay'), 'offDay', $newId);
        }
        return redirect()->route('offDay.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(String $year, String $month)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(String $event_id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $event)
    {
        //
    }

    /**
     * Permit the off days by manager.
     */
    public function match(String $off_day_id)
    {
        //
        $offDay = OffDay::find($off_day_id);
        if (\Auth::user()->role == 'manager'||\Auth::user()->role == 'accountant') {
            $offDay->status = 'managed';
            $offDay->save();
        }
        return redirect()->route('offDay.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $off_day_id)
    {
        //
        $offDay = OffDay::find($off_day_id);
        foreach ($offDay->offDayEvents as $offDayEvent) $offDayEvent->event->delete();
        $offDay->delete();

        return redirect()->route('offDay.index');
    }
}
