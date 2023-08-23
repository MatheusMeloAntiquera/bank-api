<?php

namespace App\Domain\User;

interface UserServiceInterface
{
    public function createNewUser(DtoUserCreate $dtoUser): User;
    public function updateUser(DtoUserUpdate $dtoUser): User;
    public function removeUser(int $id): void;
    public function findUser(int $id): User;
}
