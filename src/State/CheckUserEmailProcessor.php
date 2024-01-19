<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckUserEmailProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ProcessorInterface $processor){}
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if(is_null($this->userRepository->findOneBy(["email" => $data->email])->getEmail() )){
            return new NotFoundHttpException("Adresse email introuvable.");
        }
        return new JsonResponse(["email" => $data->email]);
    }
}
