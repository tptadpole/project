<?php

namespace Tests\Feature;

use App\Models\Spu;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    public function testAdminPage()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin');
        $this->assertEquals(200, $response->status());
    }
}
