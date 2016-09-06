<?php

require 'shared.php';
require 'HijriCalendar.php';

// ####### Method 1: read file generated from cron job ####### 
if(isset($_GET["iftaa_api"]) && $_GET["iftaa_api"] == "1") {
    $hijri = array();
    list ($day,$month,$year) = readDateFile();
    $month = HijriCalendar::monthNumber($month);
    
    array_push($hijri, $month); // month
    array_push($hijri, $day); // day
    array_push($hijri, $year); // year
}
// ####### end of method 1 #######

// ####### Method 2: php calculations ####### 
else {

    $DAY_OFFSET = 0;
    if (isset($_GET["offset"]) && is_numeric($_GET["offset"]))
        $DAY_OFFSET = $_GET["offset"];

    date_default_timezone_set("Africa/Cairo");
    //$t=mktime(11, 41, 00, 8, 21, 2014);
    $hijri = HijriCalendar::GregorianToHijri( time() + ($DAY_OFFSET*24*60*60) );
    // echo $hijri[1].' '.HijriCalendar::monthName($hijri[0]).' '.$hijri[2];
}
// ####### end of method 2 #######

if(isset($_GET["color"]) && strlen($_GET["color"]) == 6 && ctype_alnum($_GET["color"]))
    $color = $_GET["color"];
else
    $color = "3498db";
?>

<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hijri Date</title>
    <style type="text/css">
        * {
          -webkit-box-sizing: border-box;
          -moz-box-sizing: border-box;
          box-sizing: border-box;  
        }

        body {
            /*background: #1f253d;*/
            background: #ffffff;
        }

        .calendar {
            height: 100%;
            width: 100%;
            background: #<?php echo $color ?>;
            border-radius: 5px;
            margin: 0;
            position: absolute;
            top: 0; bottom: 0; left: 0; right: 0;
        }
        .calendar h2 {
            margin: 0;
            text-align: center;
            width: 100%;
        }
        .calendar .month {
            height: 20%;
            padding-top: 5px;
        }
        .calendar .day { 
            height: 60%;
        }
        .calendar .year {
            height: 20%;
        }
    </style>
</head>
<body>
    <div class="calendar">
        <h2 class="month"><img height="100%" src="img/months/<?php echo $hijri[0] ?>.svg"></h2> 
        <h2 class="day"><img height="100%" src="img/days/<?php echo $hijri[1] ?>.svg"></h2>
        <h2 class="year"><img height="100%" src="img/years/<?php echo $hijri[2] ?>.svg"></h2>
    </div>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-63683830-6', 'auto');
      ga('send', 'pageview');

    </script>
</body>
</html>
