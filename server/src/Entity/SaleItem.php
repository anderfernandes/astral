<?php

namespace App\Entity;

use App\Enums\SaleItemType;
use App\Repository\SaleItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: SaleItemRepository::class)]
#[ORM\Table(name: 'sale_items')]
class SaleItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sale:list', 'sale:details'])]
    private ?int $id = null;

    // #[ORM\Column(length: 255)]
    private ?string $name = null;

    // #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['sale:list', 'sale:details'])]
    private ?int $price = null;

    #[ORM\Column]
    #[Groups(['sale:list', 'sale:details'])]
    private ?int $quantity = null;

    // #[ORM\Column(length: 255)]
    private string $cover = '/default.png';

    #[ORM\Column(nullable: true)]
    #[Groups(['sale:list', 'sale:details'])]
    private ?array $meta;

    #[ORM\Column(enumType: SaleItemType::class)]
    #[Groups(['sale:list', 'sale:details'])]
    private ?SaleItemType $type = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?Sale $sale = null;

    public function __construct(
        int $price,
        int $quantity,
        ?string $name = null,
        ?string $description = null,
        ?string $cover = '/default.png',
        ?array $meta = null,
        ?SaleItemType $type = SaleItemType::Ticket,
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->cover = $cover;
        $this->meta = $meta;
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function setMeta(array $meta): static
    {
        $this->meta = $meta;

        return $this;
    }

    public function getType(): ?SaleItemType
    {
        return $this->type;
    }

    public function setType(SaleItemType $type): static
    {
        $this->type = $type;

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
}
