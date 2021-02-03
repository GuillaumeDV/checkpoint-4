<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuizzController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('quizz/index.html.twig', [
            'controller_name' => 'QuizzController',
        ]);
    }
    /**
     * @Route("/quizz/{name}", name="show_quizz")
     */
    public function show(): Response
    {
        return $this->render('quizz/show.html.twig', [
            'controller_name' => 'QuizzController',
        ]);
    }
}
