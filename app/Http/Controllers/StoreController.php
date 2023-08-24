<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Store\DtoStoreCreate;
use App\Domain\Store\DtoStoreUpdate;
use App\Domain\Store\DtoStoreResponse;
use App\Domain\Store\StoreServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class StoreController extends Controller
{
    private StoreServiceInterface $storeService;
    public function __construct(StoreServiceInterface $storeService)
    {
        $this->storeService = $storeService;
    }
    public function create(Request $request): JsonResponse
    {
        $store = $this->storeService->createNewStore(
            new DtoStoreCreate(
                $request->name,
                $request->email,
                $request->password,
                $request->cnpj,
            )
        );

        return response()->json(
            DtoStoreResponse::toArray($store),
            201
        );
    }

    public function update(Request $request, int $storeId): JsonResponse
    {
        $store = $this->storeService->updateStore(
            new DtoStoreUpdate(
                $storeId,
                $request->name,
                $request->email,
                $request->password,
                $request->balance,
            )
        );

        return response()->json(
            DtoStoreResponse::toArray($store),
            200
        );
    }

    public function findStoreById(Request $request, int $storeId): JsonResponse
    {
        return response()->json(
            DtoStoreResponse::toArray(
                $this->storeService->findStore(
                    $storeId
                )
            ),
            200
        );
    }

    public function delete(Request $request, int $storeId): JsonResponse
    {
        $this->storeService->removeStore($storeId);
        return response()->json(
            null,
            204
        );
    }
}
