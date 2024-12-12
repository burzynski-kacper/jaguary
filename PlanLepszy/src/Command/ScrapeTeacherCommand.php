<?php

namespace App\Command;

use App\Entity\Lesson;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'scrape:teacher',
    description: 'Add a short description for your command',
)]
class ScrapeTeacherCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TeacherRepository $teacherRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = 'https://plan.zut.edu.pl/schedule.php?kind=teacher&query=+';
        $response = file_get_contents($url);
        $json = json_decode($response);
        $cnt = 0;
        foreach($json as $obj){
            $output->writeln("Processing teacher {$obj->item}...");
            $teacher = $this->teacherRepository->findOneBy(['item' => $obj->item]);
            if (!$teacher) {
                $teacher = new Teacher();
                $this->entityManager->persist($teacher);
            }
            $teacher->setItem($obj->item);
            $cnt++;
            if(!($cnt % 100)) {
                $this->entityManager->flush();
            }
        }
        $this->entityManager->flush();
        return Command::SUCCESS;
    }
}
