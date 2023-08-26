<?php

namespace App\Application\User\RegisterLogin;

use App\Domain\User\User;

class RegisterLoginResponse implements \JsonSerializable
{
    public function __construct(
        public User $user
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'user' => $this->user,
        ];
    }
}
