<?php

namespace App\Command;

use App\Entity\Lesson;
use App\Entity\Room;
use App\Entity\Subject;
use App\Entity\Teacher;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'scrape:lessons',
    description: 'Add a short description for your command',
)]
class ScrapeLessonsCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LessonRepository $lessonRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = 20;

        $teachers = $this->entityManager->getRepository(Teacher::class)->findAll();
        $cnt = 0;
        foreach ($teachers as $teacher) {
            $cnt++;
            if ($cnt > $limit) {
                break;
            }
            $teacher_string = urlencode($teacher->getItem());
            $output->writeln("{$cnt} Processing teacher {$teacher_string}...");
            $url = "https://plan.zut.edu.pl/schedule_student.php?teacher=$teacher_string&start=2024-11-9&end=2024-11-30";
            $response = file_get_contents($url);
            $json = json_decode($response);
            $ignored_first = false;
            foreach ($json as $obj) {
                if (!$ignored_first) {
                    $ignored_first = true;
                    continue;
                }
                $item = json_encode($obj);
                //var_dump($item);
                $lesson = $this->lessonRepository->findOneBy(['item' => $item]);
                if (!$lesson) {
                    $lesson = new Lesson();
                    $this->entityManager->persist($lesson);
                    $lesson->setItem($item);
                }
                $teacher->addLesson($lesson);
                $lesson->setUpdated(true);
            }
            if(!($cnt % 100)) {
                $this->entityManager->flush();
            }
        }
        $output->writeln("Finished processing teachers!\n");
        $this->entityManager->flush();

        $rooms = $this->entityManager->getRepository(Room::class)->findAll();
        $cnt = 0;
        foreach ($rooms as $room) {
            $cnt++;
            if ($cnt > $limit) {
                break;
            }
            $room_string = urlencode($room->getItem());
            $output->writeln("{$cnt} Processing room {$room_string}...");
            $url = "https://plan.zut.edu.pl/schedule_student.php?room=$room_string&start=2024-11-9&end=2024-11-30";
            $response = file_get_contents($url);
            $json = json_decode($response);
            $ignored_first = false;
            foreach ($json as $obj) {
                if (!$ignored_first) {
                    $ignored_first = true;
                    continue;
                }
                $item = json_encode($obj);
                //var_dump($item);
                $lesson = $this->lessonRepository->findOneBy(['item' => $item]);
                if (!$lesson) {
                    $lesson = new Lesson();
                    $this->entityManager->persist($lesson);
                    $lesson->setItem($item);
                }
                $room->addLesson($lesson);
                $lesson->setUpdated(true);
            }
            if(!($cnt % 100)) {
                $this->entityManager->flush();
            }
        }
        $output->writeln("Finished processing rooms!\n");
        $this->entityManager->flush();

        $subjects = $this->entityManager->getRepository(Subject::class)->findAll();
        $cnt = 0;
        foreach ($subjects as $subject) {
            $cnt++;
            if ($cnt > $limit) {
                break;
            }
            $subject_string = urlencode($subject->getItem());
            $output->writeln("{$cnt} Processing subject {$subject_string}...");
            $url = "https://plan.zut.edu.pl/schedule_student.php?subject=$subject_string&start=2024-11-9&end=2024-11-30";
            $response = file_get_contents($url);
            $json = json_decode($response);
            $ignored_first = false;
            foreach ($json as $obj) {
                if (!$ignored_first) {
                    $ignored_first = true;
                    continue;
                }
                $item = json_encode($obj);
                //var_dump($item);
                $lesson = $this->lessonRepository->findOneBy(['item' => $item]);
                if (!$lesson) {
                    $lesson = new Lesson();
                    $this->entityManager->persist($lesson);
                    $lesson->setItem($item);
                }
                $subject->addLesson($lesson);
                $lesson->setUpdated(true);
            }
            if(!($cnt % 100)) {
                $this->entityManager->flush();
            }
        }
        $output->writeln("Finished processing subjects!\n");
        $this->entityManager->flush();

        $this->lessonRepository->deleteAllNotUpdated();
        $output->writeln("Deleted all old, non-updated lessons.\n");
        return Command::SUCCESS;
    }
}
