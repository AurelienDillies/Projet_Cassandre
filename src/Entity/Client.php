<?php

namespace App\Entity;

use App\Enum\Client_status;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide.')]
    #[Assert\Length(min: 2, max: 100, minMessage: 'Le nom doit contenir au moins {{ limit }} caractères.', maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères.')]
    private ?string $name = null;

    // email field removed

    // Certification relation removed

    /**
     * @var Collection<int, Audit>
     */
    #[ORM\OneToMany(targetEntity: Audit::class, mappedBy: 'client')]
    private Collection $audit;

    /**
     * @var Collection<int, Invoice>
     */
    #[ORM\OneToMany(targetEntity: Invoice::class, mappedBy: 'client')]
    private Collection $invoices;

    #[ORM\Column(length: 50)]
    private ?string $siret = null;

    #[ORM\Column(length: 150)]
    private ?string $adress = null;

    #[ORM\Column(length: 100)]
    private ?string $city = null;

    #[ORM\Column(length: 20)]
    private ?string $postal_code = null;

    #[ORM\Column(enumType: Client_status::class)]
    private ?Client_status $status = null;

    // user relation removed

    public function __construct()
    {
        
        $this->audit = new ArrayCollection();
        $this->invoices = new ArrayCollection();
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

    // email accessors removed

    // Certification relation removed

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
            $audit->setClient($this);
        }

        return $this;
    }

    public function removeAudit(Audit $audit): static
    {
        if ($this->audit->removeElement($audit)) {
            // set the owning side to null (unless already changed)
            if ($audit->getClient() === $this) {
                $audit->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setClient($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getClient() === $this) {
                $invoice->setClient(null);
            }
        }

        return $this;
    }

    // user accessors removed

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getStatus(): ?Client_status
    {
        return $this->status;
    }

    public function setStatus(Client_status $status): static
    {
        $this->status = $status;

        return $this;
    }
}
