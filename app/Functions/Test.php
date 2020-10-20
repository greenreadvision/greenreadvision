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
class Test {

    /**
     * Constructor
     */
    private $currentYear=0;
    private $currentId='';
    public function show($year=null,$id) {
        if(null==$year&&isset($_GET['year'])){

            $year = $_GET['year'];

        }else if(null==$year){

            $year = date("Y",time());

        }
        $this->currentId=$id;
        $this->currentYear=$year;
        return
        '<div >
            <div class="box">'.
                $this->_createNavi().
            '</div>
        </div>';
    }

    
    private function _createNavi(){

        $nextYear = intval($this->currentYear)+1;
        $preYear = intval($this->currentYear)-1;

        return
        '<div class="col-md d-flex text-center justify-content-between align-items-center my-2">'.
            // '<a class="prev" style="float:left;" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
            // '<a class="next" style="float:right;" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '<a class="btn" href="'.route('leaveDay.show',['id'=>$this->currentId,'year' => $preYear]).'"><i class="fas fa-angle-double-left" style="font-size:1.5rem;width:2rem"></i></a>'.
            '<h2 class="title"> '.$this->currentYear.' </h1>'.
            '<a class="btn" href="'.route('leaveDay.show', ['id'=>$this->currentId,'year' => $nextYear]).'"><i class="fas fa-angle-double-right" style="font-size:1.5rem;width:2rem"></i></a>'.
        '</div>';
    }
}   