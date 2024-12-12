<?php

namespace App\Command;

use App\Entity\Lesson;
use App\Entity\Subject;
use App\Repository\SubjectRepository;
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
        private readonly EntityManagerInterface $entityManager, private readonly SubjectRepository $subjectRepository
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
        $cnt = 0;
        foreach($json as $obj){
            $output->writeln("Processing subject {$obj->item}...");
            $subject = $this->subjectRepository->findOneBy(['item' => $obj->item]);
            if (!$subject) {
                $subject = new Subject();
                $this->entityManager->persist($subject);
            }
            $subject->setItem($obj->item);
            $cnt++;
            if(!($cnt % 100)) {
                $this->entityManager->flush();
            }
        }
        $this->entityManager->flush();
        return Command::SUCCESS;
    }
}
