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

    #[ORM\Column(type: 'integer')]
    private $value;

    #[ORM\ManyToOne(targetEntity: Instructor::class, inversedBy: 'replies')]
    #[ORM\JoinColumn(nullable: false)]
    private $inspector;

    #[ORM\ManyToOne(targetEntity: Race::class, inversedBy: 'replies')]
    #[ORM\JoinColumn(nullable: false)]
    private $race;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
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
}
