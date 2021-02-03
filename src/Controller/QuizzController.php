<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use App\Form\BadAnswerType;
use App\Entity\UserQuestion;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\BadAnswerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
    public function showQuestion(
        BadAnswerRepository $answer,
        Question $question,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $message = '';
        $badAnswers = array($answer->findBy([
            'question' => $question
            ]));
        $answers = array($question->getAnswer());
        for ($i = 0; $i < count($badAnswers[0]); $i++) {
            array_push($answers, $badAnswers[0][$i]->getName());
        }
            shuffle($answers);
        $form = $this->createFormBuilder()
        ->add('response', ChoiceType::class, [
            'label'=>$question->getName(),
            'choices'=> $answers,
            'choice_label' => function ($value) {
                return $value;
            },
            'expanded' => true,
            'multiple' => false,
            
            ])
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                if ($data['response'] === $question->getAnswer()) {
                    $message = 'Bravo bonne réponse !';
                    //dd($question->getId());
                    //dd($this->getUser());
                    $validated = new UserQuestion;
                    $validated->setIsGood(1)
                              ->setQuestion($question)
                              ->setUser($this->getUser());
                    
                    $manager->persist($validated);
                    $manager->flush();
                }
            }

        return $this->render('question/show.html.twig', [
            'controller_name' => 'QuizzController',
            'answers' => $answers,
            'question' => $question->getName(),
            'goodAnswer' => $question,
            'redirect' =>$question->getCategory()->getName(),
            'form' => $form->createView(),
            'message' => $message,
        ]);
    }
}
