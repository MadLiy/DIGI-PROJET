<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;

class UserRoleProvider implements ProviderInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Security $security)
        {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []) : object|array|null
    {
        return $this->security->getUser()->getRoles()  ?:new \Exception("L'utilisateur n'a pas été trouvé");
    }

}
