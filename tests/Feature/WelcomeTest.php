<?php

namespace Tests\Feature;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
    /**
     * 測試遊客可以進入到首頁
     *
     * @return void
     */
    public function testNonRegisterWelcomeIndexPage()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試有註冊的人進入到首頁
     *
     * @return void
     */
    public function testUserWelcomeIndexPage()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }
}
