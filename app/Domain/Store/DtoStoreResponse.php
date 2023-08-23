<?php

namespace App\Domain\Store;

use App\Domain\Store\Store;

class DtoStoreResponse
{
    public static function toArray(Store $store): array
    {
        return [
            "id" => $store->id,
            "name" => $store->name,
            "email" => $store->email,
            "password" => $store->password,
            "cnpj" => $store->cnpj,
            "balance" => $store->balance,
            "active" => $store->active,
            "created_at" => $store->createdAt,
            "updated_at" => $store->updatedAt,
        ];
    }
}
