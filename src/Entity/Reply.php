<?php

namespace App\Entity;

use App\Repository\ReplyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReplyRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Reply
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Instructor::class, inversedBy: 'replies')]
    #[ORM\JoinColumn(nullable: false)]
    private $instructor;

    #[ORM\ManyToOne(targetEntity: Race::class, inversedBy: 'replies')]
    #[ORM\JoinColumn(nullable: false)]
    private $race;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'replies')]
    #[ORM\JoinColumn(nullable: true)]
    private $answer;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private $token;

    #[ORM\PrePersist]
    public function setToken(): void
    {
        $this->token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstructor(): ?Instructor
    {
        return $this->instructor;
    }

    public function setInstructor(?Instructor $instructor): self
    {
        $this->instructor = $instructor;

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function __toString(): string
    {
        return $this->getRace()->getName() . ' | ' . $this->getInstructor()->getName() . ' : ' . (($this->getAnswer()) ? $this->getAnswer()->getContent() : 'N/A');
    }

}
