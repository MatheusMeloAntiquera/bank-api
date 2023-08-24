<?php

namespace App\Domain\Store;

interface StoreServiceInterface
{
    public function createNewStore(DtoStoreCreate $dtoStore): Store;
    public function updateStore(DtoStoreUpdate $dtoStore): Store;
    public function removeStore(int $id): void;
    public function findStore(int $id): Store;
}
