<?php

class HijriCalendar
{
    function monthName($i) // $i = 1..12
    {
        static $month  = array(
            "محرم", "صفر", "ربيع الأول", "ربيع الآخر",
            "جمادى الأولى", "جمادى الآخرة", "رجب", "شعبان",
            "رمضان", "شوال", "ذي القعدة", "ذي الحجة"
        );
        return $month[$i-1];
    }

    function monthNumber($month) {
      switch ($month) {
        case "محرم":
            $month = 1;
            break;
        case "صفر":
            $month = 2;
            break;
        case "ربيع الأول":
            $month = 3;
            break;
        case "ربيع الآخر":
            $month = 4;
            break;
        case "جمادى الأولى":
            $month = 5;
            break;
        case "جمادى الآخرة":
            $month = 6;
            break;
        case "رجب":
            $month = 7;
            break;
        case "شعبان":
            $month = 8;
            break;
        case "رمضان":
            $month = 9;
            break;
        case "شوال":
            $month = 10;
            break;
        case "ذي القعدة":
            $month = 11;
            break;
        case "ذي الحجة":
            $month = 12;
            break;
        default:
            $month = 0;
            break;
      }
      return $month;
    }

    function GregorianToHijri($time = null)
    {
        if ($time === null) $time = time();
        $m = date('m', $time);
        $d = date('d', $time);
        $y = date('Y', $time);

        return HijriCalendar::JDToHijri(
            cal_to_jd(CAL_GREGORIAN, $m, $d, $y));
    }

    function HijriToGregorian($m, $d, $y)
    {
        return jd_to_cal(CAL_GREGORIAN,
            HijriCalendar::HijriToJD($m, $d, $y));
    }

    # Julian Day Count To Hijri
    function JDToHijri($jd)
    {
        $jd = $jd - 1948440 + 10632;
        $n  = (int)(($jd - 1) / 10631);
        $jd = $jd - 10631 * $n + 354;
        $j  = ((int)((10985 - $jd) / 5316)) *
            ((int)(50 * $jd / 17719)) +
            ((int)($jd / 5670)) *
            ((int)(43 * $jd / 15238));
        $jd = $jd - ((int)((30 - $j) / 15)) *
            ((int)((17719 * $j) / 50)) -
            ((int)($j / 16)) *
            ((int)((15238 * $j) / 43)) + 29;
        $m  = (int)(24 * $jd / 709);
        $d  = $jd - (int)(709 * $m / 24);
        $y  = 30*$n + $j - 30;

        return array($m, $d, $y);
    }

    # Hijri To Julian Day Count
    function HijriToJD($m, $d, $y)
    {
        return (int)((11 * $y + 3) / 30) +
            354 * $y + 30 * $m -
            (int)(($m - 1) / 2) + $d + 1948440 - 385;
    }
};

?>
