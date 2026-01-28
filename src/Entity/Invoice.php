<?php

namespace App\Entity;

use App\Enum\Invoice_status;
use App\Enum\Invoice_type;
use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(enumType: Invoice_status::class)]
    private ?Invoice_status $status = null;

    #[ORM\Column(enumType: Invoice_type::class)]
    private ?Invoice_type $type = null;

    /**
     * @var Collection<int, Audit>
     */
    #[ORM\OneToMany(targetEntity: Audit::class, mappedBy: 'invoice')]
    private Collection $audit;

    /**
     * @var Collection<int, Certification>
     */
    #[ORM\OneToMany(targetEntity: Certification::class, mappedBy: 'invoice')]
    private Collection $certification;

    /**
     * @var Collection<int, Client>
     */
    #[ORM\OneToMany(targetEntity: Client::class, mappedBy: 'invoice')]
    private Collection $client;

    public function __construct()
    {
        $this->audit = new ArrayCollection();
        $this->certification = new ArrayCollection();
        $this->client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): ?Invoice_status
    {
        return $this->status;
    }

    public function setStatus(Invoice_status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?Invoice_type
    {
        return $this->type;
    }

    public function setType(Invoice_type $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Audit>
     */
    public function getAudit(): Collection
    {
        return $this->audit;
    }

    public function addAudit(Audit $audit): static
    {
        if (!$this->audit->contains($audit)) {
            $this->audit->add($audit);
            $audit->setInvoice($this);
        }

        return $this;
    }

    public function removeAudit(Audit $audit): static
    {
        if ($this->audit->removeElement($audit)) {
            // set the owning side to null (unless already changed)
            if ($audit->getInvoice() === $this) {
                $audit->setInvoice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Certification>
     */
    public function getCertification(): Collection
    {
        return $this->certification;
    }

    public function addCertification(Certification $certification): static
    {
        if (!$this->certification->contains($certification)) {
            $this->certification->add($certification);
            $certification->setInvoice($this);
        }

        return $this;
    }

    public function removeCertification(Certification $certification): static
    {
        if ($this->certification->removeElement($certification)) {
            // set the owning side to null (unless already changed)
            if ($certification->getInvoice() === $this) {
                $certification->setInvoice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Client $client): static
    {
        if (!$this->client->contains($client)) {
            $this->client->add($client);
            $client->setInvoice($this);
        }

        return $this;
    }

    public function removeClient(Client $client): static
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getInvoice() === $this) {
                $client->setInvoice(null);
            }
        }

        return $this;
    }
}
