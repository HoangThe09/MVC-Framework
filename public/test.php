<?php
$holidays =  [
    20 => 'a',
    23 => 'b',
    32 => '1',
    33 => '2',
    34 => '3',
    35 => '4',
    36 => '5',
    37 => '6',
    38 => '7',
];

$start = 1;
$end = 41;
$startTrip = 0;
$endTrip = '';
$check = '';
$count = 0;
$a = [];
for($i = $start; $i <= $end; $i++){
    if($i == $start && $startTrip == '' && !array_key_exists($start, $holidays)){
        $startTrip = $start;
        $endTrip = '';
    }
    if (!array_key_exists($i, $holidays) && array_key_exists($i-1, $holidays)){
        $startTrip = $i;
    }
    if (!array_key_exists($i, $holidays) && array_key_exists($i+1, $holidays)){
        $endTrip =  $i;
    }
    
    if($startTrip === $endTrip){
        $a[] = $startTrip;
        $startTrip = 0;
        $endTrip = '';
    }
    if($startTrip < $endTrip){
        $a[] = [$startTrip, $endTrip];
        $startTrip = 0;
        $endTrip = '';
    }
    if($i == $end && $endTrip == '' && !array_key_exists($end, $holidays)){
        $endTrip = $i;
        $a[] = [$startTrip, $endTrip];
        $startTrip = 0;
        $endTrip = '';
    }
}
echo'<pre>';
print_r($a);
echo '</pre>';
echo $startTrip;