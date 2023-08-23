<?php

namespace App\Domain\Store;

class DtoStoreCreate
{
    public string $name;
    public string $email;
    public string $password;
    public string $cnpj;
    public function __construct(
        string $name,
        string $email,
        string $password,
        string $cnpj
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->cnpj = $cnpj;
    }
}
