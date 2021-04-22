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
     * 測試admin進入到admin的訂單頁面
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
     * 測試admin對訂單進行刪除
     *
     * @return void
     */
    public function testAdminOrderDestroySuccess()
    {
        $order = factory(Order::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/order/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試admin對不存在的訂單進行刪除
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
