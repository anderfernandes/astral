<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use \App\Enums\SaleStatus;
use \App\Enums\SaleSource;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
#[ORM\Table(name: 'sales')]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: SaleStatus::class)]
    private SaleStatus $status = SaleStatus::Open;

    #[ORM\Column(enumType: SaleSource::class)]
    private SaleSource $source = SaleSource::Cashier;

    #[ORM\Column]
    private bool $isTaxable = true;

    #[ORM\ManyToOne]
    private ?User $creator = null;

    #[ORM\ManyToOne]
    private ?User $customer = null;

    #[ORM\Column]
    private bool $isSellToOrganization = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne]
    private ?Organization $organization = null;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'sale')]
    private Collection $payments;

    /**
     * @var Collection<int, SaleItem>
     */
    #[ORM\OneToMany(targetEntity: SaleItem::class, mappedBy: 'sale')]
    private Collection $items;

    public function __construct(
        ?User $creator = null,
        ?User $customer = null,
    )
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->payments = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    public function getSubtotal(): int {
        $subtotal = 0;

        foreach ($this->items as $item) {
            $subtotal += $item->getPrice() * $item->getQuantity();
        }

        return $subtotal;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?SaleStatus
    {
        return $this->status;
    }

    public function setStatus(SaleStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSource(): ?SaleSource
    {
        return $this->source;
    }

    public function setSource(SaleSource $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function isTaxable(): ?bool
    {
        return $this->isTaxable;
    }

    public function setTaxable(bool $isTaxable): static
    {
        $this->isTaxable = $isTaxable;

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

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function isSellToOrganization(): ?bool
    {
        return $this->isSellToOrganization;
    }

    public function setSellToOrganization(bool $isSellToOrganization): static
    {
        $this->isSellToOrganization = $isSellToOrganization;

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

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): static
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setSale($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getSale() === $this) {
                $payment->setSale(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SaleItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(SaleItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setSale($this);
        }

        return $this;
    }

    public function removeItem(SaleItem $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSale() === $this) {
                $item->setSale(null);
            }
        }

        return $this;
    }
}
