<?php
/* http://php.net/manual/en/datetime.settimezone.php */
 session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Simple Datetime calculation</title>
     <style>
         *{
             font-family: Arial, Helvetica;
             font-size: 14px;
             color:#666;
             line-height:16.9px;
         }
         body{
             margin:5% 10%;
             background:#fffffb;
         }
         h1{

             font-family: Georgia;
             font-size: 24px;
         }
        span{
            color:red;
         }
         .lb{
             width:220px;
             text-align:right;
             display:inline-block;

         }
         input[type='text']{
             width:250px;
         }

         input[type='submit']{
             width:130px;
             margin-left:25%;
             padding:10px;
             border-radius: 5px;
             background: #EEE;
         }
         .divStyle{

             color:#b38808;
         }
         .divBlock{
             width:600px;
             border:2px solid #fa0;
             margin: 20px 0;
             padding: 5px;
         }

    </style>
</head>

<body>
<h1> Simple DateTime Calculation</h1>
<form action="action.php" method="post">
   <div class='divBlock'>
         <p>
           <label class='lb'>Please select the timezone </label>
            <select name="timeZone">
             <?php
                    $tz=DateTimeZone::listIdentifiers();
                    foreach($tz as $key):
                             if (isset($_SESSION['timeZone']) && strlen($_SESSION['timeZone'])){
                                echo  "<option value='".$_SESSION['timeZone']."' selected>". $_SESSION['timeZone']."</option>";
                             }
                   ?>
                        <option value='<?php echo $key;?>'> <?php echo $key;?></option>
                <?php
                    endforeach;
                ?>
             </select>
        </p>
        <p>
            <label class='lb'>Please enter the first date:</label>

            <?php
                if(isset($_SESSION['msg1']) && strlen($_SESSION['msg1'])){
                    echo '<span class="">';
                    echo $_SESSION['msg1'];
                    echo '</span>';
                }
            ?>
            <input  type="text" name="firstDate" placeholder='dd/mm/yyyy' value='<?php if(isset($_SESSION['fDate']) && !empty($_SESSION['fDate'])) echo $_SESSION['fDate'];?>' required/>
        </p>
        <p>
            <label class='lb'>Please enter the second date:</label>
             <span><?php if(isset($_SESSION['msg2']) && strlen($_SESSION['msg2'])){ echo $_SESSION['msg2']; } ?></span>
            <input  type="text" name="secondDate" placeholder='dd/mm/yyyy' value='<?php if(isset($_SESSION['lDate']) && !empty($_SESSION['lDate'])) echo $_SESSION['lDate'];?>' required/>
        </p>

        <p><input type="submit" name='calc' value="Calculate"/></p>
    </div>


    <div class='divStyle'>
        <?php
            if(isset($_SESSION['calcReslt']) && !empty($_SESSION['calcReslt']))
                {echo $_SESSION['calcReslt']; echo "<br><br>";}
        ?>
    </div>

    <div class='divBlock'>
        <p>
            <label class='lb'>Wanna convert the days into hours, minutes, seconds: </label>
            <select name='convtOption'>
                <option selected value='1'>1 for Seconds</option>
                <option value='2'>2 for Minutes</option>
                <option value='3'>3 for Hours</option>
                <option value='4'>4 for Years</option>

            </select>
        </p>
        <p>
            <input type="submit" name='convtRes' id='convtRes' value="Convert Result"/>
        </p>


        <div class='divStyle'>
            <?php

                if(isset($_SESSION['covtTimeMsg']) && !empty($_SESSION['covtTimeMsg']))
                    {echo $_SESSION['covtTimeMsg'];}
            ?>
        </div>
    </div>

     <div class='divBlock'>
        <p>

             <label class='lb'>Wanna change the timezone to see the difference: </label>
            <select name="timeZoneCh">
                <?php
                    $tz=DateTimeZone::listIdentifiers();
                    foreach($tz as $key):
                          if (isset($_SESSION['timeZoneCh']) && strlen($_SESSION['timeZoneCh'])){
                                echo  "<option value='".$_SESSION['timeZoneCh']."' selected>". $_SESSION['timeZoneCh']."</option>";
                             }
                ?>
                        <option value='<?php echo $key;?>'> <?php echo $key;?></option>
                <?php
                    endforeach;
                ?>
            </select>
        </p>
        <p>
            <input type="submit" name='tzChange'  value="New Timezone"/>
        </p>
    </div>



    <div class="divStyle">
            <?php

                if(isset($_SESSION['upFirstDate']) && !empty($_SESSION['upFirstDate']))
                    {echo $_SESSION['upFirstDate'];}

                if(isset($_SESSION['upSecondDate']) && !empty($_SESSION['upSecondDate']))
                    {echo $_SESSION['upSecondDate'];}
            ?>
    </div>

</form>



<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
      <?php
            //initialize session variable
                session_reset();
                unset($_SESSION['msg1']);
                unset($_SESSION['msg2']);
                unset($_SESSION['fDate']);
                unset($_SESSION['lDate']);
                unset($_SESSION['calcReslt']);
                unset($_SESSION['covtTimeMsg']);
                unset($_SESSION['upFirstDate']);
                unset($_SESSION['upSecondDate']);
                unset($_SESSION['timeZone']);
                unset($_SESSION['timeZoneCh']);
        ?>

});

//$('.unset').on('click',function(){
//                unset($_SESSION['fDate']);
//                unset($_SESSION['lDate']);
//    alert("Unset fDate and lDate");
//});

//$('#convtRes').on('click',function(){
//   alert('converting days into seconds/minutes/hours/years!');
//});


</script>

</body>
</html>

