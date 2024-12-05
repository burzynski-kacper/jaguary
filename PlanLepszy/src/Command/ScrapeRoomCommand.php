<?php

namespace App\Command;

use App\Entity\Lesson;
use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'scrape:room',
    description: 'Add a short description for your command',
)]
class ScrapeRoomCommand extends Command
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
        $url = 'https://plan.zut.edu.pl/schedule.php?kind=room&query=+';
        $response = file_get_contents($url);
        $json = json_decode($response);
        foreach($json as $obj){
            $room = new Room();
            $this->entityManager->persist($room);
            $room->setItem($obj->item);

//            $tok = strtok($obj->item, " ");
//            $room_string = $tok;
//            $tok = strtok(" ");
//            while ($tok !== false) {
//                $room_string .= ("%20" . $tok);
//                $tok = strtok(" ");
//            }
//            $url = "https://plan.zut.edu.pl/schedule_student.php?room=$room_string&start=2024-11-25&end=2024-12-02";
//            $response = file_get_contents($url);
//            $json2 = json_decode($response);
//            foreach($json2 as $obj2){
//                $item = json_encode($obj2);
//                var_dump($item);
//                $lesson = new Lesson();
//                $lesson->setItem($item);
//                $room->addLesson($lesson);
//            }
        }
        return Command::SUCCESS;
    }
}
