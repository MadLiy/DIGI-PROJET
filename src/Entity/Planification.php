<?php

namespace App\Entity;

use App\Repository\PlanificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanificationRepository::class)]
class Planification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date_debut = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $heure_debut = null;

    #[ORM\ManyToOne(inversedBy: 'planifications')]
    private ?session $planifie = null;

    #[ORM\ManyToOne(inversedBy: 'planifications')]
    private ?course $organise = null;

    #[ORM\ManyToOne(inversedBy: 'planifications')]
    private ?instructor $interviens = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeImmutable $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeImmutable
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeImmutable $heure_debut): static
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getPlanifie(): ?session
    {
        return $this->planifie;
    }

    public function setPlanifie(?session $planifie): static
    {
        $this->planifie = $planifie;

        return $this;
    }

    public function getOrganise(): ?course
    {
        return $this->organise;
    }

    public function setOrganise(?course $organise): static
    {
        $this->organise = $organise;

        return $this;
    }

    public function getInterviens(): ?instructor
    {
        return $this->interviens;
    }

    public function setInterviens(?instructor $interviens): static
    {
        $this->interviens = $interviens;

        return $this;
    }
}
