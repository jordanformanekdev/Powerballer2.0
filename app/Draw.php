<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    public function getCurrentDraw()
    {
        //Get the most current draw
        $maxId = DB::table('draws')->max('id');

        //Find draw by ID
        $draw = DB::table('draws')->select('*')->where('id', $maxId)->first();

        //Format draw for controller use
        $currentDraw = json_decode(json_encode($draw),true);

        return $currentDraw;

    }

    public function getNextDraw($id)
    {

        //Get the ID for the next draw
        $nextId = $this->_getIncrement($id, 'Next');

        //Find draw by ID
        $draw = DB::table('draws')->select('*')->where('id', $nextId)->first();

        //Format draw for controller use
        $currentDraw = json_decode(json_encode($draw),true);

        return $currentDraw;

    }

    public function getPrevDraw($id)
    {

        //Get the ID for the previous draw
        $prevId = $this->_getIncrement($id, 'Prev');

        //Find draw by ID
        $draw = DB::table('draws')->select('*')->where('id', $prevId)->first();

        //Format draw for controller use
        $currentDraw = json_decode(json_encode($draw),true);

        return $currentDraw;

    }

    ///////////////////////////////////////////
    //                                       //
    // Draw Controller private functions     //
    // (Will eventually be moved to library) //
    //                                       //
    ///////////////////////////////////////////

    private function _getIncrement($id, $type)
    {
        //Find the current Draw ID
        $maxId = DB::table('draws')->max('id');

        if($type == 'Next'){

            //If we want the next ID
            $value = ($id == $maxId ? 1 : $id + 1);

        }else{

            //If we want the previous ID
            $value = ($id == 1 ?  $maxId : $id -1);
        }

        return $value;
    }
}
