<?php

namespace App\Infra\Services;

use App\Domain\User\User;
use App\Domain\User\DtoUserCreate;
use App\Domain\User\DtoUserUpdate;
use App\Domain\User\UserServiceInterface;
use App\Domain\User\UserRepositoryInterface;

final class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }
    public function createNewUser(DtoUserCreate $dto): User
    {
        return $this->userRepository->createNewUser(
            new User(
                id: null,
                name: $dto->name,
                email: $dto->email,
                password: $dto->password,
                cpf: $dto->cpf,
                balance: 0.00,
                active: true
            )
        );
    }
    public function updateUser(DtoUserUpdate $dto): User
    {
        $user = $this->findUser($dto->id);

        $user->name = $dto->name;
        $user->email = $dto->email;
        $user->password = $dto->password;
        $user->balance = $dto->balance;

        return $this->userRepository->updateUser($user);
    }


    public function removeUser(int $id): void
    {
        $this->userRepository->deleteUser($this->findUser($id));
    }
    public function findUser(int $id): User
    {

        $user = $this->userRepository->findUser($id);

        if (empty($user)) {
            throw new \DomainException("User not found");
        }
        return $user;
    }
}
