<?php

namespace App\Entity;

use App\Repository\AuditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditRepository::class)]
class Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $start_date = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $end_date = null;

    #[ORM\Column(length: 30)]
    private ?string $reference = null;

    #[ORM\Column(length: 100)]
    private ?string $declared_perimetre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $synthesis = null;

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
}
