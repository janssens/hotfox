<?php

namespace App\Entity;

use App\Repository\ReplyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReplyRepository::class)]
class Reply
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Instructor::class, inversedBy: 'replies')]
    #[ORM\JoinColumn(nullable: false)]
    private $inspector;

    #[ORM\ManyToOne(targetEntity: Race::class, inversedBy: 'replies')]
    #[ORM\JoinColumn(nullable: false)]
    private $race;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'replies')]
    #[ORM\JoinColumn(nullable: false)]
    private $answer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInspector(): ?Instructor
    {
        return $this->inspector;
    }

    public function setInspector(?Instructor $inspector): self
    {
        $this->inspector = $inspector;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getAnswer(): ?Question
    {
        return $this->answer;
    }

    public function setAnswer(?Question $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
