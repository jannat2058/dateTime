<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();

class getData{


    function getInput(){
        $_SESSION['timeZone']=htmlspecialchars($_POST['timeZone']);

        if (empty($_SESSION['timeZone'])){
            $_SESSION['tzMsg']= "Please select the timezone";
             header('Location: ./index.php');
        }
        //checking if the date is a valid date
        $firstDate = $this->validateDate(htmlspecialchars($_POST['firstDate']),'fDate' );
        $secondDate = $this->validateDate(htmlspecialchars($_POST['secondDate']),'lDate');


        if(($firstDate == $_SESSION['fDate'])&&($secondDate == $_SESSION['lDate'])){
            //echo "<br> at last <br>";
            $result=$this->cal($firstDate,$secondDate);
        }
        else if($firstDate == $_SESSION['fDate']){
             $_SESSION['msg2']= $secondDate;
             header('Location: ./index.php');
        }
        else if($secondDate == $_SESSION['lDate']){
             $_SESSION['msg1']= $firstDate;
             header('Location: ./index.php');
        }
         else {
             $_SESSION['msg1']= $firstDate;
             $_SESSION['msg2']= $secondDate;
             header('Location: ./index.php');
        }


    }//f


    function cal($firstDate,$secondDate){
        echo "Inside cal function: <br>";
        echo "First date is .  $firstDate and second date is: $secondDate <br>";
        echo "Session dates one : ". $_SESSION['fDate'] ." and session dates two is :".$_SESSION['lDate'] ;
        echo "<br><br><br><br><br>";
        //set the default timezone
        date_default_timezone_set($_SESSION['timeZone']);

        //create a datetime
        $dateOne = DateTime::createFromFormat('d/m/Y', $firstDate);
        $dateTwo = DateTime::createFromFormat('d/m/Y', $secondDate);

                /*
                echo '<pre>';
                print_r($dateOne);
                echo '</pre>';
                */

        //calculate the diff
        $dif = $dateOne->diff($dateTwo);
        $days=$dif->days;


        // no of weekdays
        $wDays = $this->weekDays($dateOne,$dateTwo);

        //results
        $result="No of days between ".  $_SESSION['fDate']." and ".$_SESSION['lDate'] ." are: $days days.<br>No of complete weeks between ".  $_SESSION['fDate']." and ".$_SESSION['lDate'] . "are: ". floor($days/7). " complete weeks.<br>No of working days between ". $_SESSION['fDate']." and ".$_SESSION['lDate'] ."two dates are: $wDays weekdays." ;
        $_SESSION['calcReslt']=$result; //save calculated days, weeks, weekdays in session variable


        //convert calculated days into seconds, minutes, hours and years
        if(isset($_POST['convtRes']) && !empty(htmlspecialchars($_POST['convtRes']))){
            // convert days into hour, minutes, seconds and years
             $_SESSION['covtTimeMsg']=$this->convertRes($dif );
        }




        // change defualt time zone to a new time zone
        if(isset($_POST['tzChange']) && !empty(htmlspecialchars($_POST['tzChange']))){
                $_SESSION['timeZoneCh']=htmlspecialchars($_POST['timeZoneCh']);

                $getOffsetDateF = clone $dateOne;  // to calculate offset copy dateOne into another variable as an object
                $getOffsetDateS= clone $dateTwo; // to calculate offset copy dateTwo into another variable as an object

                $addOffsetFirst = clone $dateOne; // ADD the offset seconds to the first date
                $addOffsetSecond = clone $dateTwo; // ADD the offset seconds to the second date

                    $originTz = new DateTimeZone($_SESSION['timeZone']);
                    $newTz = new DateTimeZone( $_SESSION['timeZoneCh']);

                    $getOffsetDateF->setTimezone(new DateTimeZone($_SESSION['timeZoneCh'])); // no need to assign as its passed by reference
                    $getOffsetDateS->setTimezone(new DateTimeZone($_SESSION['timeZoneCh'])); // no need to assign as its passed by reference


                    $offsetF = $originTz->getOffset($dateOne) - $newTz->getOffset($getOffsetDateF);  // returns in seconds
                    $offsetS = $originTz->getOffset($dateTwo) - $newTz->getOffset($getOffsetDateS);  // returns in seconds


                    $valueF = abs($offsetF/(60*60)); //making the negative valus to positive for dateOne
                    $valueS = abs($offsetS/(60*60)); //making the negative valus to positive for dateTwo

                     //store result in session variable
                    $_SESSION['upFirstDate']= $dateOne->format('d/m/Y  h:i a')." in ".$_SESSION['timeZone']. " is now different due to new timezone ".$_SESSION['timeZoneCh']." and Offset time is: ". $valueF." hours <br>";

                    $_SESSION['upSecondDate']= $dateTwo->format('d/m/Y  h:i a')." in ".$_SESSION['timeZone']. " is now different due to new timezone ".$_SESSION['timeZoneCh']." and Offset time is: ". $valueS." hours <br>";



         }
         //goback to the index page with result messages in session variable
        header ('Location:./index.php');

    }//f

