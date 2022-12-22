<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Race
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'date')]
    private $deposit_date;

    #[ORM\Column(type: 'simple_array')]
    private $states = [];

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'boolean')]
    private $email_sent;

    #[ORM\OneToMany(mappedBy: 'race', targetEntity: Reply::class, orphanRemoval: true)]
    private $replies;

    public function __construct()
    {
        $this->replies = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTimeImmutable();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDepositDate(): ?\DateTimeInterface
    {
        return $this->deposit_date;
    }

    public function setDepositDate(\DateTimeInterface $deposit_date): self
    {
        $this->deposit_date = $deposit_date;

        return $this;
    }

    public function getStates(): ?array
    {
        return $this->states;
    }

    public function setStates(array $states): self
    {
        $this->states = $states;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function isEmailSent(): ?bool
    {
        return $this->email_sent;
    }

    public function setEmailSent(bool $email_sent): self
    {
        $this->email_sent = $email_sent;

        return $this;
    }

    /**
     * @return Collection<int, Reply>
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(Reply $reply): self
    {
        if (!$this->replies->contains($reply)) {
            $this->replies[] = $reply;
            $reply->setRace($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getRace() === $this) {
                $reply->setRace(null);
            }
        }

        return $this;
    }
}
