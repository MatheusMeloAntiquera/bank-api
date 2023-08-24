<?php

namespace App\Domain\Store;

use App\Domain\Store\Store;

interface StoreRepositoryInterface
{
    public function createNewStore(Store $store): Store;
    public function updateStore(Store $store): Store;
    public function deleteStore(Store $store): void;
    public function findStore(int $id): Store|null;
    public function findStoreByEmail(string $email): Store|null;
    public function updateBalance(Store $store, float $newValue): void;
    public function findStoreByCnpj(string $cnpj): Store|null;
}
