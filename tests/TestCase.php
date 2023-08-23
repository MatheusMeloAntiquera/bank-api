<?php

namespace Tests;

use Tests\Traits\UseFakerBr;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use UseFakerBr;
}
