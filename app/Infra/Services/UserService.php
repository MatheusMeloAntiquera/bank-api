<?php

namespace App\Infra\Services;

use App\Domain\User\User;
use App\Domain\User\DtoUserCreate;
use App\Domain\User\DtoUserUpdate;
use App\Exceptions\NotFoundException;
use App\Domain\User\UserServiceInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Exceptions\InvalidArgumentException;

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
        $this->checkIfEmailIsAlreadyInUse($dto->email);
        $this->checkIfCpfIsAlreadyInUse($dto->cpf);

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

        $this->checkIfEmailIsAlreadyInUse($dto->email, $user);

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
            throw new NotFoundException("User not found");
        }
        return $user;
    }

    public function checkIfEmailIsAlreadyInUse(string $email, User $user = null): void
    {
        if ($this->userRepository->findUserByEmail($email) != null) {

            if (!empty($user) && $user->email == $email) {
                return;
            }

            throw new InvalidArgumentException("The e-mail is already in use");
        }
    }

    public function checkIfCpfIsAlreadyInUse(string $cpf, User $user = null): void
    {
        if ($this->userRepository->findUserByCpf($cpf) != null) {

            if (!empty($user) && $user->email == $cpf) {
                return;
            }

            throw new InvalidArgumentException("The cpf is already in use");
        }
    }
}
