<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity=BadAnswer::class, mappedBy="question")
     */
    private $badAnswers;

    public function __construct()
    {
        $this->badAnswers = new ArrayCollection();
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
}
