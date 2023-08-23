<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\User\DtoUserCreate;
use App\Domain\User\DtoUserUpdate;
use App\Domain\User\DtoUserResponse;
use App\Domain\User\UserServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    private UserServiceInterface $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    public function create(Request $request): JsonResponse
    {
        $user = $this->userService->createNewUser(
            new DtoUserCreate(
                $request->name,
                $request->email,
                $request->password,
                $request->cpf,
            )
        );

        return response()->json(
            DtoUserResponse::toArray($user),
            201
        );
    }

    public function update(Request $request, int $userId): JsonResponse
    {
        $user = $this->userService->updateUser(
            new DtoUserUpdate(
                $userId,
                $request->name,
                $request->email,
                $request->password,
                $request->balance,
            )
        );

        return response()->json(
            DtoUserResponse::toArray($user),
            200
        );
    }

    public function findUserById(Request $request, int $userId): JsonResponse
    {
        return response()->json(
            DtoUserResponse::toArray(
                $this->userService->findUser(
                    $userId
                )
            ),
            200
        );
    }

    public function delete(Request $request, int $userId): JsonResponse
    {
        $this->userService->removeUser($userId);
        return response()->json(
            null,
            204
        );
    }
}
