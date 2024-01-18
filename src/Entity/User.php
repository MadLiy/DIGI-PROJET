<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    // security: "is_granted('ROLE_USER')",
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations: [
        new Get(
            uriTemplate: '/users/{email}', 
            requirements: ['email' => '\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b'], 
        ),
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Delete()
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['email' => 'ipartial'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['read', 'write'])]

    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Groups(['read', 'write'])]
    private ?string $lastName = null;

    #[ORM\OneToMany(fetch: "EAGER",mappedBy: 'interviens', targetEntity: Planification::class)]
    #[Groups(['read', 'write'])]
    private Collection $planifications;

    #[ORM\ManyToMany(fetch: "EAGER",targetEntity: Course::class, inversedBy: 'users')]
    #[Groups(['read', 'write'])]
    private Collection $dispense;

    #[ORM\ManyToMany(fetch: "EAGER",targetEntity: Session::class, inversedBy: 'users')]
    private Collection $participe;

    public function __construct()
    {
        $this->planifications = new ArrayCollection();
        $this->dispense = new ArrayCollection();
        $this->participe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_STUDENT';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

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
            $planification->setInterviens($this);
        }

        return $this;
    }

    public function removePlanification(Planification $planification): static
    {
        if ($this->planifications->removeElement($planification)) {
            // set the owning side to null (unless already changed)
            if ($planification->getInterviens() === $this) {
                $planification->setInterviens(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, course>
     */
    public function getDispense(): Collection
    {
        return $this->dispense;
    }

    public function addDispense(Course $dispense): static
    {
        if (!$this->dispense->contains($dispense)) {
            $this->dispense->add($dispense);
        }

        return $this;
    }

    public function removeDispense(Course $dispense): static
    {
        $this->dispense->removeElement($dispense);

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getParticipe(): Collection
    {
        return $this->participe;
    }

    public function addParticipe(Session $participe): static
    {
        if (!$this->participe->contains($participe)) {
            $this->participe->add($participe);
        }

        return $this;
    }

    public function removeParticipe(Session $participe): static
    {
        $this->participe->removeElement($participe);

        return $this;
    }
}
