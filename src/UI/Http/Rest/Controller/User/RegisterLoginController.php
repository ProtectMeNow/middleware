<?php

namespace App\UI\Http\Rest\Controller\User;

use App\Application\User\RegisterLogin\RegisterLoginCommand;
use App\Application\User\RegisterLogin\RegisterLoginUseCase;
use App\Infrastructure\Shared\FormService;
use App\UI\Http\Rest\Form\User\RegisterLoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterLoginController extends AbstractController
{
    public function __construct(
        private FormService $formService,
        private RegisterLoginUseCase $useCase
    ) {
    }

    #[Route('cadastro/usuario/registrar-login', methods: ['POST'])]
    public function indexAction(Request $request): JsonResponse
    {
        $data = $this->formService->execute(RegisterLoginForm::class, $request->toArray());

        if (!($data instanceof FormInterface)) {
            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        /** @var RegisterLoginCommand */
        $dto = $data->getData();

        $userResponse = $this->useCase->execute($dto);

        return $this->json([
            'token' => $userResponse->user->lastToken(),
            'refreshToken' => $userResponse->user->lastRefreshToken(),
            'user' => $userResponse->user,
        ]);
    }
}
