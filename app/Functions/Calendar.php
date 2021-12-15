<?php
/**
*@author  Xu Ding
*@email   thedilab@gmail.com
*@website http://www.StarTutorial.com
**/

use App\Todo;
use App\TodoEvent;
use App\Project;
use App\OffDay;
use App\OffDayEvent;
use App\LeaveDay;
use App\LeaveDayBreak;
use App\LeaveDayBreakEvent;
class Calendar {

    /**
     * Constructor
     */
    public function __construct(){
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }

    /********************* PROPERTY ********************/
    private $dayLabels = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");

    private $currentYear=0;

    private $currentMonth=0;

    private $currentDay=0;

    private $currentDate=null;

    private $daysInMonth=0;

    private $naviHref=null;

    private $date = '';

    /********************* PUBLIC **********************/

    /**
    * print out the calendar
    */
    public function show($year=null, $month=null, $event=null, $project=null, $user=null) {

        if(null==$year&&isset($_GET['year'])){

            $year = $_GET['year'];

        }else if(null==$year){

            $year = date("Y",time());

        }

        if(null==$month&&isset($_GET['month'])){

            $month = $_GET['month'];

        }else if(null==$month){

            $month = date("m",time());

        }

        $this->event=$event;

        $this->event_index=array_column($project, 'event_id');

        $this->event_column=array_column($event, 'date');

        $this->project=$project;

        $this->user=$user;

        $this->currentYear=$year;

        $this->currentMonth=$month;

        $this->daysInMonth=$this->_daysInMonth($month,$year);

        $this->weekInMonth=$this->_weeksInMonth($month,$year);
        return
        '<div id="calendar">
            <div class="box">'.
                $this->_createNavi().
            '</div>
            <table class="table table-bordered" style="margin-bottom:0px;table-layout:fixed;text-align:center;">
            <thead>
                <tr class="label bg-light">'.
                        $this->_createLabels().
                '</tr>
                </thead>
                <tbody>'.
                    $this->_showEveryDay().
                '</tbody>
            </table>
        </div>';
    }

