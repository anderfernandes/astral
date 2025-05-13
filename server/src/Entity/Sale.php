<?php

namespace App\Entity;

use App\Enums\SaleItemType;
use App\Enums\SaleSource;
use App\Enums\SaleStatus;
use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
#[ORM\Table(name: 'sales')]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: SaleStatus::class)]
    private SaleStatus $status = SaleStatus::OPEN;

    #[ORM\Column(enumType: SaleSource::class)]
    private SaleSource $source = SaleSource::CASHIER;

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
     * @var Event[]
     */
    private array $events = [];

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

    /**
     * @var Collection<int, SaleMemo>
     */
    #[ORM\OneToMany(targetEntity: SaleMemo::class, mappedBy: 'sale')]
    private Collection $memos;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'sale')]
    private Collection $tickets;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $session = null;

    public function __construct(
        ?User $creator = null,
        ?User $customer = null,
    ) {
        $this->creator = $creator;
        $this->customer = $customer;
        $this->createdAt = new \DateTimeImmutable();
        $this->payments = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->memos = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function getSubtotal(): int
    {
        $subtotal = 0;

        foreach ($this->items as $item) {
            if (SaleItemType::ConvenienceFee === $item->getType()) {
                continue;
            }

            $subtotal += $item->getPrice() * $item->getQuantity();
        }

        return $subtotal;
    }

    public function getTax(): int
    {
        if (!$this->isTaxable) {
            return 0;
        }

        $total = 0;

        $taxRate = isset($_ENV['TAX']) ? ((float) $_ENV['TAX'] / 100) : 0;

        foreach ($this->items as $item) {
            $total += round($item->getPrice() * $item->getQuantity() * $taxRate);
        }

        return $total;
    }

    public function getTotal(): int
    {
        $convenienceFee = 0;

        foreach ($this->items as $item) {
            if (SaleItemType::ConvenienceFee === $item->getType()) {
                $convenienceFee = $item->getPrice();
                break;
            }
        }

        return $this->getSubtotal() + $this->getTax() + $convenienceFee;
    }

    public function getTendered(): int
    {
        $tendered = 0;

        foreach ($this->payments as $payment) {
            $tendered += $payment->getTendered();
        }

        return $tendered;
    }

    public function getBalance(): int
    {
        $balance = $this->getTendered() - $this->getTotal();

        return ($balance >= 0) ? 0 : $balance;
    }

    public function getChange(): int
    {
        $balance = $this->getTendered() - $this->getTotal();

        return ($balance >= 0) ? $balance : 0;
    }

    public function getPaid(): int
    {
        $paid = 0;

        foreach ($this->payments as $payment) {
            $paid += $payment->getTendered();
        }

        // if ($paid >= $this->getTotal()) {
        //     return $this->getTotal();
        // }

        return $paid;
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
            if ($payment->getSale() == $this) {
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

    /**
     * @return Collection<int, SaleMemo>
     */
    public function getMemos(): Collection
    {
        return $this->memos;
    }

    public function addMemo(SaleMemo $memo): static
    {
        if (!$this->memos->contains($memo)) {
            $this->memos->add($memo);
            $memo->setSale($this);
        }

        return $this;
    }

    public function removeMemo(SaleMemo $memo): static
    {
        if ($this->memos->removeElement($memo)) {
            // set the owning side to null (unless already changed)
            if ($memo->getSale() === $this) {
                $memo->setSale(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    protected function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setSale($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getSale() === $this) {
                $ticket->setSale(null);
            }
        }

        return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(?string $session): static
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @param Event[] $events
     */
    public function setEvents(array $events): static
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return array<int>
     */
    public function getEventIds(): array
    {
        $ids = [];

        foreach ($this->items as $item) {
            if (SaleItemType::Ticket === $item->getType()) {
                $ids[] = $item->getMeta()['eventId'];
            }
        }

        return array_unique($ids);
    }

    /**
     * @return int[]
     */
    public function getTicketTypeIds(): array
    {
        $ids = [];

        foreach ($this->items as $item) {
            if (SaleItemType::Ticket === $item->getType()) {
                $ids[] = $item->getMeta()['ticketTypeId'];
            }
        }

        return array_unique($ids);
    }
}
