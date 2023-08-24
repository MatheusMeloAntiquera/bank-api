<?php

namespace App\Domain\User;

use App\Domain\User\User;

interface UserRepositoryInterface
{
    public function createNewUser(User $user): User;
    public function updateUser(User $user): User;
    public function deleteUser(User $user): void;
    public function findUser(int $id): User|null;
    public function findUserByEmail(string $email): User|null;
    public function updateBalance(User $user, float $newValue): void;
    public function findUserByCpf(string $cpf): User|null;

}
