<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[UniqueEntity("name")]
#[ApiResource(
    security:"is_granted('ROLE_STUDENT')",
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN') or object.owner == user"),
        new Delete(security: "is_granted('ROLE_ADMIN') or object.owner == user")
    ]
)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
    )]
    #[Assert\Unique(
        message: "Ce nom de Session est dèja utilisé"
    )]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
    )]
    #[assert\Date(
        message: "Ceci n'est pas une date valide"
    )]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $date_debut = null;

    #[ORM\Column]
    #[assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
    )]
    #[assert\Date(
        message: "Ceci n'est pas une date valide"
    )]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $date_fin = null;

    #[ORM\OneToMany(mappedBy: 'planifie', targetEntity: Planification::class)]
    #[Groups(['read', 'write'])]
    private Collection $planifications;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'participe')]
    #[Groups(['read', 'write'])]
    private Collection $users;


    public function __construct()
    {
        $this->planifications = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeImmutable $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeImmutable $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    /**
     * @return Collection<int, Planification>
     */
    public function getPlanifications(): Collection
    {
        return $this->planifications;
    }

    public function addPlanification(Planification $planification): static
    {
        if (!$this->planifications->contains($planification)) {
            $this->planifications->add($planification);
            $planification->setPlanifie($this);
        }

        return $this;
    }

    public function removePlanification(Planification $planification): static
    {
        if ($this->planifications->removeElement($planification)) {
            // set the owning side to null (unless already changed)
            if ($planification->getPlanifie() === $this) {
                $planification->setPlanifie(null);
            }
        }

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
            $user->addParticipe($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeParticipe($this);
        }

        return $this;
    }
}
