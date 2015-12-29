<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class PopMiddlewear
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Get the current date for seeing draw table
        $date = $date = date_create();
        $date = $date->format('Y-m-d');

        //Get last draw day
        $lastUpdate = DB::table('draws')->max('draw_date');

        //Check to see if we need to seed the draws tables
        if(!file_exists("../public/DrawFiles/lottoSeed.txt")){

            //Executes CURL method to create seed for drawings
            $this->_executeCurl();

            //Create appropriately ordered array for database population
            $draws = $this->_seedDrawsTable();

        }

        //Execute CURL method for update file
        $updateStatus = $this->_updateStatus($lastUpdate);

        //Check to see if we need to update the draws table
        if($updateStatus){

            //Executes CURL method to create seed for drawings
            $this->_executeCurl($date);

            //Create appropriately ordered array for database population
            $draws = $this->_seedDrawsTable($date, $lastUpdate);

        }

        //If we need to seed the draws table or we have an update to perform
        if(isset($draws)){
            //Populate database
            foreach($draws as $draw){
                DB::table('draws')->insert(
                    ['draw_date' => $draw[0],
                        'day' => $draw[1],
                        'wbOne' => $draw[2],
                        'wbTwo' => $draw[3],
                        'wbThree' => $draw[4],
                        'wbFour' => $draw[5],
                        'wbFive' => $draw[6],
                        'powerball' => $draw[7],
                        'powerplay' => $draw[8],
                        'updated_at' => $date
                    ]);
            }
        }


        return $next($request);
    }

    private function _updateStatus($lastUpdate)
    {
        //Get last draw day
        $lastDrawDay = DB::table('draws')->max('day');

        //Get current Timestamp
        $currentTimestamp = strtotime('now');

        //Get timestamp from last update
        $lastUpdateTimestamp = strtotime($lastUpdate);

        //Get span between last update and now
        $spanCheck = $currentTimestamp - $lastUpdateTimestamp;

        //Check to see if a new draw has taken place
        if($lastDrawDay == "Saturday" && $spanCheck > 431999){
            return true;
        }elseif($lastDrawDay == "Wednesday" && $spanCheck > 345599) {
            return true;
        }else{
            return false;
        }

    }

    private function _executeCurl($date = false)
    {
        //Initialize CURL request
        $ch = curl_init("http://www.powerball.com/powerball/winnums-text.txt");

        if($date){
            //Create seed file for storing winning powerball draws
            $fp = fopen("../public/DrawFiles/lotto(" . $date . ").txt", "w");
        }else{
            //Create update file for storing winning powerball draws
            $fp = fopen("../public/DrawFiles/lottoSeed.txt", "w");
        }

        //Set CURL option for output to file
        curl_setopt($ch, CURLOPT_FILE, $fp);

        //Execute CURL
        curl_exec($ch);

        //Close CURL
        curl_close($ch);

        //Close file
        fclose($fp);
    }

    private function _seedDrawsTable($date = false, $lastUpdate = false)
    {
        //File where draws are saved
        if($date){
            //Create seed file for storing winning powerball draws
            $file = fopen("../public/DrawFiles/lotto(" . $date . ").txt", "r");
        }else{
            $file = fopen("../public/DrawFiles/lottoSeed.txt", "r");
        }

        //Array containing all draws in reverse order for database population
        $drawArray = array();

        //Index for draw array
        $index = 0;

        //Populate draws array
        while(!feof($file)){

            //Initialize temporary draw array
            $draw = array();

            //Read line from file
            $line = trim(fgets($file));
            $lineArray = explode("  ", $line);

            //Check to make sure end of file doesn't have blank line
            if($line == ''){
                break;
            }

            //Handle file where power plays are missing
            if(count($lineArray) == 8){
                //Get powerplay if it exists in file
                $powerPlay = $lineArray[7];
            }else{
                //Set powerplay to zero if it doesn't exist
                $powerPlay = 0;
            }

            //Convert draw date to date time object
            $time = strtotime($lineArray[0]);

            //Format draw date
            $drawDate = date('Y-m-d',$time);

            //Get day that drawing occurred
            $drawDay = date('l', $time);

            //Only get as many draws from update file as needed
            if($lastUpdate == $drawDate){
                break;
            }

            //Set temporary draw array with data for database
            if($lineArray[0] != "Draw Date"){
                $draw[0] = $drawDate;
                $draw[1] = $drawDay;
                $draw[2] = $lineArray[1];
                $draw[3] = $lineArray[2];
                $draw[4] = $lineArray[3];
                $draw[5] = $lineArray[4];
                $draw[6] = $lineArray[5];
                $draw[7] = $lineArray[6];
                $draw[8] = $powerPlay;

                //Add draws to drawArray to be added to database
                $drawArray[$index] = $draw;

                //Increment index
                $index++;
            }
        }

        //Reverse draw array to populate database in correct order
        $drawArray = array_reverse($drawArray);

        //Close file
        fclose($file);
        return $drawArray;
    }
}
