<?php

namespace App\Domain\User;

use App\Domain\User\User;

interface UserRepository
{
    public function createNewUser(User $user): User;
    public function updateUser(User $user): User;
    public function deleteUser(User $user): void;
    public function findUser(int $id): User|null;
}
