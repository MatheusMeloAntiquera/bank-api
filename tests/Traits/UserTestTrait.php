<?php

namespace Tests\Traits;

use Faker\Generator;
use App\Domain\User\DtoUserCreate;

trait UserTestTrait
{
    protected function returnAUserInsertable(Generator $faker)
    {
        return new DtoUserCreate(
            name: $faker->name(),
            email: $faker->freeEmail(),
            password: $faker->password(),
            cpf: $faker->cpf(false),
        );
    }
}
