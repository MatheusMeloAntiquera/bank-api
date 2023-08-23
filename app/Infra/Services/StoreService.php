<?php

namespace App\Infra\Services;

use App\Domain\Store\Store;
use App\Domain\Store\DtoStoreCreate;
use App\Domain\Store\DtoStoreUpdate;
use App\Exceptions\NotFoundException;
use App\Domain\Store\StoreServiceInterface;
use App\Domain\Store\StoreRepositoryInterface;
use App\Exceptions\InvalidArgumentException;

final class StoreService implements StoreServiceInterface
{
    private StoreRepositoryInterface $storeRepository;

    public function __construct(
        StoreRepositoryInterface $storeRepository
    ) {
        $this->storeRepository = $storeRepository;
    }
    public function createNewStore(DtoStoreCreate $dto): Store
    {
        $this->checkIfEmailIsAlreadyInUse($dto->email);

        return $this->storeRepository->createNewStore(
            new Store(
                id: null,
                name: $dto->name,
                email: $dto->email,
                password: $dto->password,
                cnpj: $dto->cnpj,
                balance: 0.00,
                active: true
            )
        );
    }
    public function updateStore(DtoStoreUpdate $dto): Store
    {
        $store = $this->findStore($dto->id);

        $this->checkIfEmailIsAlreadyInUse($dto->email, $store);

        $store->name = $dto->name;
        $store->email = $dto->email;
        $store->password = $dto->password;
        $store->balance = $dto->balance;

        return $this->storeRepository->updateStore($store);
    }


    public function removeStore(int $id): void
    {
        $this->storeRepository->deleteStore($this->findStore($id));
    }
    public function findStore(int $id): Store
    {

        $store = $this->storeRepository->findStore($id);

        if (empty($store)) {
            throw new NotFoundException("Store not found");
        }
        return $store;
    }

    public function checkIfEmailIsAlreadyInUse(string $email, Store $store = null): void
    {
        dump($this->storeRepository->findStoreByEmail($email));
        if ($this->storeRepository->findStoreByEmail($email) != null) {

            if (!empty($store) && $store->email == $email) {
                return;
            }

            throw new InvalidArgumentException("The e-mail is already in use");
        }
    }
}
