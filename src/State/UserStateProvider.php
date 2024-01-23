<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\UserGetDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UserStateProvider implements ProviderInterface
{
    // public function __construct(
    //     #[Autowire('api_platform.doctrine.orm.state.item_provider')]
    //     private ProviderInterface $itemProvider,
    // )
    // {
    // }

    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }


    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // echo "Operation: ";
        // dd ($operation);
        // echo "URI Variables: ";
        // dd($uriVariables);
        // echo "Context: ";
        // dd($context);

       // $user = $this->itemProvider->provide($operation, $uriVariables, $context);
        $user= $this->userRepository->find($uriVariables['id']);

         dd(new UserGetDto($user));
    }
}
