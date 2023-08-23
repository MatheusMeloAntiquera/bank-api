<?php

namespace Tests\Traits;

use Faker\Generator;
use Faker\Factory as Faker;

trait UseFakerBr
{
    public Generator $fakerBr;
    public function setUpUseFakerBr()
    {
        $this->fakerBr = Faker::create('pt_BR');
    }
}
