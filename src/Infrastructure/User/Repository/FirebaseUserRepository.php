<?php

namespace App\Infrastructure\User\Repository;

use App\Domain\User\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Kreait\Firebase\Auth\UserQuery;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Request\CreateUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FirebaseUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private Auth $auth
    ) {
    }

    public function registerLogin(string $email, string $password): User
    {
        $queryUser = UserQuery::all()
            ->withFilter('email', $email);
        $findUser = $this->auth->queryUsers($queryUser);

        if (count($findUser) > 0) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Este usuário já existe.');
        }

        $request = CreateUser::new()
            ->withEmail($email)
            ->withClearTextPassword($password);

        $userFirebase = $this->auth->createUser($request);
        $signInUser = $this->auth->signInWithEmailAndPassword($email, $password);

        return (new User($userFirebase->uid, $userFirebase->email))
            ->setLastToken($signInUser->idToken())
            ->setLastRefreshToken($signInUser->refreshToken());
    }
}
