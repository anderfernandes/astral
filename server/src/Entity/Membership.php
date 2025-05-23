<?php

namespace App\Entity;

use App\Repository\MembershipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MembershipRepository::class)]
#[ORM\Table(name: 'memberships')]
class Membership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['membership:details'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private ?\DateTimeImmutable $starting = null;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private ?\DateTimeImmutable $ending = null;

    #[ORM\Column]
    #[Groups(['membership:details'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['membership:details'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?int $primary_id = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'membership')]
    #[Groups(['membership:details'])]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'memberships')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['membership:details'])]
    private ?MembershipType $type = null;

    /*
    * @param \App\Entity\User[] $users
    */
    public function __construct(\DateTimeImmutable $starting, \DateTimeImmutable $ending, MembershipType $type, array $users)
    {
        $this->starting = $starting;
        $this->ending = $ending;
        $this->type = $type;
        $this->primary_id = $users[0]->getId();
        $this->users = new ArrayCollection($users);
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStarting(): ?\DateTimeImmutable
    {
        return $this->starting;
    }

    public function setStarting(\DateTimeImmutable $starting): static
    {
        $this->starting = $starting;

        return $this;
    }

    public function getEnding(): ?\DateTimeImmutable
    {
        return $this->ending;
    }

    public function setEnding(\DateTimeImmutable $ending): static
    {
        $this->ending = $ending;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPrimaryId(): ?int
    {
        return $this->primary_id;
    }

    public function setPrimaryId(int $primary_id): static
    {
        $this->primary_id = $primary_id;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addSecondary(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setMembership($this);
        }

        return $this;
    }

    public function removeSecondary(User $users): static
    {
        if ($this->users->removeElement($users)) {
            // set the owning side to null (unless already changed)
            if ($users->getMembership() === $this) {
                $users->setMembership(null);
            }
        }

        return $this;
    }

    public function getType(): ?MembershipType
    {
        return $this->type;
    }

    public function setType(?MembershipType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
