<?php

namespace App\DataScraper;
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

use App\Entity\Lesson;
use App\Entity\Teacher;
use App\Entity\Subject;
use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;

//return 0;

ini_set('display_errors', true);

//$url = 'https://plan.zut.edu.pl/schedule_student.php?number=48671&start=2024-11-25&end=2024-12-02';

//$url = 'https://plan.zut.edu.pl/schedule.php?kind=group&query=+';

$url = 'https://plan.zut.edu.pl/schedule.php?kind=teacher&query=+';
$response = file_get_contents($url);
$json = json_decode($response);
//var_dump($json);
foreach($json as $obj){
    //var_dump($obj->item);
    //print $obj->item;

    $teacher = new Teacher();
    $teacher->setItem($obj->item);

    $tok = strtok($obj->item, " ");
    $teacher_string = $tok;
    $tok = strtok(" ");
    while ($tok !== false) {
        $teacher_string .= ("%20" . $tok);
        $tok = strtok(" ");
    }
    $url = "https://plan.zut.edu.pl/schedule_student.php?teacher=$teacher_string&start=2024-11-25&end=2024-12-02";
    $response = file_get_contents($url);
    $json2 = json_decode($response);
    foreach($json2 as $obj2){
        $item = json_encode($obj2);
        var_dump($item);
        $lesson = new Lesson();
        $lesson->setItem($item);
        $teacher->addLesson($lesson);
    }
}

$url = 'https://plan.zut.edu.pl/schedule.php?kind=subject&query=+';
$response = file_get_contents($url);
$json = json_decode($response);
foreach($json as $obj){
    $subject = new Subject();
    $subject->setItem($obj->item);

    $tok = strtok($obj->item, " ");
    $subject_string = $tok;
    $tok = strtok(" ");
    while ($tok !== false) {
        $subject_string .= ("%20" . $tok);
        $tok = strtok(" ");
    }
    $url = "https://plan.zut.edu.pl/schedule_student.php?subject=$subject_string&start=2024-11-25&end=2024-12-02";
    $response = file_get_contents($url);
    $json2 = json_decode($response);
    foreach($json2 as $obj2){
        $item = json_encode($obj2);
        var_dump($item);
        $lesson = new Lesson();
        $lesson->setItem($item);
        $subject->addLesson($lesson);
    }
}

$url = 'https://plan.zut.edu.pl/schedule.php?kind=room&query=+';
$response = file_get_contents($url);
$json = json_decode($response);
foreach($json as $obj){
    $room = new Room();
    $room->setItem($obj->item);

    $tok = strtok($obj->item, " ");
    $room_string = $tok;
    $tok = strtok(" ");
    while ($tok !== false) {
        $room_string .= ("%20" . $tok);
        $tok = strtok(" ");
    }
    $url = "https://plan.zut.edu.pl/schedule_student.php?room=$room_string&start=2024-11-25&end=2024-12-02";
    $response = file_get_contents($url);
    $json2 = json_decode($response);
    foreach($json2 as $obj2){
        $item = json_encode($obj2);
        var_dump($item);
        $lesson = new Lesson();
        $lesson->setItem($item);
        $teacher->addLesson($lesson);
    }
}

if (! $response) {
    die("No response.");
}
//var_dump($response);


