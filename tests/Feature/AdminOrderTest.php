<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * test admin can get into admin order page
     *
     * @return void
     */
    public function testAdminOrderPageSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/order');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test admin can destroy order
     *
     * @return void
     */
    public function testAdminOrderDestroySuccess()
    {
        $order = Order::create([
            'users_id' => '1',
            'name' => 'test',
            'address' => 'test',
            'phone' => '0912345678',
            'total_amount' => '1',
            'status' => '出貨',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/order/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test admin try to destroy a non exist order
     *
     * @return void
     */
    public function testAdminOrderDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/order/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
