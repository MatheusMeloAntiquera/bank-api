<?php

namespace Tests\Feature;

use Tests\TestCase;
use DomainException;
use Tests\Traits\UserTestTrait;
use Illuminate\Support\Facades\App;
use App\Exceptions\NotFoundException;
use App\Domain\User\UserServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use UserTestTrait;

    protected UserServiceInterface $userService;

    protected function setUp(): void
    {
        $this->createApplication();
        $this->userService = App::make(UserServiceInterface::class);
        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function shouldCreateAUserSucessfully(): void
    {
        $user = $this->returnAUserInsertable($this->fakerBr);

        $response = $this->postJson("/api/user/", [
            "name" => $user->name,
            "email" => $user->email,
            "password" => $user->password,
            "cpf" => $user->cpf
        ]);

        $response->assertStatus(201);
        $this->assertNotEmpty($response["id"]);
        $this->assertEquals($user->name, $response["name"]);
        $this->assertEquals($user->email, $response["email"]);
        $this->assertEquals($user->password, $response["password"]);
        $this->assertEquals($user->cpf, $response["cpf"]);
        $this->assertEquals(0.0, $response["balance"]);
        $this->assertEquals(true, $response["active"]);
        $this->assertNotEmpty($response["created_at"]);
        $this->assertEmpty($response["updated_at"]);
    }

    /**
     * @test
     * @return void
     */
    public function shouldUpdateAUserSucessfully(): void
    {
        $user = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));

        $newName = $this->fakerBr->name();
        $newEmail = $this->fakerBr->email();
        $newPassword = $this->fakerBr->email();
        $newBalance = 250.50;

        $response = $this->putJson("/api/user/{$user->id}", [
            "name" => $newName,
            "email" => $newEmail,
            "password" => $newPassword,
            "cpf" => $user->cpf,
            "balance" => $newBalance
        ]);

        $response->assertStatus(200);
        $this->assertNotEmpty($response["id"]);
        $this->assertEquals($newName, $response["name"]);
        $this->assertEquals($newEmail, $response["email"]);
        $this->assertEquals($newPassword, $response["password"]);
        $this->assertEquals($user->cpf, $response["cpf"]);
        $this->assertEquals($newBalance, $response["balance"]);
        $this->assertEquals(true, $response["active"]);
        $this->assertNotEmpty($response["created_at"]);
        $this->assertNotEmpty($response["updated_at"]);
    }

    /**
     * @test
     * @return void
     */
    public function shouldFindAUserByIdSucessfully(): void
    {
        $user = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));

        $response = $this->getJson("/api/user/{$user->id}");

        $response->assertStatus(200);
        $this->assertNotEmpty($response["id"]);
        $this->assertEquals($user->name, $response["name"]);
        $this->assertEquals($user->email, $response["email"]);
        $this->assertEquals($user->password, $response["password"]);
        $this->assertEquals($user->cpf, $response["cpf"]);
        $this->assertEquals(0.0, $response["balance"]);
        $this->assertEquals(true, $response["active"]);
        $this->assertNotEmpty($response["created_at"]);
        $this->assertEmpty($response["updated_at"]);

        //Second test to confirm if it is return the correct user
        $user2 = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));

        $response = $this->getJson("/api/user/{$user2->id}");

        $response->assertStatus(200);
        $this->assertNotEmpty($response["id"]);
        $this->assertEquals($user2->name, $response["name"]);
        $this->assertEquals($user2->email, $response["email"]);
        $this->assertEquals($user2->password, $response["password"]);
        $this->assertEquals($user2->cpf, $response["cpf"]);
        $this->assertEquals(0.0, $response["balance"]);
        $this->assertEquals(true, $response["active"]);
        $this->assertNotEmpty($response["created_at"]);
        $this->assertEmpty($response["updated_at"]);
    }

    /**
     * @test
     * @return void
     */
    public function shouldDeleteAUserSucessfully(): void
    {
        $user = $this->userService->createNewUser($this->returnAUserInsertable($this->fakerBr));

        $response = $this->deleteJson("/api/user/{$user->id}");

        $response->assertNoContent();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage("User not found");
        $this->userService->findUser($user->id);
    }

    /**
     * @test
     * @return void
     */
    public function shouldNotFoundAUser(): void
    {
        $response = $this->getJson("/api/user/10");

        $response->assertStatus(404);
        $this->assertSame("User not found", $response["message"]);

    }

    /**
     * @test
     * @return void
     */
    public function shouldNotAllowTwoUserWithSameEmail(): void
    {
        $user = $this->returnAUserInsertable($this->fakerBr);

        $this->postJson("/api/user/", [
            "name" => $user->name,
            "email" => $user->email,
            "password" => $user->password,
            "cpf" => $user->cpf
        ]);

        $response = $this->postJson("/api/user/", [
            "name" => $user->name,
            "email" => $user->email,
            "password" => $user->password,
            "cpf" => $user->cpf
        ]);

        $response->assertStatus(400);
        $this->assertSame("The e-mail is already in use", $response["message"]);

    }

    /**
     * @test
     * @return void
     */
    public function shouldNotAllowTwoUserWithSameCpf(): void
    {
        $user = $this->returnAUserInsertable($this->fakerBr);

        $this->postJson("/api/user/", [
            "name" => $user->name,
            "email" => $user->email,
            "password" => $user->password,
            "cpf" => $user->cpf
        ]);

        $response = $this->postJson("/api/user/", [
            "name" => $user->name,
            "email" => $this->fakerBr->email(),
            "password" => $user->password,
            "cpf" => $user->cpf
        ]);

        $response->assertStatus(400);
        $this->assertSame("The cpf is already in use", $response["message"]);

    }
}
