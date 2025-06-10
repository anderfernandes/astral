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
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['membership:details'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?int $primaryId = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'membership')]
    #[Groups(['membership:details'])]
    private Collection $users;

    #[ORM\ManyToOne]
    private ?User $creator = null;

    /**
     * @var Collection<int, MembershipItem>
     */
    #[ORM\OneToMany(targetEntity: MembershipItem::class, mappedBy: 'membership')]
    private Collection $items;

    /*
    * @param \App\Entity\User[] $users
    */
    public function __construct(array $users)
    {
        // $this->starting = $starting;
        // $this->ending = $ending;
        // $this->type = $type;
        $this->primaryId = $users[0]->getId();
        $this->users = new ArrayCollection($users);
        $this->createdAt = new \DateTimeImmutable();
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->primaryId;
    }

    public function setPrimaryId(int $primaryId): static
    {
        $this->primaryId = $primaryId;

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

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, MembershipItem>
     */
    public function getItem(): Collection
    {
        return $this->items;
    }

    public function addItem(MembershipItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setMembership($this);
        }

        return $this;
    }

    public function removeItem(MembershipItem $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getMembership() === $this) {
                $item->setMembership(null);
            }
        }

        return $this;
    }
}
