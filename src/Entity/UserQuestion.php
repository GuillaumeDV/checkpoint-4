<?php

namespace App\Entity;

use App\Repository\UserQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserQuestionRepository::class)
 */
class UserQuestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isGood;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="user")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userQuestions")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsGood(): ?bool
    {
        return $this->isGood;
    }

    public function setIsGood(bool $isGood): self
    {
        $this->isGood = $isGood;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
