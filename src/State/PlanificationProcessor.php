<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\PlanificationsDto\Write\PlanificationsDtoWrite;
use App\Entity\Planification;
use App\Entity\Session;
use App\Repository\CourseRepository;
use App\Repository\PlanificationRepository;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlanificationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor, 
        private PlanificationRepository $planificationRepository,
        private UserRepository $userRepository,
        private CourseRepository $courseRepository,
        private SessionRepository $sessionRepository
    )
    {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        $planification = new Planification;
        $planification->setDateDebut($data->datedebut); 
        $planification->setHeureDebut($data->heure_debut);

        $session = $this->sessionRepository->getById($data->session_id);
        $planification->setPlanifie($session);

        $intervenant = $this->userRepository->getById($data->intervenant_id);
        $planification->setInterviens($intervenant);

        $cours = $this->courseRepository->getById($data->cours_id);
        $planification->setOrganise($cours);

        $this->planificationRepository->save($planification);

        return new JsonResponse();

    }
}
