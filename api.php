<?php

require 'shared.php';
require 'HijriCalendar.php';

// ####### Method 1: read file generated from cron job ####### 
if(isset($_GET["iftaa_api"]) && $_GET["iftaa_api"] == "1") {
  $hijri = array();
  list ($day,$month,$year) = readDateFile();
  
  array_push($hijri, $month); // month
  array_push($hijri, $day); // day
  array_push($hijri, $year); // year 
}
// ####### Method 2: php calculations ####### 
else {
  $d = 14;
  $m = 8;
  $y = 2013;
  $DAY_OFFSET = 0;
  $invalid_data = false;

  if (isset($_GET["d"]) && is_numeric($_GET["d"]))
      $d = $_GET["d"];
  else
      $invalid_data = true;

  if (isset($_GET["m"]) && is_numeric($_GET["m"]))
      $m = $_GET["m"];
  else
      $invalid_data = true;

  if (isset($_GET["y"]) && is_numeric($_GET["y"]))
      $y = $_GET["y"];
  else
      $invalid_data = true;

  if (isset($_GET["offset"]) && is_numeric($_GET["offset"]))
          $DAY_OFFSET = $_GET["offset"];

  if ($invalid_data === true) {
      echo "Invalid data! Please call the url with a GET request and d,m,y parameters.";
      return;
  }

  $t=mktime(0, 0, 00, $m, $d, $y) + ($DAY_OFFSET*24*60*60);
  $hijri = HijriCalendar::GregorianToHijri( $t );
  $hijri[0] = HijriCalendar::monthName($hijri[0]);
}
// ####### end of method 2 #######

if(isset($_GET["month_number"]) && $_GET["month_number"]=="1")
  $hijri[0] = HijriCalendar::monthNumber($hijri[0]);

$response = $hijri[1].'|'.$hijri[0].'|'.$hijri[2];

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

echo json_encode($response);

?>
