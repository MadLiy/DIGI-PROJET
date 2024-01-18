<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[UniqueEntity("name")]
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
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
    )]
    #[Assert\Unique(
        message : "Ce nom de cours est déja utilisé"
    )]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
    )]
    // #[Assert\Range([
    //     'min' => 0.5,
    //     'max' => 8,
    //     "message"=> 'Le cours doit durer entre {{ min }} heure et {{ max }} heures.',
    // ])]
    #[Groups(['read', 'write'])]
    private ?float $duree = null;

    #[ORM\OneToMany(mappedBy: 'organise', targetEntity: Planification::class)]
    #[Groups(['read', 'write'])]
    private Collection $planifications;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'dispense')]
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

    public function getDuree(): ?float
    {
        return $this->duree;
    }

    public function setDuree(float $duree): static
    {
        $this->duree = $duree;

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
            $planification->setOrganise($this);
        }

        return $this;
    }

    public function removePlanification(Planification $planification): static
    {
        if ($this->planifications->removeElement($planification)) {
            // set the owning side to null (unless already changed)
            if ($planification->getOrganise() === $this) {
                $planification->setOrganise(null);
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

    public function addInstructor(User $instructor): static
    {
        if (!$this->users->contains($instructor)) {
            $this->users->add($instructor);
            $instructor->addDispense($this);
        }

        return $this;
    }

    public function removeInstructor(User $instructor): static
    {
        if ($this->users->removeElement($instructor)) {
            $instructor->removeDispense($this);
        }

        return $this;
    }
}
