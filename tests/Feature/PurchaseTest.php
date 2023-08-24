<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\UserTestTrait;
use Tests\Traits\StoreTestTrait;
use Illuminate\Support\Facades\App;
use App\Domain\User\UserServiceInterface;
use App\Domain\Store\StoreServiceInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\Store\StoreRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;



class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    use UserTestTrait;
    use StoreTestTrait;

    protected UserServiceInterface $userService;
    protected StoreServiceInterface $storeService;
    protected UserRepositoryInterface $userRepository;
    protected StoreRepositoryInterface $storeRepository;

    protected function setUp(): void
    {
        $this->createApplication();

        $this->userService = App::make(UserServiceInterface::class);
        $this->storeService = App::make(StoreServiceInterface::class);

        $this->userRepository = App::make(UserRepositoryInterface::class);
        $this->storeRepository = App::make(StoreRepositoryInterface::class);

        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function shouldExecuteAPurchaseSucessfully()
    {
        $sender = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));
        $recipient = $this->storeService->createNewStore($this->returnAStoreInsertable($this->fakerBr));

        $this->userRepository->updateBalance($sender, 100.0);

        $response = $this->postJson("/api/purchase", [
            "sender_id" => $sender->id,
            "recipient_id" => $recipient->id,
            "value" => 50.0
        ]);

        $response->assertStatus(201);
        $this->assertNotEmpty($response["id"]);
        $this->assertEquals($sender->id, $response["sender_id"]);
        $this->assertEquals($recipient->id, $response["recipient_id"]);
        $this->assertEquals(50.0, $response["value"]);
        $this->assertEquals(100.0, $response["sender_balance"]);
        $this->assertEquals($recipient->balance, $response["recipient_balance"]);
        $this->assertNotEmpty($response["created_at"]);
        $this->assertEmpty($response["updated_at"]);

        $this->assertEquals(50.0, $this->userRepository->findUser($sender->id)->balance);
        $this->assertEquals(50.0, $this->userRepository->findUser($recipient->id)->balance);
    }

    /**
     * @test
     * @return void
     */
    public function shouldNotExecutePurchaseBecauseTheUserHasNotBalance()
    {
        $sender = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));
        $recipient = $this->storeService->createNewStore($this->returnAStoreInsertable($this->fakerBr));

        $response = $this->postJson("/api/purchase", [
            "sender_id" => $sender->id,
            "recipient_id" => $recipient->id,
            "value" => 50.0
        ]);

        $response->assertStatus(403);
        $this->assertSame("The sender don't have sufficient balance to execute this transfer", $response['message']);
    }

    //Todo: Implement test when have problem with external service authorization
}
