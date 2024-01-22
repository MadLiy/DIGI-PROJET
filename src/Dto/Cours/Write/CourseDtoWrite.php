<?php

namespace App\Dto\Cours\Write;

use Symfony\Component\Validator\Constraints as Assert;

class CourseDtoWrite
{
   
    public ?string $name = null;

 
    public ?float $duree = null;

    
    
    public function getName(): ?string
{
    return $this->name;
}

public function getDuree(): ?float
{
    return $this->duree;
}

}
