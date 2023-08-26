<?php

namespace App\Domain\User;

class User implements \JsonSerializable
{
    private ?string $lastToken = null;
    private ?string $lastRefreshToken = null;

    public function __construct(
        private string $uid,
        private string $email
    ) {
    }

    public function lastToken(): ?string
    {
        return $this->lastToken;
    }

    public function setLastToken(string $token): self
    {
        $this->lastToken = $token;

        return $this;
    }

    public function lastRefreshToken(): ?string
    {
        return $this->lastRefreshToken;
    }

    public function setLastRefreshToken(string $refreshToken): self
    {
        $this->lastRefreshToken = $refreshToken;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'uid' => $this->uid,
            'email' => $this->email,
        ];
    }
}
