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
    
    public function index()
    {
        $year=date("Y");
        $leaveDayBreaks=LeaveDayBreak::orderby('apply_date', 'desc')->get();
        $LeaveDayBreakEvents=LeaveDayBreakEvent::all();
        $leaveDayApplies = LeaveDayApply::orderby('apply_date', 'desc')->get();
        $leaveDays = LeaveDay::all();
        foreach($leaveDays as $leaveDay){
            if($leaveDay['user_id']==\Auth::user()->user_id){
                $leaveDayId = $leaveDay['leave_day_id'];
            }
        }

        $l=LeaveDay::find($leaveDayId);
        $s=0;
        $h=0;
        foreach($leaveDayApplies as $data){
            if($data['status']=='managed'&&$data['leave_day_id']==$leaveDayId){
                $s+=$data['should_break'];
            }
        }
        foreach($leaveDayBreaks as $data){
            if($data['status']=='managed'&&$data['leave_day_id']==$leaveDayId){
                $h+=$data['has_break'];
            }
        }
        $l->should_break= $s;
        $l->has_break=$h;
        $l->not_break= $l->should_break- $l->has_break;
        $l->save();
        $leaveDays = LeaveDay::all();
        $events=Event::all();
        $has1=0;
        $has2=0;
        $has3=0;
        $has4=0;
        $has5=0;
        $has6=0;
        $has7=0;
        $has8=0;
        $has9=0;
        $has10=0;
        $has11=0;
        $has12=0;
        
        $half1='';
        $half2='';
        $half3='';
        $half4='';
        $half5='';
        $half6='';
        $half7='';
        $half8='';
        $half9='';
        $half10='';
        $half11='';
        $half12='';

        $day1='';
        $day2='';
        $day3='';
        $day4='';
        $day5='';
        $day6='';
        $day7='';
        $day8='';
        $day9='';
        $day10='';
        $day11='';
        $day12='';

        $days1=[];
        $days2=[];
        $days3=[];
        $days4=[];
        $days5=[];
        $days6=[];
        $days7=[];
        $days8=[];
        $days9=[];
        $days10=[];
        $days11=[];
        $days12=[];

        $halfs1=[];
        $halfs2=[];
        $halfs3=[];
        $halfs4=[];
        $halfs5=[];
        $halfs6=[];
        $halfs7=[];
        $halfs8=[];
        $halfs9=[];
        $halfs10=[];
        $halfs11=[];
        $halfs12=[];

        $i=0;
        $j=0;
        foreach($events as $data){
            if($data['user_id']==$l->user['user_id']&&$data['name']=='休假'&&$data['content']!='0.5天'){
                if(substr($data['date'],0,4)==$year){
                    if(substr($data['date'],5,2)=='01'){
                        $has1++;
                        array_push($days1,substr($data['date'],8,2));
                        for($i=0;$i<count($days1);$i++){
                            for($j =$i+1;$j<count($days1);$j++){
                                if($days1[$j]<$days1[$i]){
                                    $temp=$days1[$j];
                                    $days1[$j]=$days1[$i];
                                    $days1[$i]=$temp;
                                }
                            }
                        }    
                    }
                    else if(substr($data['date'],5,2)=='02'){
                        $has2++;
                        array_push($days2,substr($data['date'],8,2));
                        for($i=0;$i<count($days2);$i++){
                            for($j =$i+1;$j<count($days2);$j++){
                                if($days2[$j]<$days2[$i]){
                                    $temp=$days2[$j];
                                    $days2[$j]=$days2[$i];
                                    $days2[$i]=$temp;
                                }
                            }
                        }    
                    }
                    else if(substr($data['date'],5,2)=='03'){
                        $has3++;
                        array_push($days3,substr($data['date'],8,2));
                        for($i=0;$i<count($days3);$i++){
                            for($j =$i+1;$j<count($days3);$j++){
                                if($days3[$j]<$days3[$i]){
                                    $temp=$days3[$j];
                                    $days3[$j]=$days3[$i];
                                    $days3[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='04'){
                        $has4++;
                        array_push($days4,substr($data['date'],8,2));
                        for($i=0;$i<count($days4);$i++){
                            for($j =$i+1;$j<count($days4);$j++){
                                if($days4[$j]<$days4[$i]){
                                    $temp=$days4[$j];
                                    $days4[$j]=$days4[$i];
                                    $days4[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='05'){
                        $has5++;
                        array_push($days5,substr($data['date'],8,2));
                        for($i=0;$i<count($days5);$i++){
                            for($j =$i+1;$j<count($days5);$j++){
                                if($days5[$j]<$days5[$i]){
                                    $temp=$days5[$j];
                                    $days5[$j]=$days5[$i];
                                    $days5[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='06'){
                        $has6++;
                        array_push($days6,substr($data['date'],8,2));
                        for($i=0;$i<count($days6);$i++){
                            for($j =$i+1;$j<count($days6);$j++){
                                if($days6[$j]<$days6[$i]){
                                    $temp=$days6[$j];
                                    $days6[$j]=$days6[$i];
                                    $days6[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='07'){
                        $has7++;
                        array_push($days7,substr($data['date'],8,2));
                        for($i=0;$i<count($days7);$i++){
                            for($j =$i+1;$j<count($days7);$j++){
                                if($days7[$j]<$days7[$i]){
                                    $temp=$days7[$j];
                                    $days7[$j]=$days7[$i];
                                    $days7[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='08'){
                        $has8++;
                        array_push($days8,substr($data['date'],8,2));
                        for($i=0;$i<count($days8);$i++){
                            for($j =$i+1;$j<count($days8);$j++){
                                if($days8[$j]<$days8[$i]){
                                    $temp=$days8[$j];
                                    $days8[$j]=$days8[$i];
                                    $days8[$i]=$temp;
                                }
                            }
                        }               
                    }
                    else if(substr($data['date'],5,2)=='09'){
                        $has9++;
                        array_push($days9,substr($data['date'],8,2));
                        for($i=0;$i<count($days9);$i++){
                            for($j =$i+1;$j<count($days9);$j++){
                                if($days9[$j]<$days9[$i]){
                                    $temp=$days9[$j];
                                    $days9[$j]=$days9[$i];
                                    $days9[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='10'){
                        $has10++;
                        array_push($days10,substr($data['date'],8,2));
                        for($i=0;$i<count($days10);$i++){
                            for($j =$i+1;$j<count($days10);$j++){
                                if($days10[$j]<$days10[$i]){
                                    $temp=$days10[$j];
                                    $days10[$j]=$days10[$i];
                                    $days10[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='11'){
                        $has11++;
                        array_push($days11,substr($data['date'],8,2));
                        for($i=0;$i<count($days11);$i++){
                            for($j =$i+1;$j<count($days11);$j++){
                                if($days11[$j]<$days11[$i]){
                                    $temp=$days11[$j];
                                    $days11[$j]=$days11[$i];
                                    $days11[$i]=$temp;
                                }
                            }
                        }

                    }
                    else if(substr($data['date'],5,2)=='12'){
                        $has12++;
                        array_push($days12,substr($data['date'],8,2));
                        for($i=0;$i<count($days12);$i++){
                            for($j =$i+1;$j<count($days12);$j++){
                                if($days12[$j]<$days12[$i]){
                                    $temp=$days12[$j];
                                    $days12[$j]=$days12[$i];
                                    $days12[$i]=$temp;
                                }
                            }
                        }

                    }
                }
            }
            else if($data['user_id']==$l->user['user_id']&&$data['name']=='休假'&&$data['content']=='0.5天'){
                if(substr($data['date'],0,4)==$year){
                    if(substr($data['date'],5,2)=='01'){
                        $has1+=0.5;
                        array_push($halfs1,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs1);$i++){
                            for($j =$i+1;$j<count($halfs1);$j++){
                                if($halfs1 [$j]<$halfs1[$i]){
                                    $temp=$halfs1[$j];
                                    $halfs1[$j]=$halfs1[$i];
                                    $halfs1[$i]=$temp;
                                }
                            }
                        }    
                    }
                    else if(substr($data['date'],5,2)=='02'){
                        $has2+=0.5;
                        array_push($halfs2,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs2);$i++){
                            for($j =$i+1;$j<count($halfs2);$j++){
                                if($halfs2 [$j]<$halfs2[$i]){
                                    $temp=$halfs2[$j];
                                    $halfs2[$j]=$halfs2[$i];
                                    $halfs2[$i]=$temp;
                                }
                            }
                        }   
                    }
                    else if(substr($data['date'],5,2)=='03'){
                        $has3+=0.5;
                        array_push($halfs3,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs3);$i++){
                            for($j =$i+1;$j<count($halfs3);$j++){
                                if($halfs3 [$j]<$halfs3[$i]){
                                    $temp=$halfs3[$j];
                                    $halfs3[$j]=$halfs3[$i];
                                    $halfs3[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='04'){
                        $has4+=0.5;
                        array_push($halfs4,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs4);$i++){
                            for($j =$i+1;$j<count($halfs4);$j++){
                                if($halfs4 [$j]<$halfs4[$i]){
                                    $temp=$halfs4[$j];
                                    $halfs4[$j]=$halfs4[$i];
                                    $halfs4[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='05'){
                        $has5+=0.5;
                        array_push($halfs5,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs5);$i++){
                            for($j =$i+1;$j<count($halfs5);$j++){
                                if($halfs5 [$j]<$halfs5[$i]){
                                    $temp=$halfs5[$j];
                                    $halfs5[$j]=$halfs5[$i];
                                    $halfs5[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='06'){
                        $has6+=0.5;
                        array_push($halfs6,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs6);$i++){
                            for($j =$i+1;$j<count($halfs6);$j++){
                                if($halfs6 [$j]<$halfs6[$i]){
                                    $temp=$halfs6[$j];
                                    $halfs6[$j]=$halfs6[$i];
                                    $halfs6[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='07'){
                        $has7+=0.5;
                        array_push($halfs7,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs7);$i++){
                            for($j =$i+1;$j<count($halfs7);$j++){
                                if($halfs7 [$j]<$halfs7[$i]){
                                    $temp=$halfs7[$j];
                                    $halfs7[$j]=$halfs7[$i];
                                    $halfs7[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='08'){
                        $has8+=0.5;
                        array_push($halfs8,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs8);$i++){
                            for($j =$i+1;$j<count($halfs8);$j++){
                                if($halfs8 [$j]<$halfs8[$i]){
                                    $temp=$halfs8[$j];
                                    $halfs8[$j]=$halfs8[$i];
                                    $halfs8[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='09'){
                        $has9+=0.5;
                        array_push($halfs9,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs9);$i++){
                            for($j =$i+1;$j<count($halfs9);$j++){
                                if($halfs9 [$j]<$halfs9[$i]){
                                    $temp=$halfs9[$j];
                                    $halfs9[$j]=$halfs9[$i];
                                    $halfs9[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='10'){
                        $has10+=0.5;
                        array_push($halfs10,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs10);$i++){
                            for($j =$i+1;$j<count($halfs10);$j++){
                                if($halfs10 [$j]<$halfs10[$i]){
                                    $temp=$halfs10[$j];
                                    $halfs10[$j]=$halfs10[$i];
                                    $halfs10[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='11'){
                        $has11+=0.5;
                        array_push($halfs11,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs11);$i++){
                            for($j =$i+1;$j<count($halfs11);$j++){
                                if($halfs11 [$j]<$halfs11[$i]){
                                    $temp=$halfs11[$j];
                                    $halfs11[$j]=$halfs11[$i];
                                    $halfs11[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='12'){
                        $has12+=0.5;
                        array_push($halfs12,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs12);$i++){
                            for($j =$i+1;$j<count($halfs12);$j++){
                                if($halfs12 [$j]<$halfs12[$i]){
                                    $temp=$halfs12[$j];
                                    $halfs12[$j]=$halfs12[$i];
                                    $halfs12[$i]=$temp;
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach($days1 as $data){
            $day1=$day1.$data.' ';
        }
        foreach($days2 as $data){
            $day2=$day2.$data.' ';
        }
        foreach($days3 as $data){
            $day3=$day3.$data.' ';
        }
        foreach($days4 as $data){
            $day4=$day4.$data.' ';
        }
        foreach($days5 as $data){
            $day5=$day5.$data.' ';
        }
        foreach($days6 as $data){
            $day6=$day6.$data.' ';
        }
        foreach($days7 as $data){
            $day7=$day7.$data.' ';
        }
        foreach($days8 as $data){
            $day8=$day8.$data.' ';
        }
        foreach($days9 as $data){
            $day9=$day9.$data.' ';
        }
        foreach($days10 as $data){
            $day10=$day10.$data.' ';
        }
        foreach($days11 as $data){
            $day11=$day11.$data.' ';
        }
        foreach($days12 as $data){
            $day12=$day12.$data.' ';
        }
        foreach($halfs1 as $data){
            $half1=$half1.$data.' ';
        }
        foreach($halfs2 as $data){
            $half2=$half2.$data.' ';
        }
        foreach($halfs3 as $data){
            $half3=$half3.$data.' ';
        }
        foreach($halfs4 as $data){
            $half4=$half4.$data.' ';
        }
        foreach($halfs5 as $data){
            $half5=$half5.$data.' ';
        }
        foreach($halfs6 as $data){
            $half6=$half6.$data.' ';
        }
        foreach($halfs7 as $data){
            $half7=$half7.$data.' ';
        }
        foreach($halfs8 as $data){
            $half8=$half8.$data.' ';
        }
        foreach($halfs9 as $data){
            $half9=$half9.$data.' ';
        }
        foreach($halfs10 as $data){
            $half10=$half10.$data.' ';
        }
        foreach($halfs11 as $data){
            $half11=$half11.$data.' ';
        }
        foreach($halfs12 as $data){
            $half12=$half12.$data.' ';
        }

        $temp = "";
        $breakYears = [];
        $leaveDayBreakYearMonth = LeaveDayBreak::orderby('start_datetime', 'desc')->get();
        foreach ($leaveDayBreakYearMonth as $data) {
            if ($data->leave_day_id == $leaveDayId) {
                $stateYear = 0;

                $temp = substr($data->start_datetime, 0, 4);
                foreach ($breakYears as $breakYear) {
                    if (substr($data->start_datetime, 0, 4) == $breakYear) {
                        $stateYear = 1;
                    }
                }
                if ($stateYear == 0) {
                    array_push($breakYears, substr($data->start_datetime, 0, 4));
                }
            }
        }
        $breakMonths = [];
        foreach ($leaveDayBreakYearMonth as $data) {
            if ($data->leave_day_id == $leaveDayId) {
                $stateMonth = 0;

                $temp = substr($data->start_datetime, 0, 7);
                foreach ($breakMonths as $breakMonth) {
                    if (substr($data->start_datetime, 0, 7) == $breakMonth) {
                        $stateMonth = 1;
                    }
                }
                if ($stateMonth == 0) {
                    array_push($breakMonths, substr($data->start_datetime, 0, 7));
                }
            }
        }

        $temp = "";
        $applyYears = [];
        $leaveDayApplyYearMonth = LeaveDayApply::orderby('apply_date', 'desc')->get();
        foreach ($leaveDayApplyYearMonth as $data) {
            if ($data->leave_day_id == $leaveDayId) {
                $stateYear = 0;

                $temp = substr($data->apply_date, 0, 4);
                foreach ($applyYears as $applyYear) {
                    if (substr($data->apply_date, 0, 4) == $applyYear) {
                        $stateYear = 1;
                    }
                }
                if ($stateYear == 0) {
                    array_push($applyYears, substr($data->apply_date, 0, 4));
                }
            }
        }
        $applyMonths = [];
        foreach ($leaveDayApplyYearMonth as $data) {
            if ($data->leave_day_id == $leaveDayId) {
                $stateMonth = 0;

                $temp = substr($data->apply_date, 0, 7);
                foreach ($applyMonths as $applyMonth) {
                    if (substr($data->apply_date, 0, 7) == $applyMonth) {
                        $stateMonth = 1;
                    }
                }
                if ($stateMonth == 0) {
                    array_push($applyMonths, substr($data->apply_date, 0, 7));
                }
            }
        }

        $months = array("一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月");
        $hasdays =array("一月"=>$has1,"二月"=>$has2,"三月"=>$has3,"四月"=>$has4,"五月"=>$has5,"六月"=>$has6,"七月"=>$has7,"八月"=>$has8,"九月"=>$has9,"十月"=>$has10,"十一月"=>$has11,"十二月"=>$has12);
        $halfdays=array("一月"=>$half1,"二月"=>$half2,"三月"=>$half3,"四月"=>$half4,"五月"=>$half5,"六月"=>$half6,"七月"=>$half7,"八月"=>$half8,"九月"=>$half9,"十月"=>$half10,"十一月"=>$half11,"十二月"=>$half12);
        $days=array("一月"=>$day1,"二月"=>$day2,"三月"=>$day3,"四月"=>$day4,"五月"=>$day5,"六月"=>$day6,"七月"=>$day7,"八月"=>$day8,"九月"=>$day9,"十月"=>$day10,"十一月"=>$day11,"十二月"=>$day12);
        return view('pm.leaveDay.indexLeaveDay',["year"=> $year,"days"=>$days,"halfdays"=>$halfdays,"hasdays"=>$hasdays,"months"=>$months,"leaveDays" => $leaveDays,"leaveDayApplies" => $leaveDayApplies,"leaveDayBreaks" => $leaveDayBreaks,"leaveDayId"=>$leaveDayId,'breakMonths'=>$breakMonths,'breakYears'=>$breakYears,'applyMonths'=>$applyMonths,'applyYears'=>$applyYears]);

    }
    
    // substr($data['apply_date'],0,4)==$year
    public function accountantIndex(String $leaveDayId)
    {
        //
        $year=date("Y");
        $leaveDayBreaks=LeaveDayBreak::orderby('apply_date', 'desc')->get();
        $leaveDayApplies = LeaveDayApply::orderby('apply_date', 'desc')->get();
        $leaveDays = LeaveDay::all();
       
        $l=LeaveDay::find($leaveDayId);
        $s=0;
        $h=0;
        foreach($leaveDayApplies as $data){
            if($data['status']=='managed'&&$data['leave_day_id']==$leaveDayId){
                $s+=$data['should_break'];
            }
        }
        foreach($leaveDayBreaks as $data){
            if($data['status']=='managed'&&$data['leave_day_id']==$leaveDayId){
                $h+=$data['has_break'];
            }
        }
        $l->should_break= $s;
        $l->has_break=$h;
        $l->not_break= $l->should_break- $l->has_break;
        $l->save();
        $leaveDays = LeaveDay::all();
        $events=Event::all();
        $has1=0;
        $has2=0;
        $has3=0;
        $has4=0;
        $has5=0;
        $has6=0;
        $has7=0;
        $has8=0;
        $has9=0;
        $has10=0;
        $has11=0;
        $has12=0;
        
        $half1='';
        $half2='';
        $half3='';
        $half4='';
        $half5='';
        $half6='';
        $half7='';
        $half8='';
        $half9='';
        $half10='';
        $half11='';
        $half12='';

        $day1='';
        $day2='';
        $day3='';
        $day4='';
        $day5='';
        $day6='';
        $day7='';
        $day8='';
        $day9='';
        $day10='';
        $day11='';
        $day12='';
        $days1=[];
        $days2=[];
        $days3=[];
        $days4=[];
        $days5=[];
        $days6=[];
        $days7=[];
        $days8=[];
        $days9=[];
        $days10=[];
        $days11=[];
        $days12=[];

        $halfs1=[];
        $halfs2=[];
        $halfs3=[];
        $halfs4=[];
        $halfs5=[];
        $halfs6=[];
        $halfs7=[];
        $halfs8=[];
        $halfs9=[];
        $halfs10=[];
        $halfs11=[];
        $halfs12=[];

        $i=0;
        $j=0;
        foreach($events as $data){
            if($data['user_id']==$l->user['user_id']&&$data['name']=='休假'&&$data['content']!='0.5天'){
                if(substr($data['date'],0,4)==$year){
                    if(substr($data['date'],5,2)=='01'){
                        $has1++;
                        array_push($days1,substr($data['date'],8,2));
                        for($i=0;$i<count($days1);$i++){
                            for($j =$i+1;$j<count($days1);$j++){
                                if($days1[$j]<$days1[$i]){
                                    $temp=$days1[$j];
                                    $days1[$j]=$days1[$i];
                                    $days1[$i]=$temp;
                                }
                            }
                        }    
                    }
                    else if(substr($data['date'],5,2)=='02'){
                        $has2++;
                        array_push($days2,substr($data['date'],8,2));
                        for($i=0;$i<count($days2);$i++){
                            for($j =$i+1;$j<count($days2);$j++){
                                if($days2[$j]<$days2[$i]){
                                    $temp=$days2[$j];
                                    $days2[$j]=$days2[$i];
                                    $days2[$i]=$temp;
                                }
                            }
                        }    
                    }
                    else if(substr($data['date'],5,2)=='03'){
                        $has3++;
                        array_push($days3,substr($data['date'],8,2));
                        for($i=0;$i<count($days3);$i++){
                            for($j =$i+1;$j<count($days3);$j++){
                                if($days3[$j]<$days3[$i]){
                                    $temp=$days3[$j];
                                    $days3[$j]=$days3[$i];
                                    $days3[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='04'){
                        $has4++;
                        array_push($days4,substr($data['date'],8,2));
                        for($i=0;$i<count($days4);$i++){
                            for($j =$i+1;$j<count($days4);$j++){
                                if($days4[$j]<$days4[$i]){
                                    $temp=$days4[$j];
                                    $days4[$j]=$days4[$i];
                                    $days4[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='05'){
                        $has5++;
                        array_push($days5,substr($data['date'],8,2));
                        for($i=0;$i<count($days5);$i++){
                            for($j =$i+1;$j<count($days5);$j++){
                                if($days5[$j]<$days5[$i]){
                                    $temp=$days5[$j];
                                    $days5[$j]=$days5[$i];
                                    $days5[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='06'){
                        $has6++;
                        array_push($days6,substr($data['date'],8,2));
                        for($i=0;$i<count($days6);$i++){
                            for($j =$i+1;$j<count($days6);$j++){
                                if($days6[$j]<$days6[$i]){
                                    $temp=$days6[$j];
                                    $days6[$j]=$days6[$i];
                                    $days6[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='07'){
                        $has7++;
                        array_push($days7,substr($data['date'],8,2));
                        for($i=0;$i<count($days7);$i++){
                            for($j =$i+1;$j<count($days7);$j++){
                                if($days7[$j]<$days7[$i]){
                                    $temp=$days7[$j];
                                    $days7[$j]=$days7[$i];
                                    $days7[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='08'){
                        $has8++;
                        array_push($days8,substr($data['date'],8,2));
                        for($i=0;$i<count($days8);$i++){
                            for($j =$i+1;$j<count($days8);$j++){
                                if($days8[$j]<$days8[$i]){
                                    $temp=$days8[$j];
                                    $days8[$j]=$days8[$i];
                                    $days8[$i]=$temp;
                                }
                            }
                        }               
                    }
                    else if(substr($data['date'],5,2)=='09'){
                        $has9++;
                        array_push($days9,substr($data['date'],8,2));
                        for($i=0;$i<count($days9);$i++){
                            for($j =$i+1;$j<count($days9);$j++){
                                if($days9[$j]<$days9[$i]){
                                    $temp=$days9[$j];
                                    $days9[$j]=$days9[$i];
                                    $days9[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='10'){
                        $has10++;
                        array_push($days10,substr($data['date'],8,2));
                        for($i=0;$i<count($days10);$i++){
                            for($j =$i+1;$j<count($days10);$j++){
                                if($days10[$j]<$days10[$i]){
                                    $temp=$days10[$j];
                                    $days10[$j]=$days10[$i];
                                    $days10[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='11'){
                        $has11++;
                        array_push($days11,substr($data['date'],8,2));
                        for($i=0;$i<count($days11);$i++){
                            for($j =$i+1;$j<count($days11);$j++){
                                if($days11[$j]<$days11[$i]){
                                    $temp=$days11[$j];
                                    $days11[$j]=$days11[$i];
                                    $days11[$i]=$temp;
                                }
                            }
                        }

                    }
                    else if(substr($data['date'],5,2)=='12'){
                        $has12++;
                        array_push($days12,substr($data['date'],8,2));
                        for($i=0;$i<count($days12);$i++){
                            for($j =$i+1;$j<count($days12);$j++){
                                if($days12[$j]<$days12[$i]){
                                    $temp=$days12[$j];
                                    $days12[$j]=$days12[$i];
                                    $days12[$i]=$temp;
                                }
                            }
                        }

                    }
                }
            }
            else if($data['user_id']==$l->user['user_id']&&$data['name']=='休假'&&$data['content']=='0.5天'){
                if(substr($data['date'],0,4)==$year){
                    if(substr($data['date'],5,2)=='01'){
                        $has1+=0.5;
                        array_push($halfs1,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs1);$i++){
                            for($j =$i+1;$j<count($halfs1);$j++){
                                if($halfs1 [$j]<$halfs1[$i]){
                                    $temp=$halfs1[$j];
                                    $halfs1[$j]=$halfs1[$i];
                                    $halfs1[$i]=$temp;
                                }
                            }
                        }    
                    }
                    else if(substr($data['date'],5,2)=='02'){
                        $has2+=0.5;
                        array_push($halfs2,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs2);$i++){
                            for($j =$i+1;$j<count($halfs2);$j++){
                                if($halfs2 [$j]<$halfs2[$i]){
                                    $temp=$halfs2[$j];
                                    $halfs2[$j]=$halfs2[$i];
                                    $halfs2[$i]=$temp;
                                }
                            }
                        }   
                    }
                    else if(substr($data['date'],5,2)=='03'){
                        $has3+=0.5;
                        array_push($halfs3,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs3);$i++){
                            for($j =$i+1;$j<count($halfs3);$j++){
                                if($halfs3 [$j]<$halfs3[$i]){
                                    $temp=$halfs3[$j];
                                    $halfs3[$j]=$halfs3[$i];
                                    $halfs3[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='04'){
                        $has4+=0.5;
                        array_push($halfs4,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs4);$i++){
                            for($j =$i+1;$j<count($halfs4);$j++){
                                if($halfs4 [$j]<$halfs4[$i]){
                                    $temp=$halfs4[$j];
                                    $halfs4[$j]=$halfs4[$i];
                                    $halfs4[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='05'){
                        $has5+=0.5;
                        array_push($halfs5,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs5);$i++){
                            for($j =$i+1;$j<count($halfs5);$j++){
                                if($halfs5 [$j]<$halfs5[$i]){
                                    $temp=$halfs5[$j];
                                    $halfs5[$j]=$halfs5[$i];
                                    $halfs5[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='06'){
                        $has6+=0.5;
                        array_push($halfs6,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs6);$i++){
                            for($j =$i+1;$j<count($halfs6);$j++){
                                if($halfs6 [$j]<$halfs6[$i]){
                                    $temp=$halfs6[$j];
                                    $halfs6[$j]=$halfs6[$i];
                                    $halfs6[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='07'){
                        $has7+=0.5;
                        array_push($halfs7,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs7);$i++){
                            for($j =$i+1;$j<count($halfs7);$j++){
                                if($halfs7 [$j]<$halfs7[$i]){
                                    $temp=$halfs7[$j];
                                    $halfs7[$j]=$halfs7[$i];
                                    $halfs7[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='08'){
                        $has8+=0.5;
                        array_push($halfs8,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs8);$i++){
                            for($j =$i+1;$j<count($halfs8);$j++){
                                if($halfs8 [$j]<$halfs8[$i]){
                                    $temp=$halfs8[$j];
                                    $halfs8[$j]=$halfs8[$i];
                                    $halfs8[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='09'){
                        $has9+=0.5;
                        array_push($halfs9,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs9);$i++){
                            for($j =$i+1;$j<count($halfs9);$j++){
                                if($halfs9 [$j]<$halfs9[$i]){
                                    $temp=$halfs9[$j];
                                    $halfs9[$j]=$halfs9[$i];
                                    $halfs9[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='10'){
                        $has10+=0.5;
                        array_push($halfs10,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs10);$i++){
                            for($j =$i+1;$j<count($halfs10);$j++){
                                if($halfs10 [$j]<$halfs10[$i]){
                                    $temp=$halfs10[$j];
                                    $halfs10[$j]=$halfs10[$i];
                                    $halfs10[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='11'){
                        $has11+=0.5;
                        array_push($halfs11,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs11);$i++){
                            for($j =$i+1;$j<count($halfs11);$j++){
                                if($halfs11 [$j]<$halfs11[$i]){
                                    $temp=$halfs11[$j];
                                    $halfs11[$j]=$halfs11[$i];
                                    $halfs11[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='12'){
                        $has12+=0.5;
                        array_push($halfs12,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs12);$i++){
                            for($j =$i+1;$j<count($halfs12);$j++){
                                if($halfs12 [$j]<$halfs12[$i]){
                                    $temp=$halfs12[$j];
                                    $halfs12[$j]=$halfs12[$i];
                                    $halfs12[$i]=$temp;
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach($days1 as $data){
            $day1=$day1.$data.' ';
        }
        foreach($days2 as $data){
            $day2=$day2.$data.' ';
        }
        foreach($days3 as $data){
            $day3=$day3.$data.' ';
        }
        foreach($days4 as $data){
            $day4=$day4.$data.' ';
        }
        foreach($days5 as $data){
            $day5=$day5.$data.' ';
        }
        foreach($days6 as $data){
            $day6=$day6.$data.' ';
        }
        foreach($days7 as $data){
            $day7=$day7.$data.' ';
        }
        foreach($days8 as $data){
            $day8=$day8.$data.' ';
        }
        foreach($days9 as $data){
            $day9=$day9.$data.' ';
        }
        foreach($days10 as $data){
            $day10=$day10.$data.' ';
        }
        foreach($days11 as $data){
            $day11=$day11.$data.' ';
        }
        foreach($days12 as $data){
            $day12=$day12.$data.' ';
        }
        foreach($halfs1 as $data){
            $half1=$half1.$data.' ';
        }
        foreach($halfs2 as $data){
            $half2=$half2.$data.' ';
        }
        foreach($halfs3 as $data){
            $half3=$half3.$data.' ';
        }
        foreach($halfs4 as $data){
            $half4=$half4.$data.' ';
        }
        foreach($halfs5 as $data){
            $half5=$half5.$data.' ';
        }
        foreach($halfs6 as $data){
            $half6=$half6.$data.' ';
        }
        foreach($halfs7 as $data){
            $half7=$half7.$data.' ';
        }
        foreach($halfs8 as $data){
            $half8=$half8.$data.' ';
        }
        foreach($halfs9 as $data){
            $half9=$half9.$data.' ';
        }
        foreach($halfs10 as $data){
            $half10=$half10.$data.' ';
        }
        foreach($halfs11 as $data){
            $half11=$half11.$data.' ';
        }
        foreach($halfs12 as $data){
            $half12=$half12.$data.' ';
        }
        
        $temp = "";
        $breakYears = [];
        $leaveDayBreakYearMonth = LeaveDayBreak::orderby('start_datetime', 'desc')->get();
        foreach ($leaveDayBreakYearMonth as $data) {
            if ($data->leave_day_id == $leaveDayId) {
                $stateYear = 0;

                $temp = substr($data->start_datetime, 0, 4);
                foreach ($breakYears as $breakYear) {
                    if (substr($data->start_datetime, 0, 4) == $breakYear) {
                        $stateYear = 1;
                    }
                }
                if ($stateYear == 0) {
                    array_push($breakYears, substr($data->start_datetime, 0, 4));
                }
            }
        }
        $breakMonths = [];
        foreach ($leaveDayBreakYearMonth as $data) {
            if ($data->leave_day_id == $leaveDayId) {
                $stateMonth = 0;

                $temp = substr($data->start_datetime, 0, 7);
                foreach ($breakMonths as $breakMonth) {
                    if (substr($data->start_datetime, 0, 7) == $breakMonth) {
                        $stateMonth = 1;
                    }
                }
                if ($stateMonth == 0) {
                    array_push($breakMonths, substr($data->start_datetime, 0, 7));
                }
            }
        }

        $temp = "";
        $applyYears = [];
        $leaveDayApplyYearMonth = LeaveDayApply::orderby('apply_date', 'desc')->get();
        foreach ($leaveDayApplyYearMonth as $data) {
            if ($data->leave_day_id == $leaveDayId) {
                $stateYear = 0;

                $temp = substr($data->apply_date, 0, 4);
                foreach ($applyYears as $applyYear) {
                    if (substr($data->apply_date, 0, 4) == $applyYear) {
                        $stateYear = 1;
                    }
                }
                if ($stateYear == 0) {
                    array_push($applyYears, substr($data->apply_date, 0, 4));
                }
            }
        }
        $applyMonths = [];
        foreach ($leaveDayApplyYearMonth as $data) {
            if ($data->leave_day_id == $leaveDayId) {
                $stateMonth = 0;

                $temp = substr($data->apply_date, 0, 7);
                foreach ($applyMonths as $applyMonth) {
                    if (substr($data->apply_date, 0, 7) == $applyMonth) {
                        $stateMonth = 1;
                    }
                }
                if ($stateMonth == 0) {
                    array_push($applyMonths, substr($data->apply_date, 0, 7));
                }
            }
        }

        $months = array("一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月");
        $hasdays =array("一月"=>$has1,"二月"=>$has2,"三月"=>$has3,"四月"=>$has4,"五月"=>$has5,"六月"=>$has6,"七月"=>$has7,"八月"=>$has8,"九月"=>$has9,"十月"=>$has10,"十一月"=>$has11,"十二月"=>$has12);
        $halfdays=array("一月"=>$half1,"二月"=>$half2,"三月"=>$half3,"四月"=>$half4,"五月"=>$half5,"六月"=>$half6,"七月"=>$half7,"八月"=>$half8,"九月"=>$half9,"十月"=>$half10,"十一月"=>$half11,"十二月"=>$half12);
        $days=array("一月"=>$day1,"二月"=>$day2,"三月"=>$day3,"四月"=>$day4,"五月"=>$day5,"六月"=>$day6,"七月"=>$day7,"八月"=>$day8,"九月"=>$day9,"十月"=>$day10,"十一月"=>$day11,"十二月"=>$day12);
        return view('pm.leaveDay.indexLeaveDay',["year"=> $year,"days"=>$days,"halfdays"=>$halfdays,"hasdays"=>$hasdays,"months"=>$months,"leaveDays" => $leaveDays,"leaveDayApplies" => $leaveDayApplies,"leaveDayBreaks" => $leaveDayBreaks,"leaveDayId"=>$leaveDayId,'breakMonths'=>$breakMonths,'breakYears'=>$breakYears,'applyMonths'=>$applyMonths,'applyYears'=>$applyYears]);
    }
    public function store(Request $request)
    {
        //
        
        
        $leaveDay_ids = LeaveDay::select('leave_day_id')->get()->map(function($leaveDay) { return $leaveDay->leaveDay_id; })->toArray();
        $newId = RandomId::getNewId($leaveDay_ids);

        $post = LeaveDay::create([
            'leave_day_id' => $newId,
            'user_id' => \Auth::user()->user_id
           
        ]);

        return redirect()->route('home.index');
    }
    public function show(String $id,String $year)
    {
        $leaveDayBreaks=LeaveDayBreak::all();
        $leaveDayApplies = LeaveDayApply::all();
       
        $l=LeaveDay::find($id);
        $s=0;
        $h=0;
        foreach($leaveDayApplies as $data){
            if($data['status']=='managed'&&$data['leave_day_id']==$id){
                $s+=$data['should_break'];
            }
        }
        foreach($leaveDayBreaks as $data){
            if($data['status']=='managed'&&$data['leave_day_id']==$id){
                $h+=$data['has_break'];
            }
        }
        $l->should_break= $s;
        $l->has_break=$h;
        $l->not_break= $l->should_break- $l->has_break;
        $l->save();
        $leaveDays = LeaveDay::all();
        $events=Event::all();
        $has1=0;
        $has2=0;
        $has3=0;
        $has4=0;
        $has5=0;
        $has6=0;
        $has7=0;
        $has8=0;
        $has9=0;
        $has10=0;
        $has11=0;
        $has12=0;
        
        $half1='';
        $half2='';
        $half3='';
        $half4='';
        $half5='';
        $half6='';
        $half7='';
        $half8='';
        $half9='';
        $half10='';
        $half11='';
        $half12='';

        $day1='';
        $day2='';
        $day3='';
        $day4='';
        $day5='';
        $day6='';
        $day7='';
        $day8='';
        $day9='';
        $day10='';
        $day11='';
        $day12='';
        
        $days1=[];
        $days2=[];
        $days3=[];
        $days4=[];
        $days5=[];
        $days6=[];
        $days7=[];
        $days8=[];
        $days9=[];
        $days10=[];
        $days11=[];
        $days12=[];

        $halfs1=[];
        $halfs2=[];
        $halfs3=[];
        $halfs4=[];
        $halfs5=[];
        $halfs6=[];
        $halfs7=[];
        $halfs8=[];
        $halfs9=[];
        $halfs10=[];
        $halfs11=[];
        $halfs12=[];

        $i=0;
        $j=0;
        foreach($events as $data){
            if($data['user_id']==$l->user['user_id']&&$data['name']=='休假'&&$data['content']!='0.5天'){
                if(substr($data['date'],0,4)==$year){
                    if(substr($data['date'],5,2)=='01'){
                        $has1++;
                        array_push($days1,substr($data['date'],8,2));
                        for($i=0;$i<count($days1);$i++){
                            for($j =$i+1;$j<count($days1);$j++){
                                if($days1[$j]<$days1[$i]){
                                    $temp=$days1[$j];
                                    $days1[$j]=$days1[$i];
                                    $days1[$i]=$temp;
                                }
                            }
                        }    
                    }
                    else if(substr($data['date'],5,2)=='02'){
                        $has2++;
                        array_push($days2,substr($data['date'],8,2));
                        for($i=0;$i<count($days2);$i++){
                            for($j =$i+1;$j<count($days2);$j++){
                                if($days2[$j]<$days2[$i]){
                                    $temp=$days2[$j];
                                    $days2[$j]=$days2[$i];
                                    $days2[$i]=$temp;
                                }
                            }
                        }    
                    }
                    else if(substr($data['date'],5,2)=='03'){
                        $has3++;
                        array_push($days3,substr($data['date'],8,2));
                        for($i=0;$i<count($days3);$i++){
                            for($j =$i+1;$j<count($days3);$j++){
                                if($days3[$j]<$days3[$i]){
                                    $temp=$days3[$j];
                                    $days3[$j]=$days3[$i];
                                    $days3[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='04'){
                        $has4++;
                        array_push($days4,substr($data['date'],8,2));
                        for($i=0;$i<count($days4);$i++){
                            for($j =$i+1;$j<count($days4);$j++){
                                if($days4[$j]<$days4[$i]){
                                    $temp=$days4[$j];
                                    $days4[$j]=$days4[$i];
                                    $days4[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='05'){
                        $has5++;
                        array_push($days5,substr($data['date'],8,2));
                        for($i=0;$i<count($days5);$i++){
                            for($j =$i+1;$j<count($days5);$j++){
                                if($days5[$j]<$days5[$i]){
                                    $temp=$days5[$j];
                                    $days5[$j]=$days5[$i];
                                    $days5[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='06'){
                        $has6++;
                        array_push($days6,substr($data['date'],8,2));
                        for($i=0;$i<count($days6);$i++){
                            for($j =$i+1;$j<count($days6);$j++){
                                if($days6[$j]<$days6[$i]){
                                    $temp=$days6[$j];
                                    $days6[$j]=$days6[$i];
                                    $days6[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='07'){
                        $has7++;
                        array_push($days7,substr($data['date'],8,2));
                        for($i=0;$i<count($days7);$i++){
                            for($j =$i+1;$j<count($days7);$j++){
                                if($days7[$j]<$days7[$i]){
                                    $temp=$days7[$j];
                                    $days7[$j]=$days7[$i];
                                    $days7[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='08'){
                        $has8++;
                        array_push($days8,substr($data['date'],8,2));
                        for($i=0;$i<count($days8);$i++){
                            for($j =$i+1;$j<count($days8);$j++){
                                if($days8[$j]<$days8[$i]){
                                    $temp=$days8[$j];
                                    $days8[$j]=$days8[$i];
                                    $days8[$i]=$temp;
                                }
                            }
                        }               
                    }
                    else if(substr($data['date'],5,2)=='09'){
                        $has9++;
                        array_push($days9,substr($data['date'],8,2));
                        for($i=0;$i<count($days9);$i++){
                            for($j =$i+1;$j<count($days9);$j++){
                                if($days9[$j]<$days9[$i]){
                                    $temp=$days9[$j];
                                    $days9[$j]=$days9[$i];
                                    $days9[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='10'){
                        $has10++;
                        array_push($days10,substr($data['date'],8,2));
                        for($i=0;$i<count($days10);$i++){
                            for($j =$i+1;$j<count($days10);$j++){
                                if($days10[$j]<$days10[$i]){
                                    $temp=$days10[$j];
                                    $days10[$j]=$days10[$i];
                                    $days10[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='11'){
                        $has11++;
                        array_push($days11,substr($data['date'],8,2));
                        for($i=0;$i<count($days11);$i++){
                            for($j =$i+1;$j<count($days11);$j++){
                                if($days11[$j]<$days11[$i]){
                                    $temp=$days11[$j];
                                    $days11[$j]=$days11[$i];
                                    $days11[$i]=$temp;
                                }
                            }
                        }

                    }
                    else if(substr($data['date'],5,2)=='12'){
                        $has12++;
                        array_push($days12,substr($data['date'],8,2));
                        for($i=0;$i<count($days12);$i++){
                            for($j =$i+1;$j<count($days12);$j++){
                                if($days12[$j]<$days12[$i]){
                                    $temp=$days12[$j];
                                    $days12[$j]=$days12[$i];
                                    $days12[$i]=$temp;
                                }
                            }
                        }

                    }
                }
            }
            else if($data['user_id']==$l->user['user_id']&&$data['name']=='休假'&&$data['content']=='0.5天'){
                if(substr($data['date'],0,4)==$year){
                    if(substr($data['date'],5,2)=='01'){
                        $has1+=0.5;
                        array_push($halfs1,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs1);$i++){
                            for($j =$i+1;$j<count($halfs1);$j++){
                                if($halfs1 [$j]<$halfs1[$i]){
                                    $temp=$halfs1[$j];
                                    $halfs1[$j]=$halfs1[$i];
                                    $halfs1[$i]=$temp;
                                }
                            }
                        }    
                    }
                    else if(substr($data['date'],5,2)=='02'){
                        $has2+=0.5;
                        array_push($halfs2,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs2);$i++){
                            for($j =$i+1;$j<count($halfs2);$j++){
                                if($halfs2 [$j]<$halfs2[$i]){
                                    $temp=$halfs2[$j];
                                    $halfs2[$j]=$halfs2[$i];
                                    $halfs2[$i]=$temp;
                                }
                            }
                        }   
                    }
                    else if(substr($data['date'],5,2)=='03'){
                        $has3+=0.5;
                        array_push($halfs3,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs3);$i++){
                            for($j =$i+1;$j<count($halfs3);$j++){
                                if($halfs3 [$j]<$halfs3[$i]){
                                    $temp=$halfs3[$j];
                                    $halfs3[$j]=$halfs3[$i];
                                    $halfs3[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='04'){
                        $has4+=0.5;
                        array_push($halfs4,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs4);$i++){
                            for($j =$i+1;$j<count($halfs4);$j++){
                                if($halfs4 [$j]<$halfs4[$i]){
                                    $temp=$halfs4[$j];
                                    $halfs4[$j]=$halfs4[$i];
                                    $halfs4[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='05'){
                        $has5+=0.5;
                        array_push($halfs5,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs5);$i++){
                            for($j =$i+1;$j<count($halfs5);$j++){
                                if($halfs5 [$j]<$halfs5[$i]){
                                    $temp=$halfs5[$j];
                                    $halfs5[$j]=$halfs5[$i];
                                    $halfs5[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='06'){
                        $has6+=0.5;
                        array_push($halfs6,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs6);$i++){
                            for($j =$i+1;$j<count($halfs6);$j++){
                                if($halfs6 [$j]<$halfs6[$i]){
                                    $temp=$halfs6[$j];
                                    $halfs6[$j]=$halfs6[$i];
                                    $halfs6[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='07'){
                        $has7+=0.5;
                        array_push($halfs7,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs7);$i++){
                            for($j =$i+1;$j<count($halfs7);$j++){
                                if($halfs7 [$j]<$halfs7[$i]){
                                    $temp=$halfs7[$j];
                                    $halfs7[$j]=$halfs7[$i];
                                    $halfs7[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='08'){
                        $has8+=0.5;
                        array_push($halfs8,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs8);$i++){
                            for($j =$i+1;$j<count($halfs8);$j++){
                                if($halfs8 [$j]<$halfs8[$i]){
                                    $temp=$halfs8[$j];
                                    $halfs8[$j]=$halfs8[$i];
                                    $halfs8[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='09'){
                        $has9+=0.5;
                        array_push($halfs9,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs9);$i++){
                            for($j =$i+1;$j<count($halfs9);$j++){
                                if($halfs9 [$j]<$halfs9[$i]){
                                    $temp=$halfs9[$j];
                                    $halfs9[$j]=$halfs9[$i];
                                    $halfs9[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='10'){
                        $has10+=0.5;
                        array_push($halfs10,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs10);$i++){
                            for($j =$i+1;$j<count($halfs10);$j++){
                                if($halfs10 [$j]<$halfs10[$i]){
                                    $temp=$halfs10[$j];
                                    $halfs10[$j]=$halfs10[$i];
                                    $halfs10[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='11'){
                        $has11+=0.5;
                        array_push($halfs11,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs11);$i++){
                            for($j =$i+1;$j<count($halfs11);$j++){
                                if($halfs11 [$j]<$halfs11[$i]){
                                    $temp=$halfs11[$j];
                                    $halfs11[$j]=$halfs11[$i];
                                    $halfs11[$i]=$temp;
                                }
                            }
                        }
                    }
                    else if(substr($data['date'],5,2)=='12'){
                        $has12+=0.5;
                        array_push($halfs12,substr($data['date'],8,2));
                        for($i=0;$i<count($halfs12);$i++){
                            for($j =$i+1;$j<count($halfs12);$j++){
                                if($halfs12 [$j]<$halfs12[$i]){
                                    $temp=$halfs12[$j];
                                    $halfs12[$j]=$halfs12[$i];
                                    $halfs12[$i]=$temp;
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach($days1 as $data){
            $day1=$day1.$data.' ';
        }
        foreach($days2 as $data){
            $day2=$day2.$data.' ';
        }
        foreach($days3 as $data){
            $day3=$day3.$data.' ';
        }
        foreach($days4 as $data){
            $day4=$day4.$data.' ';
        }
        foreach($days5 as $data){
            $day5=$day5.$data.' ';
        }
        foreach($days6 as $data){
            $day6=$day6.$data.' ';
        }
        foreach($days7 as $data){
            $day7=$day7.$data.' ';
        }
        foreach($days8 as $data){
            $day8=$day8.$data.' ';
        }
        foreach($days9 as $data){
            $day9=$day9.$data.' ';
        }
        foreach($days10 as $data){
            $day10=$day10.$data.' ';
        }
        foreach($days11 as $data){
            $day11=$day11.$data.' ';
        }
        foreach($days12 as $data){
            $day12=$day12.$data.' ';
        }
        foreach($halfs1 as $data){
            $half1=$half1.$data.' ';
        }
        foreach($halfs2 as $data){
            $half2=$half2.$data.' ';
        }
        foreach($halfs3 as $data){
            $half3=$half3.$data.' ';
        }
        foreach($halfs4 as $data){
            $half4=$half4.$data.' ';
        }
        foreach($halfs5 as $data){
            $half5=$half5.$data.' ';
        }
        foreach($halfs6 as $data){
            $half6=$half6.$data.' ';
        }
        foreach($halfs7 as $data){
            $half7=$half7.$data.' ';
        }
        foreach($halfs8 as $data){
            $half8=$half8.$data.' ';
        }
        foreach($halfs9 as $data){
            $half9=$half9.$data.' ';
        }
        foreach($halfs10 as $data){
            $half10=$half10.$data.' ';
        }
        foreach($halfs11 as $data){
            $half11=$half11.$data.' ';
        }
        foreach($halfs12 as $data){
            $half12=$half12.$data.' ';
        }
        $temp = "";
        $breakYears = [];
        $leaveDayBreakYearMonth = LeaveDayBreak::orderby('start_datetime', 'desc')->get();
        foreach ($leaveDayBreakYearMonth as $data) {
            if ($data->leave_day_id == $id) {
                $stateYear = 0;

                $temp = substr($data->start_datetime, 0, 4);
                foreach ($breakYears as $breakYear) {
                    if (substr($data->start_datetime, 0, 4) == $breakYear) {
                        $stateYear = 1;
                    }
                }
                if ($stateYear == 0) {
                    array_push($breakYears, substr($data->start_datetime, 0, 4));
                }
            }
        }
        $breakMonths = [];
        foreach ($leaveDayBreakYearMonth as $data) {
            if ($data->leave_day_id == $id) {
                $stateMonth = 0;

                $temp = substr($data->start_datetime, 0, 7);
                foreach ($breakMonths as $breakMonth) {
                    if (substr($data->start_datetime, 0, 7) == $breakMonth) {
                        $stateMonth = 1;
                    }
                }
                if ($stateMonth == 0) {
                    array_push($breakMonths, substr($data->start_datetime, 0, 7));
                }
            }
        }

        $temp = "";
        $applyYears = [];
        $leaveDayApplyYearMonth = LeaveDayApply::orderby('apply_date', 'desc')->get();
        foreach ($leaveDayApplyYearMonth as $data) {
            if ($data->leave_day_id == $id) {
                $stateYear = 0;

                $temp = substr($data->apply_date, 0, 4);
                foreach ($applyYears as $applyYear) {
                    if (substr($data->apply_date, 0, 4) == $applyYear) {
                        $stateYear = 1;
                    }
                }
                if ($stateYear == 0) {
                    array_push($applyYears, substr($data->apply_date, 0, 4));
                }
            }
        }
        $applyMonths = [];
        foreach ($leaveDayApplyYearMonth as $data) {
            if ($data->leave_day_id == $id) {
                $stateMonth = 0;

                $temp = substr($data->apply_date, 0, 7);
                foreach ($applyMonths as $applyMonth) {
                    if (substr($data->apply_date, 0, 7) == $applyMonth) {
                        $stateMonth = 1;
                    }
                }
                if ($stateMonth == 0) {
                    array_push($applyMonths, substr($data->apply_date, 0, 7));
                }
            }
        }

        $months = array("一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月");
        $hasdays =array("一月"=>$has1,"二月"=>$has2,"三月"=>$has3,"四月"=>$has4,"五月"=>$has5,"六月"=>$has6,"七月"=>$has7,"八月"=>$has8,"九月"=>$has9,"十月"=>$has10,"十一月"=>$has11,"十二月"=>$has12);
        $halfdays=array("一月"=>$half1,"二月"=>$half2,"三月"=>$half3,"四月"=>$half4,"五月"=>$half5,"六月"=>$half6,"七月"=>$half7,"八月"=>$half8,"九月"=>$half9,"十月"=>$half10,"十一月"=>$half11,"十二月"=>$half12);
        $days=array("一月"=>$day1,"二月"=>$day2,"三月"=>$day3,"四月"=>$day4,"五月"=>$day5,"六月"=>$day6,"七月"=>$day7,"八月"=>$day8,"九月"=>$day9,"十月"=>$day10,"十一月"=>$day11,"十二月"=>$day12);
        return view('pm.leaveDay.indexLeaveDay',["year"=>$year,"days"=>$days,"halfdays"=>$halfdays,"hasdays"=>$hasdays,"months"=>$months,"leaveDays" => $leaveDays,"leaveDayApplies" => $leaveDayApplies,"leaveDayBreaks" => $leaveDayBreaks,"leaveDayId"=>$id,'breakMonths'=>$breakMonths,'breakYears'=>$breakYears,'applyMonths'=>$applyMonths,'applyYears'=>$applyYears]);
  
    
    }
}
