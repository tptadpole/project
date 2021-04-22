<?php

namespace Tests\Feature;

use App\User;
use App\Models\Sku;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * 測試使用者可以進入到"我的訂單"的頁面
     *
     * @return void
     */
    public function testOrderPageSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->get('/order');
        $response->assertStatus(200);
    }

    /**
     * 測試使用者能夠進入下訂單頁面
     *
     * @return void
     */
    public function testOrderCreateSuccess()
    {
        $sku = factory(Sku::class)->create();
        $cart = factory(CartItem::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/order/create');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試使用者因為購物車沒東西所以導向購物車頁面
     *
     * @return void
     */
    public function testOrderCreateFailed()
    {
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/order/create');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試使用者新增一筆訂單
     *
     * @return void
     */
    public function testOrderStoreSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/order/store', [
            'name' => 'test',
            'address' => 'test',
            'phone' => '0912345678',
            'total_amount' => '1',
            'payment' => 'cash',
        ]);
        $this->assertEquals(302, $response->status());
    }
    
    /**
     * 測試使用者可以對於訂單進行刪除
     *
     * @return void
     */
    public function testOrderDestroySuccess()
    {
        $this->demoUserLoginIn();

        $order = factory(Order::class)->create();
        $response = $this->call('DELETE', '/order/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試使用者對於不存在的訂單進行刪除
     *
     * @return void
     */
    public function testOrderDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/order/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
