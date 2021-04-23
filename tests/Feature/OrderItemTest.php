<?php

namespace Tests\Feature;

use App\Models\Sku;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
    /**
     * 測試賣家可以進入到"未出貨訂單"的頁面
     *
     * @return void
     */
    public function testOrderPageIndexSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->get('/orderItem');
        $response->assertStatus(200);
    }

    /**
     * 測試買家可以進入到"我的訂單"的頁面
     *
     * @return void
     */
    public function testOrderPageShowSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->get('/orderItem/1');
        $response->assertStatus(200);
    }

    /**
     * 測試賣家可以對未出貨商品進行出貨或是取消
     *
     * @return void
     */
    public function testSellerOrderItemUpdateSuccess()
    {
        $this->demoUserLoginIn();
        $sku = factory(Sku::class)->create();
        $orderItem = factory(OrderItem::class)->create();
        $response = $this->call('PATCH', '/orderItem/1/update');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試使用者在訂單內加入不存在的商品
     *
     * @return void
     */
    public function testOrderItemStoreFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/orderItem/999/store');
        $this->assertEquals(404, $response->status());
    }
}
