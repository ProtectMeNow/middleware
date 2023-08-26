<?php

namespace App\Application\User\RegisterLogin;

use App\Domain\User\Repository\UserRepositoryInterface;

class RegisterLoginUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(RegisterLoginCommand $dto): RegisterLoginResponse
    {
        return new RegisterLoginResponse(
            $this->userRepository->registerLogin($dto->getEmail(), $dto->getPassword())
        );
    }
}
