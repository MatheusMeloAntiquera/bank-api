<?php

namespace App\Domain\User;

class DtoUserUpdate
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public float $balance;
    public function __construct(
        int $id,
        string $name,
        string $email,
        string $password,
        float $balance
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->balance = $balance;
    }
}
