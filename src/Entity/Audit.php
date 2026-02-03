<?php

namespace App\Entity;

use App\Enum\Audit_status;
use App\Repository\AuditRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AuditRepository::class)]
class Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'La date de début est requise.')]
    private ?\DateTime $start_date = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThan(propertyPath: 'start_date', message: 'La date de fin doit être postérieure à la date de début.')]
    private ?\DateTime $end_date = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'La référence ne peut pas être vide.')]
    #[Assert\Length(max: 30)]
    private ?string $reference = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le périmètre déclaré ne peut pas être vide.')]
    #[Assert\Length(max: 100)]
    private ?string $declared_perimetre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $synthesis = null;

    #[ORM\Column(enumType: Audit_status::class)]
    private ?Audit_status $status = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'audit')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'audit')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'audit')]
    private ?Invoice $invoice = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTime $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTime $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
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

    public function getDeclaredPerimetre(): ?string
    {
        return $this->declared_perimetre;
    }

    public function setDeclaredPerimetre(string $declared_perimetre): static
    {
        $this->declared_perimetre = $declared_perimetre;

        return $this;
    }


    public function getSynthesis(): ?string
    {
        return $this->synthesis;
    }

    public function setSynthesis(?string $synthesis): static
    {
        $this->synthesis = $synthesis;

        return $this;
    }

    public function getStatus(): ?Audit_status
    {
        return $this->status;
    }

    public function setStatus(Audit_status $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addAudit($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeAudit($this);
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }
}
