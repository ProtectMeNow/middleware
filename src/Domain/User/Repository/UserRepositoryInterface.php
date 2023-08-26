<?php

namespace App\Domain\User\Repository;

use App\Domain\User\User;

interface UserRepositoryInterface
{
    public function registerLogin(string $email, string $password): User;
}
