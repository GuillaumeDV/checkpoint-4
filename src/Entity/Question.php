<?php

namespace App\Entity;

use App\Entity\Category;
use App\Entity\BadAnswer;
use App\Entity\UserQuestion;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="questions")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=BadAnswer::class, mappedBy="question", cascade={"persist"})
     */
    private $badAnswers;

    /**
     * @ORM\OneToMany(targetEntity=UserQuestion::class, mappedBy="question")
     */
    private $userQuestions;

    public function __construct()
    {
        $this->badAnswers = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|BadAnswer[]
     */
    public function getBadAnswers(): Collection
    {
        return $this->badAnswers;
    }

    public function addBadAnswer(BadAnswer $badAnswer): self
    {
        if (!$this->badAnswers->contains($badAnswer)) {
            $this->badAnswers[] = $badAnswer;
            $badAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeBadAnswer(BadAnswer $badAnswer): self
    {
        if ($this->badAnswers->removeElement($badAnswer)) {
            // set the owning side to null (unless already changed)
            if ($badAnswer->getQuestion() === $this) {
                $badAnswer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserQuestion[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(UserQuestion $userQuestions): self
    {
        if (!$this->userQuestions->contains($userQuestions)) {
            $this->userQuestions[] = $userQuestions;
            $userQuestions->setQuestion($this);
        }

        return $this;
    }

    public function removeUser(UserQuestion $userQuestions): self
    {
        if ($this->userQuestions->removeElement($userQuestions)) {
            // set the owning side to null (unless already changed)
            if ($userQuestions->getQuestion() === $this) {
                $userQuestions->setQuestion(null);
            }
        }

        return $this;
    }
}
