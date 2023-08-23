<?php

namespace App\Domain\User;

class DtoUserCreate
{
    public string $name;
    public string $email;
    public string $password;
    public string $cpf;
    public function __construct(
        string $name,
        string $email,
        string $password,
        string $cpf
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->cpf = $cpf;
    }
}
