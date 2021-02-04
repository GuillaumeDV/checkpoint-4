<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use App\Form\BadAnswerType;
use App\Entity\UserQuestion;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\BadAnswerRepository;
use App\Repository\UserQuestionRepository;
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
    public function index(
        CategoryRepository $categories,
        QuestionRepository $questions,
        UserQuestionRepository $infos
        ): Response {
        $percentByCategory = array();
        $categoryName = $categories->findAll();
        for ($i = 0; $i < count($categories->findAll()); $i++) {
            $increment = 0;
            $category = $categoryName[$i];
            $questionByCategory = $questions->findBy([
                'category' =>$category
            ]);
            $advance = $infos->findBy(['user' => $this->getUser()]);
            for ($j = 0; $j< count($questionByCategory); $j++) {
                $question = $questionByCategory[$j];
                for ($k = 0; $k< count($advance); $k++) {
                    $answerUser = $advance[$k];
                    if ($question === $answerUser->getQuestion()) {
                        $increment += 1;
                    }
                }
            }
            $percent = number_format((100/count($questionByCategory))*$increment, 2, '.', '') . " %";
            array_push($percentByCategory, $percent);
        }
        return $this->render('quizz/index.html.twig', [
            'controller_name' => 'QuizzController',
            'percents' => $percentByCategory,
        ]);
    }
    /**
     * @Route("/quizz/{name}", name="show_quizz")
     */
    public function showCategory(QuestionRepository $questions, Category $category, UserQuestionRepository $infos): Response
    {
        $advance = $infos->findBy(['user' => $this->getUser()]);
        return $this->render('quizz/show.html.twig', [
            'controller_name' => 'QuizzController',
            'questions' => $questions->findBy([
                'category' => $category
            ]),
            'category' => $category,
            'advances' => $advance,
        ]);
    }

    /**
     * @Route("/question/{id}", name="show_question")
     */
    public function showQuestion(
        BadAnswerRepository $answer,
        UserQuestionRepository $verify,
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
                    $verifyAnswer = $verify->findBy([
                        'question' => $question,
                        'user' => $this->getUser(),
                    ]);
                    if (!isset($verifyAnswer[0])) {

                        $validated = new UserQuestion;
                        $validated->setIsGood(1)
                                  ->setQuestion($question)
                                  ->setUser($this->getUser());
                        
                        $manager->persist($validated);
                        $manager->flush();
                    }
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
