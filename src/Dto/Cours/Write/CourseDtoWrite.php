<?php

namespace App\Dto\Cours\Write;

use Symfony\Component\Validator\Constraints as Assert;

class CourseDtoWrite
{
    /**
     * @Assert\NotBlank(message="Le nom du cours ne peut pas être vide.")
     * @Assert\Length(max=100, maxMessage="Le nom du cours ne peut pas dépasser {{ 150 }} caractères.")
     */
    public ?string $name = null;

    /**
     * @Assert\NotBlank(message="La durée du cours ne peut pas être vide.")
     * @Assert\Range(
     *     min=0.5,
     *     max=8,
     *     minMessage="Le cours doit durer au minimum {{ 0.5 }} heure.",
     *     maxMessage="Le cours ne peut pas durer plus de {{ 24 }} heures."
     * )
     */
    public ?float $duree = null;

    /**
     * @var int|null 
     */
    public ?int $userId = null;
    public function getName(): ?string
{
    return $this->name;
}

public function getDuree(): ?float
{
    return $this->duree;
}

}
