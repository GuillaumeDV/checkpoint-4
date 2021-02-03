<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserQuestion;
use App\Repository\QuestionRepository;
use App\Repository\UserQuestionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function index(User $user, UserQuestionRepository $info, QuestionRepository $questions): Response
    {
        //dd($user);
        //dd($this->getUser());
        if ($this->getUser() === $user) {
            $numberQuestion = count($questions->findAll());
            $numberAnswer = count($info->findBy(['user' => $user]));
            $percentAnswer = (100/$numberQuestion)*$numberAnswer;
            return $this->render('profile/index.html.twig', [
                'controller_name' => 'ProfileController',
                'infos' => $info->findBy([
                    'user' => $user
                ]),
                'progress' => $percentAnswer,
            ]);
        } else {
            return $this->redirect($this->generateUrl('home'));
        }
    }
}
