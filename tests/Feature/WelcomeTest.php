<?php

namespace Tests\Feature;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    use DatabaseTransactions;

    public function testWelcomeIndexPage()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }
}
