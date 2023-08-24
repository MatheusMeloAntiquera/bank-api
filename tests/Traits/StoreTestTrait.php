<?php

namespace Tests\Traits;

use Faker\Generator;
use App\Domain\Store\DtoStoreCreate;

trait StoreTestTrait
{
    protected function returnAStoreInsertable(Generator $faker)
    {
        return new DtoStoreCreate(
            name: $faker->name(),
            email: $faker->freeEmail(),
            password: $faker->password(),
            cnpj: $faker->cnpj(false),
        );
    }
}
