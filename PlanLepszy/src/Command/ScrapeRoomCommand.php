<?php

namespace App\Command;

use App\Entity\Lesson;
use App\Entity\Room;
use App\Repository\RoomRepository;
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
        private readonly EntityManagerInterface $entityManager, private readonly RoomRepository $roomRepository,
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
        $cnt = 0;
        foreach($json as $obj){
            $output->writeln("Processing room {$obj->item}...");
            $room = $this->roomRepository->findOneBy(['item' => $obj->item]);
            if (!$room) {
                $room = new Room();
                $this->entityManager->persist($room);
            }
            $room->setItem($obj->item);
            $cnt++;
            if(!($cnt % 100)) {
                $this->entityManager->flush();
            }
        }
        $this->entityManager->flush();
        return Command::SUCCESS;
    }
}
