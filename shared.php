<?php
function readDateFile() {
  $date_file = fopen("hijri_date.txt", "r") or die("");
  $date = fread($date_file,filesize("hijri_date.txt"));
  fclose($date_file);
  $dates = explode(" ", $date);

  $day = trim($dates[0]); // first item is day
  $year = trim(array_pop($dates)); // last item is year, pop it out
  $month =  trim(join(" ",array_slice($dates,1))); //then from second to last is the month

  return array($day,$month,$year);
}

?>
