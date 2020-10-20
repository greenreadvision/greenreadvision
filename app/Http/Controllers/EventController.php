<?php

namespace App\Http\Controllers;

use App\Event;
use App\InvoiceEvent;
use App\OffDayEvent;
use App\ProjectEvent;
use App\TodoEvent;
use App\LeaveDayBreakEvent;
use App\Todo;
use App\UserEvent;
use App\Functions\RandomId;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = \App\Project::select('project_id', 'name', 'color')->get()->toArray();
        $projectEvents = \DB::table('project_events')->join('projects', 'project_events.project_id', '=', 'projects.project_id')->select('project_events.event_id', 'projects.project_id', 'projects.name', 'projects.color')->get()->toArray();
        $users = \App\User::select('user_id', 'nickname')->get()->toArray();
        $events = Event::where('date', 'LIKE', date("Y-m-",time()).'%')->orderby('date')->get()->toArray();
        return view('pm.calendar.calendar')->with('data', ['year' => null, 'month' => null, 'event' => $events, 'project' => $projectEvents, 'user' => $users]);
    }

    /**
     *
     */
    public static function create(String $date='', String $name='Event', String $content='Content', String $type='', String $relationship='user', String $relationship_id='') {

        $event_ids = Event::select('event_id')->get()->map(function($event) { return $event->event_id; })->toArray();
        $id = RandomId::getNewId($event_ids);

        $post = Event::create([
            'event_id' => $id,
            'user_id' => \Auth::user()->user_id,
            'date' => $date,
            'name' => $name,
            'content' => $content,
            'type' => $type,
            'relationship' => $relationship,
        ]);

        $transform = null;
        switch ($relationship) {
            case 'user':
                $transform = UserEvent::create([
                    'event_id' => $id,
                    'user_id' => $relationship_id
                ]);
                break;
            case 'project':
                $transform = ProjectEvent::create([
                    'event_id' => $id,
                    'project_id' => $relationship_id
                ]);
                break;
            case 'invoice':
                $transform = InvoiceEvent::create([
                    'event_id' => $id,
                    'invoice_id' => $relationship_id,
                ]);
                break;
            case 'todo':
                $transform = TodoEvent::create([
                    'event_id' => $id,
                    'todo_id' => $relationship_id
                ]);
                break;
            case 'offDay':
                $transform = OffDayEvent::create([
                    'event_id' => $id,
                    'off_day_id' => $relationship_id
                ]);
                break;
            case 'leaveDay':
                $transform = LeaveDayBreakEvent::create([
                    'event_id' => $id,
                    'leave_day_break_id' =>$relationship_id
                ]);
                break;
            default:
                # code...
                break;
        }
    }

    public static function createLeaveDay(String $date='', String $name='Event', String $content='Content', String $type='', String $relationship='user', String $relationship_id='',String $leaveDay_id) {

        $event_ids = Event::select('event_id')->get()->map(function($event) { return $event->event_id; })->toArray();
        $id = RandomId::getNewId($event_ids);

        $post = Event::create([
            'event_id' => $id,
            'user_id' => $leaveDay_id,
            'date' => $date,
            'name' => $name,
            'content' => $content,
            'type' => $type,
            'relationship' => $relationship,
        ]);

        $transform = null;
        switch ($relationship) {
            case 'user':
                $transform = UserEvent::create([
                    'event_id' => $id,
                    'user_id' => $relationship_id
                ]);
                break;
            case 'project':
                $transform = ProjectEvent::create([
                    'event_id' => $id,
                    'project_id' => $relationship_id
                ]);
                break;
            case 'invoice':
                $transform = InvoiceEvent::create([
                    'event_id' => $id,
                    'invoice_id' => $relationship_id,
                ]);
                break;
            case 'todo':
                $transform = TodoEvent::create([
                    'event_id' => $id,
                    'todo_id' => $relationship_id
                ]);
                break;
            case 'offDay':
                $transform = OffDayEvent::create([
                    'event_id' => $id,
                    'off_day_id' => $relationship_id
                ]);
                break;
            case 'leaveDay':
                $transform = LeaveDayBreakEvent::create([
                    'event_id' => $id,
                    'leave_day_break_id' =>$relationship_id
                ]);
                break;
            default:
                # code...
                break;
        }
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
        $projectEvents = \DB::table('project_events')->join('projects', 'project_events.project_id', '=', 'projects.project_id')->select('project_events.event_id', 'projects.project_id', 'projects.name', 'projects.color')->get()->toArray();
        $users = \App\User::select('user_id', 'nickname')->get()->toArray();
        $events = Event::where('date', 'LIKE', date("Y-m-",strtotime($year.'-'.$month.'-01')).'%')->orderby('date')->get()->toArray();
        return view('pm.calendar.calendar')->with('data', ['year' => $year, 'month' => $month, 'event' => $events, 'project' => $projectEvents, 'user' => $users]);
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
        $event = Event::where('event_id', $event_id)->get()->toArray()[0];

        return ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public static function update(String $id, $date=null, $name=null, $content=null, $type=null)
    {
        //
        $event = Event::find($id);
        if (!is_null($date))
            $event->date = $date;
        if (!is_null($name))
            $event->name = $name;
        if (!is_null($content))
            $event->content = $content;
        if (!is_null($type))
            $event->type = $type;
        $event->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public static function destroy(String $event_id)
    {
        //Delete the event
        Event::find($event_id)->delete();
    }

    /**
     *
     */
    public function find(String $id){
        return Event::find($id);
    }
}
