<?php

namespace App\Domain\User;

class DtoUserResponse
{
    public static function toArray(User $user): array
    {
        return [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "password" => $user->password,
            "cpf" => $user->cpf,
            "balance" => $user->balance,
            "active" => $user->active,
            "created_at" => $user->createdAt,
            "updated_at" => $user->updatedAt,
        ];
    }
}
