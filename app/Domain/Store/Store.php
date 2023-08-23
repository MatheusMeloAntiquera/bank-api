<?php

namespace App\Domain\Store;

class Store
{
    public string|int|null $id;
    public string $name;
    public string $email;
    public string $password;
    public float $balance;
    public string $cnpj;
    public bool $active;

    public ?string $createdAt;
    public ?string $updatedAt;

    public function __construct(
        string|int|null $id,
        string $name,
        string $email,
        string $password,
        float $balance,
        string $cnpj,
        bool $active,
        ?string $createdAt = null,
        ?string $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->balance = $balance;
        $this->cnpj = $cnpj;
        $this->active = $active;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }


}
