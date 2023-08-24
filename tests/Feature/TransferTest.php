<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\UserTestTrait;
use Tests\Traits\StoreTestTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use App\Domain\User\UserServiceInterface;
use App\Domain\User\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;



class TransferTest extends TestCase
{
    use RefreshDatabase;
    use UserTestTrait;
    use StoreTestTrait;

    protected UserServiceInterface $userService;
    protected UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        $this->createApplication();
        $this->userService = App::make(UserServiceInterface::class);
        $this->userRepository = App::make(UserRepositoryInterface::class);
        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function shouldExecuteTransferSucessfully()
    {
        $sender = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));
        $recipient = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));

        $this->userRepository->updateBalance($sender, 100.0);

        $response = $this->postJson("/api/transfer", [
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
    public function shouldNotExecuteTransferBecauseUserHasNotBalance()
    {
        $sender = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));
        $recipient = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));

        $response = $this->postJson("/api/transfer", [
            "sender_id" => $sender->id,
            "recipient_id" => $recipient->id,
            "value" => 50.0
        ]);

        $response->assertStatus(403);
        $this->assertSame("The sender don't have sufficient balance to execute this transfer", $response['message']);
    }

    /**
     * @test
     * @return void
     */
    public function shouldNotPossibleToTransferBecauseExternalServiceWasNotAuthorized()
    {
        Http::fake([
            'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6' => Http::response([
                "message" => "Não autorizado"
            ], 403)
        ]);

        $sender = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));
        $recipient = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));

        $this->userRepository->updateBalance($sender, 100.0);

        $response = $this->postJson("/api/transfer", [
            "sender_id" => $sender->id,
            "recipient_id" => $recipient->id,
            "value" => 50.0
        ]);

        $response->assertStatus(403);
        $this->assertSame("The external service did not authorized this transaction", $response['message']);

        //Test if the rollback works
        $this->assertEquals(100, $this->userRepository->findUser($sender->id)->balance);
        $this->assertEquals(0, $this->userRepository->findUser($recipient->id)->balance);
    }
}
