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

class Test
{

    /**
     * Constructor
     */
    private $currentYear = 0;
    private $currentId = '';
    public function show($year = null, $id,$status)
    {
        if (null == $year && isset($_GET['year'])) {

            $year = $_GET['year'];
        } else if (null == $year) {

            $year = date("Y", time());
        }
        $this->currentId = $id;
        $this->currentYear = $year;
        return
            '<div >
            <div class="box">' .
            $this->_createNavi($status) .
            '</div>
        </div>';
    }


    private function _createNavi($status)
    {

        $nextYear = intval($this->currentYear) + 1;
        $preYear = intval($this->currentYear) - 1;

        return
            '<div  class="d-flex  justify-content-between align-items-center">' .
            '<a class="btn icon-gray py-0" href="' . route('leaveDay.show', ['id' => $this->currentId, 'year' => $preYear.'-'.$status]) . '"><i class="fas fa-angle-left" style="font-size:1.5rem;width:2rem"></i></a>' .
            '<h4 class="title text-darkBlue" style="cursor: default;"> ' . $this->currentYear . ' </h4>' .
            '<a class="btn icon-gray py-0" href="' . route('leaveDay.show', ['id' => $this->currentId, 'year' => $nextYear.'-'.$status]) . '"><i class="fas fa-angle-right" style="font-size:1.5rem;width:2rem"></i></a>' .
            '</div>';
    }
}
