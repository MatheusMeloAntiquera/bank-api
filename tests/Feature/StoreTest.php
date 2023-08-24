<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\StoreTestTrait;
use Illuminate\Support\Facades\App;
use App\Exceptions\NotFoundException;
use App\Domain\Store\StoreServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    use RefreshDatabase;
    use StoreTestTrait;

    protected StoreServiceInterface $storeService;

    protected function setUp(): void
    {
        $this->createApplication();
        $this->storeService = App::make(StoreServiceInterface::class);
        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function shouldCreateAStoreSucessfully(): void
    {
        $store = $this->returnAStoreInsertable($this->fakerBr);

        $response = $this->postJson("/api/store/", [
            "name" => $store->name,
            "email" => $store->email,
            "password" => $store->password,
            "cnpj" => $store->cnpj
        ]);

        $response->assertStatus(201);
        $this->assertNotEmpty($response["id"]);
        $this->assertEquals($store->name, $response["name"]);
        $this->assertEquals($store->email, $response["email"]);
        $this->assertEquals($store->password, $response["password"]);
        $this->assertEquals($store->cnpj, $response["cnpj"]);
        $this->assertEquals(0.0, $response["balance"]);
        $this->assertEquals(true, $response["active"]);
        $this->assertNotEmpty($response["created_at"]);
        $this->assertNotEmpty($response["updated_at"]);
    }

    /**
     * @test
     * @return void
     */
    public function shouldUpdateAStoreSucessfully(): void
    {
        $store = $this->storeService->createNewStore($this->returnAStoreInsertable($this->fakerBr));

        $newName = $this->fakerBr->name();
        $newEmail = $this->fakerBr->email();
        $newPassword = $this->fakerBr->email();
        $newBalance = 250.50;

        $response = $this->putJson("/api/store/{$store->id}", [
            "name" => $newName,
            "email" => $newEmail,
            "password" => $newPassword,
            "cnpj" => $store->cnpj,
            "balance" => $newBalance
        ]);

        $response->assertStatus(200);
        $this->assertNotEmpty($response["id"]);
        $this->assertEquals($newName, $response["name"]);
        $this->assertEquals($newEmail, $response["email"]);
        $this->assertEquals($newPassword, $response["password"]);
        $this->assertEquals($store->cnpj, $response["cnpj"]);
        $this->assertEquals($newBalance, $response["balance"]);
        $this->assertEquals(true, $response["active"]);
        $this->assertNotEmpty($response["created_at"]);
        $this->assertNotEmpty($response["updated_at"]);
    }

    /**
     * @test
     * @return void
     */
    public function shouldFindAStoreByIdSucessfully(): void
    {
        $store = $this->storeService->createNewStore($this->returnAStoreInsertable($this->fakerBr));

        $response = $this->getJson("/api/store/{$store->id}");

        $response->assertStatus(200);
        $this->assertNotEmpty($response["id"]);
        $this->assertEquals($store->name, $response["name"]);
        $this->assertEquals($store->email, $response["email"]);
        $this->assertEquals($store->password, $response["password"]);
        $this->assertEquals($store->cnpj, $response["cnpj"]);
        $this->assertEquals(0.0, $response["balance"]);
        $this->assertEquals(true, $response["active"]);
        $this->assertNotEmpty($response["created_at"]);
        $this->assertNotEmpty($response["updated_at"]);

        //Second test to confirm if it is return the correct store
        $store2 = $this->storeService->createNewStore($this->returnAStoreInsertable($this->fakerBr));

        $response = $this->getJson("/api/store/{$store2->id}");

        $response->assertStatus(200);
        $this->assertNotEmpty($response["id"]);
        $this->assertEquals($store2->name, $response["name"]);
        $this->assertEquals($store2->email, $response["email"]);
        $this->assertEquals($store2->password, $response["password"]);
        $this->assertEquals($store2->cnpj, $response["cnpj"]);
        $this->assertEquals(0.0, $response["balance"]);
        $this->assertEquals(true, $response["active"]);
        $this->assertNotEmpty($response["created_at"]);
        $this->assertNotEmpty($response["updated_at"]);
    }

    /**
     * @test
     * @return void
     */
    public function shouldDeleteAStoreSucessfully(): void
    {
        $store = $this->storeService->createNewStore($this->returnAStoreInsertable($this->fakerBr));

        $response = $this->deleteJson("/api/store/{$store->id}");

        $response->assertNoContent();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage("Store not found");
        $this->storeService->findStore($store->id);
    }

    /**
     * @test
     * @return void
     */
    public function shouldNotFoundAStore(): void
    {
        $response = $this->getJson("/api/store/10");

        $response->assertStatus(404);
        $this->assertSame("Store not found", $response["message"]);

    }

    /**
     * @test
     * @return void
     */
    public function shouldNotAllowTwoStoreWithSameEmail(): void
    {
        $store = $this->returnAStoreInsertable($this->fakerBr);

        $this->postJson("/api/store/", [
            "name" => $store->name,
            "email" => $store->email,
            "password" => $store->password,
            "cnpj" => $store->cnpj
        ]);

        $response = $this->postJson("/api/store/", [
            "name" => $store->name,
            "email" => $store->email,
            "password" => $store->password,
            "cnpj" => $store->cnpj
        ]);

        $response->assertStatus(400);
        $this->assertSame("The e-mail is already in use", $response["message"]);

    }
}
