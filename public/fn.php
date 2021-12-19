<?php
$oneDay = 60 * 60 * 24;
function getHolidays($holidays = [])
{
    global $oneDay;
    $result = [];
    foreach ($holidays as $day) {
        $dayArr = explode(' - ', $day);
        if (count($dayArr) == 1) {
            $timestamp = toTimestamp($day);
            $result[$timestamp] = $day;
        } else {
            $from = toTimestamp($dayArr[0]);
            $to = toTimestamp($dayArr[1]);
            for ($i = $from; $i <= $to; $i += $oneDay) {
                $result[$i] = date('d/m');
            }
        }
    }
    return $result;
}

function toTimestamp($day)
{
    $dayArr = explode('/', $day);
    $month = $dayArr[1];
    $day = $dayArr[0];
    $timestamp = strtotime("$month/$day");
    return $timestamp;
}

function getTrip($from, $to)
{
    global $holidays, $oneDay;
    $from = toTimestamp($from); // 1/1
    $to = toTimestamp($to);
    $holidays = getHolidays(['20/1', '23/1', '1/2 - 7/2']);
    $tripFrom = 0;
    $tripTo = '';
    $result = [];
    for ($i = $from; $i <= $to; $i += $oneDay) {
        if ($i == $from && $tripFrom == 0 && !array_key_exists($from, $holidays)) {
            $tripFrom = $from;
            $tripTo = '';
        }
        // ngày bắt đầu trip là ngày trước đấy là ngày nghỉ
        if (!array_key_exists($i, $holidays) && array_key_exists($i - $oneDay, $holidays)) {
            $tripFrom = $i;
        }
        // ngày kết thúc trip là ngày sau đấy là ngày nghỉ
        if (!array_key_exists($i, $holidays) && array_key_exists($i + $oneDay, $holidays)) {
            $tripTo =  $i;
        }

        if ($tripFrom === $tripTo) {
            $result[] = date('d/m', $tripFrom);
            $tripFrom = 0;
            $tripTo = '';
        }
        if ($tripFrom < $tripTo) {
            $result[] = date('d/m', $tripFrom) . " - " . date('d/m', $tripTo);
            $tripFrom = 0;
            $tripTo = '';
        }
        if ($i == $to && $tripTo == '' && !array_key_exists($to, $holidays)) {
            $tripTo = $i;
            $result[] = date('d/m', $tripFrom) . " - " . date('d/m', $tripTo);
        }
    }
    return $result;
}
// format d/m
$holidays = ['20/1', '23/1', '1/2 - 7/2'];
$from = '1/1';
$to = '10/2';
$Trips = getTrip($from, $to);
echo'<pre>';
print_r($Trips);
echo '</pre>';

function gradeCheating($n,$m,$a){
    $total = 0;
    for($i = 0; $i < $n; $i++){
        $total += $a[$i];
    }
    if($total >= 10){
        return 10;
    }
    if($total < 10){
        return $total;
    }
}
$a = gradeCheating(10,1,[1,2,2,0,2,1,0,2,0,2]);
echo'<pre>';
print_r($a);
echo '</pre>';
