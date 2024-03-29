<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity("email")]
#[ApiResource(
    security: "is_granted('ROLE_STUDENT')",
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations: [
        new Get(security: "is_granted('ROLE_STUDENT') and object == user" || "is_granted('ROLE_ADMIN')"),
        new GetCollection(security: "is_granted('ROLE_ADMIN')" || "is_granted('ROLE_INSTRUCTOR')"),
        new Post(security: "is_granted('ROLE_ADMIN') or object == user", processor: UserPasswordHasher::class),
        new Delete(security: "is_granted('ROLE_ADMIN') or object == user"),
        new Patch(security: "is_granted('ROLE_ADMIN') or object == user", processor: UserPasswordHasher::class)
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
    )]
    #[Groups(['read', 'write'])]
    #[Assert\Email(
        message: "Cette addresse mail est dèja utilisée"
    )]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    #[assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
    )]
    // #[Assert\PasswordStrength([
    //     'minScore' => PasswordStrength::STRENGTH_MEDIUM,
    //     'message' => 'Votre mot de passe est trop simple et ne respecte pas les règles de securité'
    // ])]
    private ?string $password = null;

    #[Assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
        )]
    #[Groups(['read', 'write'])]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 100)]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
    )]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Groups(['read', 'write'])]
    #[assert\NotBlank(
        message: "Ce champs ne peux pas être vide"
    )]
    private ?string $lastName = null;

    #[ORM\OneToMany(mappedBy: 'interviens', fetch: "EAGER", targetEntity: Planification::class, cascade:["persist"])]
    #[Groups(['read', 'write'])]
    private Collection $planifications;

    #[ORM\ManyToMany(targetEntity: Course::class, fetch: "EAGER", inversedBy: 'users',cascade:["persist"])]
    #[Groups(['read', 'write'])]
    private Collection $dispense;

    #[ORM\ManyToMany(targetEntity: Session::class, fetch: "EAGER", inversedBy: 'users',cascade:["persist"])]
    #[Groups(['read', 'write'])]
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
        // guarantee every user at least has ROLE_STUDENT
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

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

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
