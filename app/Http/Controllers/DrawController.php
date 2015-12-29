<?php

namespace App\Http\Controllers;

use App\Draw;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\DrawsRepository;

class DrawController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var DrawsRepository
     */
    protected $draws;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(DrawsRepository $draws)
    {
        $this->middleware('auth');

        $this->draws = $draws;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        //Get all data to be sent to the view
        $draw = new Draw;

        //Get current draw from the model
        $currentDraw = $draw->getCurrentDraw();

        $data = $this->_setDrawData($currentDraw);

        return View::make('draws.index')->with('data', $data);
    }

    /**
     * Displays the user's next draw.
     *
     * @param  int  $id
     * @return Response
     */
    public function next($id)
    {
        //Get all data to be sent to the view
        $draw = new Draw;

        //Get current draw from the model
        $currentDraw = $draw->getNextDraw($id);

        //Get draw data formatted for view
        $data = $this->_setDrawData($currentDraw);

        return View::make('draws.index')->with('data', $data);
    }

    /**
     * Displays the user's previous draw.
     *
     * @param  int  $id
     * @return Response
     */
    public function prev($id)
    {
        //Get all data to be sent to the view
        $draw = new Draw;

        //Get current draw from the model
        $currentDraw = $draw->getPrevDraw($id);

        //Get draw data formatted for view
        $data = $this->_setDrawData($currentDraw);

        return View::make('draws.index')->with('data', $data);
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request $request
     * @return View
     */
    public function drawUpload(Request $request)
    {
        return view('draws.drawUpload', [
            'draws' => $this->draws->fetchAll()
        ]);
    }


    ///////////////////////////////////////////
    //                                       //
    // Draw Controller private functions     //
    // (Will eventually be moved to library) //
    //                                       //
    ///////////////////////////////////////////

    /*
     * Returns the extracted date from any draw
     *
     * @param  Draw $draw
     * @return Date
     *
     */
    private function _getDrawDate($draw)
    {
        //Date that draw occurred
        $drawDate = $draw['draw_date'];

        return $drawDate;
    }

    /*
     * Returns an array for the x and y axis values
     * for ball grids according to the dates they were drawn
     *
     * @param Date $drawDate
     * @param String $color
     *
     * @return Array
     *
     */

    private function _getMatrixVal($drawDate, $color){

        //White ball matrix value
        $wVal = 0;

        //White ball matrix size
        $wSize = 0;

        //Determine the matrix style for White balls;
        if (strtotime($drawDate) >= strtotime('2015-10-07')) {
            $wVal = ($color == 'white' ? 14 : 6);
            $wSize = ($color == 'white' ? 71 : 31);
        } elseif (strtotime($drawDate) >= strtotime('2009-01-07') && strtotime($drawDate) < strtotime('2015-10-07')) {
            $wVal = ($color == 'white' ? 12 : 7);
            $wSize = ($color == 'white' ? 61 : 36);
        } elseif (strtotime($drawDate) >= strtotime('2002-10-09') && strtotime($drawDate) < strtotime('2009-01-07')) {
            $wVal = 11;
            $wSize = 55;
        } elseif (strtotime($drawDate) < strtotime('2002-10-09')) {
            $wVal = 10;
            $wSize = 51;
        }

        //Set Matrix Values in array
        $matrixVals['wVal'] = $wVal;
        $matrixVals['wSize'] = $wSize;

        return $matrixVals;
    }

    /*
     * Returns an array of five white balls that are drawn
     *
     * @param Draw $draw
     *
     * @return Array
     *
     */
    private function _getWhiteBalls($draw)
    {
        $whiteBalls = array();
        $whiteBalls['wbOne'] = $draw['wbOne'];
        $whiteBalls['wbTwo'] = $draw['wbTwo'];
        $whiteBalls['wbThree'] = $draw['wbThree'];
        $whiteBalls['wbFour'] = $draw['wbFour'];
        $whiteBalls['wbFive'] = $draw['wbFive'];

        return $whiteBalls;
    }

    /*
     * Returns array of data associated with draw
     * formatted to be used in view
     *
     * @param Draw $draw
     *
     * @return Array
     *
     */
    private function _setDrawData($draw)
    {
        //Create array of white balls for draw
        $whiteBalls = $this->_getWhiteBalls($draw);

        //Get the date the draw took place
        $drawDate = $this->_getDrawDate($draw);

        //Get the matrix values seed and size seed
        $wMatrixVals = $this->_getMatrixVal($drawDate, 'white');

        //Get the matrix values seed and size seed
        $rMatrixVals = $this->_getMatrixVal($drawDate, 'red');

        //Set array to be passed to the draw info panel
        $drawInfo = array();
        $drawInfo['Draw ID'] = $draw['id'];
        $drawInfo['Draw Day'] = $draw['day'];
        $drawInfo['Draw Date'] = $drawDate;
        $drawInfo['Power Play'] = $draw['powerplay'];


        //Set array to be passed to the white ball matrix
        $whiteBallMatrix = array();
        $whiteBallMatrix['whiteBalls'] = $whiteBalls;
        $whiteBallMatrix['wVal'] = $wMatrixVals['wVal'];
        $whiteBallMatrix['wSize'] = $wMatrixVals['wSize'];

        //Set array to be passed to the red ball matrix
        $redBallMatrix = array();
        $redBallMatrix['powerball'] = $draw['powerball'];
        $redBallMatrix['wVal'] = $rMatrixVals['wVal'];
        $redBallMatrix['wSize'] = $rMatrixVals['wSize'];

        //Set data array to be sent to the view
        $data = array();
        $data['drawInfo'] = $drawInfo;
        $data['whiteBallMatrix'] = $whiteBallMatrix;
        $data['redBallMatrix'] = $redBallMatrix;

        return $data;
    }

}
