<?php

namespace Tests\Feature;

use App\Models\Spu;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
    
    /**
     * test user can get into customer page
     *
     * @return void
     */
    public function testCustomerTotalSuccess()
    {
        $response = $this->get('/customer');

        $response->assertStatus(200);
    }

    /**
     * test customer choose a commodity from customer page
     *
     * @return void
     */
    public function testCustomerPickSuccess()
    {
        Spu::create([
            'users_id' => '999',
            'name' => '測試商品標題',
            'description' => 'test',
        ]);

        $response = $this->get('/customer/1');
        $response->assertStatus(200);
    }

    /**
     * test customer try to choose a not exist commodity from customer page
     *
     * @return void
     */
    public function testCustomerPickFailed()
    {
        $response = $this->get('/customer/999');
        $response->assertStatus(404);
    }
}
