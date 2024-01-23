<?php

namespace App\Dto\Planifications\Write;

class PlanificationsDtoWrite
{
    public function __construct(
        public string $date_debut,
        public string $heure_debut,
        public int $session_id,
        public int $intervenant_id,
        public int $cours_id,
    ) {
    }
}
