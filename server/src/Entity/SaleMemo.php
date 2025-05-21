<?php

namespace App\Entity;

use App\Repository\SaleMemoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: SaleMemoRepository::class)]
#[ORM\Table(name: 'sale_memos')]
class SaleMemo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sale:list', 'sale:details'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['sale:details'])]
    private ?string $content = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['sale:details'])]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'memos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?Sale $sale = null;

    #[ORM\Column]
    #[Groups(['sale:details'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['sale:details'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(string $content, User $author, Sale $sale)
    {
        $this->createdAt = new \DateTimeImmutable();

        $this->content = $content;
        $this->author = $author;
        $this->sale = $sale;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): static
    {
        $this->sale = $sale;

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
}
