<?php

namespace App\Controller;

use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(TeacherRepository $teacherRepository): Response
    {
        $teacher = $teacherRepository->find(1);
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'teacher' => $teacher,
        ]);
    }
}
