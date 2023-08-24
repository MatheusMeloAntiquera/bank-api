<?php

namespace App\Infra\Repositories;

use App\Domain\Store\Store;
use App\Models\Store as StoreModel;
use App\Domain\Store\StoreRepositoryInterface;

class StoreRepositoryEloquent implements StoreRepositoryInterface
{
    public function createNewStore(Store $store): Store
    {
        $storeModel = new StoreModel();
        $storeModel->name = $store->name;
        $storeModel->email = $store->email;
        $storeModel->password = $store->password;
        $storeModel->cnpj = $store->cnpj;
        $storeModel->balance = $store->balance;
        $storeModel->active = $store->active;

        $storeModel->save();

        $store->id = $storeModel->id;
        $store->createdAt = $storeModel->created_at;
        $store->updatedAt = $storeModel->updated_at;
        return $store;
    }

    public function updateStore(Store $store): Store
    {
        $storeModel = StoreModel::find($store->id);
        $storeModel->name = $store->name;
        $storeModel->email = $store->email;
        $storeModel->password = $store->password;
        $storeModel->cnpj = $store->cnpj;
        $storeModel->balance = $store->balance;
        $storeModel->active = $store->active;

        $storeModel->save();

        $store->updatedAt = $storeModel->updated_at;

        return $store;
    }

    public function deleteStore(Store $store): void
    {
        $storeModel = StoreModel::find($store->id);
        $storeModel->delete();
    }

    public function findStore(int $id): Store|null
    {
        $storeModel = StoreModel::find($id);
        if (empty($storeModel)) {
            return null;
        }

        return Store::newStoreByArray($storeModel->toArray());
    }

    public function findStoreByEmail(string $email): Store|null
    {
        $storeModel = StoreModel::where('email', $email)->first();
        if (empty($storeModel)) {
            return null;
        }

        return Store::newStoreByArray($storeModel->toArray());
    }

    public function updateBalance(Store $store, float $newValue): void
    {
        $storeModel = StoreModel::find($store->id);
        $storeModel->balance = $newValue;
        $storeModel->save();
    }

}
