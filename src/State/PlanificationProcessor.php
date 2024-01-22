<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Planification;
use App\Repository\CourseRepository;
use App\Repository\PlanificationRepository;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Date;

class PlanificationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private PlanificationRepository $planificationRepository,
        private UserRepository $userRepository,
        private CourseRepository $courseRepository,
        private SessionRepository $sessionRepository,
        private EntityManagerInterface $em
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        // dd('toto');
        // dd($context);
        // dd($data);
        
        $planification = new Planification;
        $planification->setDateDebut(new DateTimeImmutable($data->date_debut));
        $planification->setHeureDebut(new DateTimeImmutable($data->heure_debut));

        $session = $this->sessionRepository->find($data->session_id);
        $planification->setPlanifie($session);

        $intervenant = $this->userRepository->find($data->intervenant_id);
        $planification->setInterviens($intervenant);

        $cours = $this->courseRepository->find($data->cours_id);
        $planification->setOrganise($cours);

        $this->em->persist($planification);
        $this->em->flush();
        // $this->planificationRepository->save($planification);

        return new JsonResponse($planification);
    }
}