      function weekDays ($startDate,$endDate){


            //check which date would be the starting date for DatePeriod function
          if($startDate < $endDate){
              $fromDate = clone $startDate;
              $toDate = clone $endDate;

          }else{
              $toDate = clone $startDate;
              $fromDate = clone $endDate;

          }

            $toDate->add(new DateInterval('P1D'));   // add 1 more day to count till the last day becuase there is no <=


            $counter = new DateInterval('P1D'); // as a counter like i++
            $noOfDayAsDay = new DatePeriod($fromDate, $counter, $toDate); // it will work as a loop. from starting date to end date increment by 1 day


            //an array to calculate weekdays
            $businessDays=[1,2,3,4,5];
            $wDays = 0;


            foreach ($noOfDayAsDay as $day) {
                    //$day->format('N') means; 1=Monday, 2=Tuesday ... 7=Sunday
                    if(in_array($day->format('N'),$businessDays)){ $wDays++;   }

                }//foreach
            return $wDays;
    }//f

      function convertRes($diff){

          /* demo of the $diff obj
                [y] => 162
                [m] => 3
                [d] => 0
                [h] => 0
                [i] => 0
                [s] => 0
                [f] => 0
                [weekday] => 0
                [weekday_behavior] => 0
                [first_last_day_of] => 0
                [invert] => 0
                [days] => 59260
                [special_type] => 0
                [special_amount] => 0
                [have_weekday_relative] => 0
                [have_special_relative] => 0
              */

           if(htmlspecialchars($_POST['convtOption'])==1){
               //seconds
               //1day = 24 *60 *60 seconds
                $sec=($diff->days)*(24*60*60);
                $convtMsg='Total seconds between two dates are: '.$sec.' seconds';
                return $convtMsg;

            }else if(htmlspecialchars($_POST['convtOption'])==2){
                //minutes
                $mint=($diff->days)*(24*60);
                $convtMsg='Total minutes between two dates are: '.$mint .' minutes';
                return $convtMsg;

              }else if(htmlspecialchars($_POST['convtOption'])==3){
                //hours
                 $hour=($diff->days)*24;
                $convtMsg='Total hours between two dates are: '.$hour.' hours';
                return $convtMsg;

              }else if(htmlspecialchars($_POST['convtOption'])==4){
                //years
                $str='';
                $y=$diff->y;
                $m=$diff->m;
                $d=$diff->d;
                $ago=$diff->invert; // past or future time
                //echo "y-.$y.m-.$m.d-.$d";
                if($y) $str.=$y.' year ';
                if($m) $str.=$m.' month ';
                if($d) $str.=$d.' day ';
                if($ago) $str.= ' ago';
                if(!$ago) $str.=' from now.';

                $convtMsg=$str;
                return $convtMsg;
            }
         }//f



    function validateDate($date,$sesDate){
        $msg='';
        $date = trim($date);
        $date = stripslashes($date);
        $date = htmlspecialchars($date);


       if(empty($date)){
             $msg='Date can not be empty!';
             return $msg;
         }
        else
            {
                // $date = dd/mm/yyyy
                $day='';
                $split='';
                $split = explode( '/', $date );

                $count=count($split);

                if($count==3) {  // means it got day , month and year in the input field seperated by /

                    //check if its integer
                        for($i=0;$i<$count;$i++){
                                $upDay[$i]=abs((int)$split[$i]); //to fix alphanumeric problem and get the absolute value, remove negetive
                                $day.=$upDay[$i];
                            if($i!=2)$day.="/";
                            }//for

                    //echo " <br> new date is $day";
                     $split = explode( '/', $day );
                   // print_r($split);

                            //check if year is 4 digits
                            if(!empty($split[2]) && strlen($split[2])==4){
                                    $flag=checkdate( $split[1], $split[0], $split[2] ); //checkdate() function takes parameter as month, date and year
                                    if($flag) {
                                            $_SESSION[$sesDate]=$day;
                                            return $day;
                                        }else {
                                            //when checkdate() returns false
                                            $msg =  $date." is a wrong date. Please enter a valid date as dd/mm/yyyy format!";
                                            return $msg;
                                         }
                                }else {
                                    // when year is not 4 digits
                                    $msg = $date." Please enter 4 digits in year as dd/mm/yyyy format!";
                                    return $msg;
                            }//else
                }else{
                   // when $count!=3
                    $msg = $date." is not a date. Please enter a valid date as dd/mm/yyyy format!";
                    return $msg;
               }//else
            }//else
   }//f
 }//c


  $objDate = new getData();
  $objDate->getInput(); //initiate calling



?>
