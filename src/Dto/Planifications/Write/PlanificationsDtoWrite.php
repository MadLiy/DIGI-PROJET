<?php
namespace App\Dto\PlanificationsDtoWrite;

class PlanificationsDtoWrite{
    public function __construct(
        int $session_id,
        int $intervenant_id,
        int $cours_id,
        string $date_debut,
        string $heure_debut,
    )
    {}
}