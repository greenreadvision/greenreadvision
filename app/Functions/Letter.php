<?php

/**
 *@author  Xu Ding
 *@email   thedilab@gmail.com
 *@website http://www.StarTutorial.com
 **/

use App\Letters;

class Letter
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }

    public function getLetter(){
        $letters =\Auth::user()->letters;
        $i = 0;
        foreach($letters as $letter){
            if($letter->status == 'not_read'){
                $i++;
            }
        }

        return $i;
    }
   
}