    /********************* PRIVATE **********************/
    /**
     * output every day and html to string.
     */
    private function _showEveryDay(){
        $allDays = "";
        // Create weeks in a month
        for( $i=0; $i<$this->weekInMonth; $i++ ){
            $allDays.='<tr class="label">';
            //Create days in a week
            for($j=0;$j<=6;$j++){
                $allDays.=$this->_showDay($i*7+$j);
            }
            $allDays.='</tr>';
        }
        return $allDays;
    }

    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){

        if($this->currentDay==0){

            $firstDayOfTheWeek = date('w',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));

            if(intval($cellNumber) == intval($firstDayOfTheWeek)){

                $this->currentDay=1;

            }
        }

        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){

            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));

            $cellContent = $this->currentDay;

            $this->currentDay++;

        }else{

            $this->currentDate =null;

            $cellContent=null;
        }

        $cellEvent = '';
        if ($this->currentDate!=null){
            if (in_array($this->currentDate, $this->event_column)){
                $eventDate = array_keys($this->event_column, $this->currentDate);
                foreach($eventDate as $value){
                    $cellEvent .= $this->_showEvent($this->event[$value]);
                }
            }
        }

        return
        '<td id="'.$this->currentDate.'" class="'.($cellNumber%7==1?' start':($cellNumber%7==0?' end':'')).($cellContent==null?'mask':'').'" style="height:11vh;padding:1px;">
            <span>'.$cellContent.'</span><br />'.
            $cellEvent.
        '</td>';
    }

    /**
     * output events and the background to string.
     */
    private function _showEvent(Array $event){
        //test_data
        $color = "#";
        $colorNumberArray = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F'];
        for($i=0;$i<6;$i++) { $color.=$colorNumberArray[rand(8,15)]; }
        $eventName =$event['name'];
        $project_color = '#CCC';
        $project_name = '無';
        if ($event['relationship'] == 'project') {
            $project_index = array_search($event['event_id'], $this->event_index);
            $project_color = $this->project[$project_index]->color;
            $project_name = $this->project[$project_index]->name;
            $Projects = Project::select('name','open_time','deadline_time')->get()->toArray();
            foreach($Projects as $data){
                if($data['name'] == $project_name){
                    $openTime=substr($data['open_time'],0,5);
                    $closeTime=substr($data['deadline_time'],0,5);
                }
            }
            if($event['content']=='開標日期'){
                $eventName='開標時間 '.$openTime;
            }
            else if($event['content']=='截標日期'){
                $eventName='截標時間 '.$closeTime;
            }
        }
        else if($event['relationship'] == 'todo'){
            $todos = Todo::select('project_id', 'todo_id')->get()->toArray();
            $todoEvents = TodoEvent::select('event_id', 'todo_id')->get()->toArray();
            $projects = Project::select('project_id', 'name','color')->get()->toArray();
            $todoTemp='';
            $projectTemp='';
            foreach($todoEvents as $data){
                if($data['event_id'] == $event['event_id']){
                    $todoTemp=$data['todo_id'];
                }
            }
            foreach($todos as $data){
                if($data['todo_id'] ==  $todoTemp){
                    $projectTemp=$data['project_id'];
                }
            }
            foreach($projects as $data){
                if($data['project_id'] ==  $projectTemp){
                    $project_color = $data['color'];
                    $project_name = $data['name'];
                }
            }
        }
        else if($event['relationship'] == 'offDay'){
            $offDays = OffDay::all();
            $offDayEvents = OffDayEvent::select('event_id', 'off_day_id')->get()->toArray();
            $offDayTemp='';
            foreach($offDayEvents as $data){
                if($data['event_id'] ==  $event['event_id']){
                    $offDayTemp=$data['off_day_id'];
                }
            }
            foreach($offDays as $data){
                if($data['off_day_id'] ==  $offDayTemp){
                    $eventName=$data->user['nickname'].$event['name'];
                    $eventStatus=$data['status'];
                }
            }
            $color='#000';
        }
        else if($event['relationship'] == 'leaveDay'){
            $LeaveDayBreaks = LeaveDayBreak::all();
            $LeaveDayBreakEvents = LeaveDayBreakEvent::select('event_id', 'leave_day_break_id')->get()->toArray();
            $LeaveDayBreakTemp='';
            foreach($LeaveDayBreakEvents as $data){
                if($data['event_id'] ==  $event['event_id']){
                    $LeaveDayBreakTemp=$data['leave_day_break_id'];
                }
            }
            foreach($LeaveDayBreaks as $data){
                if($data['leave_day_break_id'] ==  $LeaveDayBreakTemp){
                   $LeaveDayTemp=$data['leave_day_id'];
                    $eventStatus=$data['status'];
                }
            }
            $LeaveDays=LeaveDay::all();
            
            foreach($LeaveDays as $data){
                if($data['leave_day_id'] ==  $LeaveDayTemp){
                    $eventName=$data->user['nickname'].$event['name'];
                }
            }
            $project_color = '#343434';
            $color='#FFF';
        }
        $user_index = array_search($event['user_id'], array_map('array_shift', $this->user));
        if($event['relationship'] != 'offDay'&&$event['relationship'] != 'leaveDay'){
            return
            '<div class="m-1" style="background-color:'.$project_color.'40;border-radius:25px;text-align:center;">
                <a tabindex="0" style="text-decoration:none;color:black;" role="button" data-toggle="popover" data-trigger="hover" data-html="true" title="'.$event['name'].'" data-content="專案：'.$project_name.'<br />內容：'.$event['content'].'<br />專案負責人：'.$this->user[$user_index]['nickname'].'">
                    <div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <span>'.$eventName.'</span>
                    </div>
                </a>
            </div>';
        }
        else{
            if($eventStatus =='managed'){
                return
            '<div class="m-1" style="background-color:'.$project_color.';border-radius:25px;text-align:center;">
                <a tabindex="0" style="text-decoration:none;color:black;" role="button" data-toggle="popover" data-trigger="hover" data-html="true" title="'.$event['name'].'" data-content="專案：'.$project_name.'<br />類型：'.$event['type'].'<br />內容：'.$event['content'].'<br />人員：'.$this->user[$user_index]['nickname'].'">
                    <div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <span style="color:'.$color.';">'.$eventName.'</span>
                    </div>
                </a>
            </div>';
            }
        }
    }


    /**
    * create navigation
    */
    private function _createNavi(){

        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;

        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;

        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;

        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;

        return
        '<div class="col-md d-flex text-center justify-content-between align-items-center my-2">'.
            // '<a class="prev" style="float:left;" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
            // '<a class="next" style="float:right;" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '<a class="" href="'.route('calendar.show', ['year' => $preYear, 'month' => sprintf('%02d',$preMonth)]).'"> <i class="fas fa-angle-double-left" style="font-size:1.5rem;width:2rem"></i></a>'.
            '<h2 class="title"> '.date('Y',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'&nbsp;'.__('customize.'.date('M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1'))).' </h2>'.
            '<a class="" href="'.route('calendar.show', ['year' => $nextYear, 'month' => sprintf('%02d',$nextMonth)]).'"> <i class="fas fa-angle-double-right" style="font-size:1.5rem;width:2rem"></i></a>'.
        '</div>';
    }

    /**
    * create calendar week labels
    */
    private function _createLabels(){

        $content='';

        foreach($this->dayLabels as $index=>$label){
            $content.='<th class="'.($label==6?'end title':'start title').' title">'.__('customize.'.$label).'</th>';
        }

        return $content;
    }

    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){

        if( null==($year) ) {
            $year =  date("Y",time());
        }

        if(null==($month)) {
            $month = date("m",time());
        }

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);

        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);

        $monthEndingDay= date('w',strtotime($year.'-'.$month.'-'.$daysInMonths));

        $monthStartDay = date('w',strtotime($year.'-'.$month.'-01'));

        if($monthEndingDay<$monthStartDay){
            $numOfweeks++;
        }

        return $numOfweeks;
    }

    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){

        if(null==($year))
            $year =  date("Y",time());

        if(null==($month))
            $month = date("m",time());

        return date('t',strtotime($year.'-'.$month.'-01'));
    }

}
