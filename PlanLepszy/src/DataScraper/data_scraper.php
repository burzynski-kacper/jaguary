<?php

ini_set('display_errors', true);

//$url = 'https://plan.zut.edu.pl/schedule_student.php?number=48671&start=2024-11-25&end=2024-12-02';
//$url = 'https://plan.zut.edu.pl/schedule.php?kind=teacher&query=+';
//$url = 'https://plan.zut.edu.pl/schedule.php?kind=room&query=+';
$url = 'https://plan.zut.edu.pl/schedule.php?kind=subject&query=+';
//$url = 'https://plan.zut.edu.pl/schedule.php?kind=group&query=+';

$response = file_get_contents($url);
if (! $response) {
    die("No response.");
}
var_dump($response);

$json = json_decode($response);
var_dump($json);