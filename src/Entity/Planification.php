<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlanificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanificationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Delete()
    ]
)]
class Planification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $date_debut = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $heure_debut = null;

    #[ORM\ManyToOne(inversedBy: 'planifications')]
    #[Groups(['read', 'write'])]
    private ?Session $planifie = null;

    #[ORM\ManyToOne(inversedBy: 'planifications')]
    #[Groups(['read', 'write'])]
    private ?Course $organise = null;

    #[ORM\ManyToOne(inversedBy: 'planifications')]
    #[Groups(['read', 'write'])]
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

    public function getPlanifie(): ?Session
    {
        return $this->planifie;
    }

    public function setPlanifie(?Session $planifie): static
    {
        $this->planifie = $planifie;

        return $this;
    }

    public function getOrganise(): ?Course
    {
        return $this->organise;
    }

    public function setOrganise(?Course $organise): static
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
