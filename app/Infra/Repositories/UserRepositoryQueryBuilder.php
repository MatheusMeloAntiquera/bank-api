<?php

namespace App\Infra\Repositories;

use App\Domain\User\User;
use Illuminate\Support\Facades\DB;
use App\Domain\User\UserRepositoryInterface;

class UserRepositoryQueryBuilder implements UserRepositoryInterface
{
    private string $table = "users";
    public function createNewUser(User $user): User
    {
        $createdAt = now();
        $user->id = DB::table($this->table)->insertGetId([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'cpf' => $user->cpf,
            'balance' => $user->balance,
            'active' => $user->active,
            'created_at' => $createdAt,
        ]);

        $user->createdAt = $createdAt;
        return $user;
    }

    public function updateUser(User $user): User
    {
        $updatedAt = now();
        DB::table($this->table)->where('id', $user->id)->update([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'cpf' => $user->cpf,
            'balance' => $user->balance,
            'active' => $user->active,
            'updated_at' => $updatedAt,
        ]);

        $user->updatedAt = $updatedAt;
        return $user;
    }

    public function deleteUser(User $user): void
    {
        DB::table($this->table)->where('id', $user->id)->delete();
    }

    public function findUser(int $id): User|null
    {
        $result = DB::table($this->table)->where('id', $id)->first();

        if (empty($result)) {
            return null;
        }

        return new User(
            $result->id,
            $result->name,
            $result->email,
            $result->password,
            $result->balance,
            $result->cpf,
            $result->active,
            $result->created_at,
            $result->updated_at
        );
    }


}
