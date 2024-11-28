<?php

namespace App\DataScraper;
require '..\Entity\Teacher.php';

use App\Entity\Lesson;
use App\Entity\Teacher;
use Doctrine\ORM\EntityManagerInterface;

//return 0;

ini_set('display_errors', true);

//$url = 'https://plan.zut.edu.pl/schedule_student.php?number=48671&start=2024-11-25&end=2024-12-02';

//$url = 'https://plan.zut.edu.pl/schedule.php?kind=room&query=+';
//url = 'https://plan.zut.edu.pl/schedule.php?kind=subject&query=+';
//$url = 'https://plan.zut.edu.pl/schedule.php?kind=group&query=+';

$url = 'https://plan.zut.edu.pl/schedule.php?kind=teacher&query=+';
$response = file_get_contents($url);
$json = json_decode($response);
//var_dump($json);

foreach($json as $obj){
    //var_dump($obj->item);
    //print $obj->item;

    //$teacher = $entityManager->getRepository(Teacher::class)->find($obj->item);
    //if (!$teacher) {
    //
    //}

    $teacher = new Teacher();
    $teacher->setItem($obj->item);

    $tok = strtok($obj->item, " ");
    $teacher_string = $tok;
    while ($tok !== false) {
        $teacher_string .= ("%20" . $tok);
        $tok = strtok(" ");
    }
    $url = "https://plan.zut.edu.pl/schedule_student.php?nteacher=$teacher_string&start=2024-11-25&end=2024-12-02";
    $response = file_get_contents($url);
    $json2 = json_decode($response);
    foreach($json2 as $obj2){
        //$lesson = new Lesson();
        //$lesson->setItem($obj2->item);
        var_dump($obj2);
        //$teacher->addLesson($lesson);
    }
}

if (! $response) {
    die("No response.");
}
//var_dump($response);


