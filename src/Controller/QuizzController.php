<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use App\Form\BadAnswerType;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\BadAnswerRepository;
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
    public function showCategory(QuestionRepository $questions, Category $category): Response
    {
        return $this->render('quizz/show.html.twig', [
            'controller_name' => 'QuizzController',
            'questions' => $questions->findBy([
                'category' => $category
            ])
        ]);
    }

    /**
     * @Route("/question/{id}", name="show_question")
     */
    public function showQuestion(BadAnswerRepository $answer, Question $question): Response
    {
        $badAnswers = array($answer->findBy([
            'question' => $question
            ]));
        $answers = array($question->getAnswer());
        for ($i = 0; $i < count($badAnswers[0]); $i++) {
            array_push($answers, $badAnswers[0][$i]->getName());
        }
        shuffle($answers);
        return $this->render('question/show.html.twig', [
            'controller_name' => 'QuizzController',
            'answers' => $answers,
            'question' => $question->getName(),
            'goodAnswer' => $question->getAnswer(),
        ]);
    }
}
