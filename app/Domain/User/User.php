<?php

namespace App\Domain\User;

class User
{
    public string|int|null $id;
    public string $name;
    public string $email;
    public string $password;
    public float $balance;
    public string $cpf;
    public bool $active;

    public function __construct(
        string|int|null $id,
        string $name,
        string $email,
        string $password,
        float $balance,
        string $cpf,
        bool $active
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->balance = $balance;
        $this->cpf = $cpf;
        $this->active = $active;
    }


}
