<?php

namespace Src\Infrastructure\Controller;

use Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Src\Application\UseCase\RegisterUserUseCase;
use Src\Application\DTO\RegisterUserRequest;
use Src\Application\DTO\UserResponseDTO;


class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['email'], $data['password'])) {
            return new JsonResponse(['error' => 'Datos incompletos'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $dto = new RegisterUserRequest(
            $data['name'],
            $data['email'],
            $data['password']
        );

        try {
            $user = $this->registerUserUseCase->execute($dto);

            $userResponse = new UserResponseDTO($user);
            $userReponseArray = $userResponse->toArray();

            return new JsonResponse($userReponseArray, JsonResponse::HTTP_CREATED);

        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}