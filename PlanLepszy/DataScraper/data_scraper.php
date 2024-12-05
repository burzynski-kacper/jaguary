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







if (! $response) {
    die("No response.");
}
//var_dump($response);


