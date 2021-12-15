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
class SelectMonth {

    /**
     * Constructor
     */
    private $currentYear=0;
    private $currentId='';
    private $currentMonths=[];
    private $currentLeave=[];
    private $currentSelect = '';
    private $currentMonth ='';
    public function show($year,$id,$months,$leave_month,$month) {
        $this->currentId=$id;
        $this->currentYear=$year;
        $this->currentMonths = $months;
        $this->currentLeave = $leave_month;
        $this->currentMonth = $month;
        return
        '<select type="text"  name="select-month" class="rounded-pill form-control" onchange="location = this.value;">'.
            '<option value="00"></option>'.
            $this->_createSelect().
        '</select>';
    }

    
    private function _createSelect(){
        foreach($this->currentMonths as $key => $data){
            if($this->currentLeave[$key] > 0){
                if($key == $this->currentMonth){
                    $this->currentSelect = $this->currentSelect . '<option selected="selected" value='.$key.'>'.$key.'</option>';
                }
                else {
                    $this->currentSelect = $this->currentSelect . '<option value='.$key.'>'.$key.'</option>';
                }
                
            }
        }
        return $this->currentSelect;
    }
}   
?>