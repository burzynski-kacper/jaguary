<?php

namespace App\Command;

use App\Entity\Lesson;
use App\Entity\Subject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'scrape:subject',
    description: 'Add a short description for your command',
)]
class ScrapeSubjectCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = 'https://plan.zut.edu.pl/schedule.php?kind=subject&query=+';
        $response = file_get_contents($url);
        $json = json_decode($response);
        foreach($json as $obj){
            $subject = new Subject();
            $this->entityManager->persist($subject);
            $subject->setItem($obj->item);

//            $tok = strtok($obj->item, " ");
//            $subject_string = $tok;
//            $tok = strtok(" ");
//            while ($tok !== false) {
//                $subject_string .= ("%20" . $tok);
//                $tok = strtok(" ");
//            }
//            $url = "https://plan.zut.edu.pl/schedule_student.php?subject=$subject_string&start=2024-11-25&end=2024-12-02";
//            $response = file_get_contents($url);
//            $json2 = json_decode($response);
//            foreach($json2 as $obj2){
//                $item = json_encode($obj2);
//                var_dump($item);
//                $lesson = new Lesson();
//                $lesson->setItem($item);
//                $subject->addLesson($lesson);
//            }
        }
        return Command::SUCCESS;
    }
}
