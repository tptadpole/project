<?php

namespace Tests\Feature;

use App\Models\Sku;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
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
     * 測試賣家可以對未出貨商品進行出貨
     *
     * @return void
     */
    public function testSellerOrderItemUpdateSuccess()
    {
        $this->demoUserLoginIn();
        $sku = factory(Sku::class)->create([
            'stock' => '100',
        ]);
        $orderItem = factory(OrderItem::class)->create();
        $response = $this->call('PATCH', '/orderItem/1/update', [
            'status' => '運送中',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試賣家可以對未出貨商品進行出貨但是存貨不足所以取消出貨
     *
     * @return void
     */
    public function testSellerOrderItemUpdateSkuNotEnoughSuccess()
    {
        $this->demoUserLoginIn();
        $sku = factory(Sku::class)->create();
        $order = factory(Order::class)->create();
        $orderItem = factory(OrderItem::class)->create([
            'amount' => '100',
        ]);
        $response = $this->call('PATCH', '/orderItem/1/update', [
            'status' => '運送中',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試賣家可以對不存在的未出貨商品進行出貨或是取消
     *
     * @return void
     */
    public function testSellerOrderItemUpdateFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/orderItem/999/update');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試使用者在訂單內加入商品物品
     *
     * @return void
     */
    public function testOrderItemStoreSuccess()
    {
        $this->demoUserLoginIn();
        $sku = factory(Sku::class)->create();
        $cart = factory(CartItem::class)->create();
        $response = $this->call('GET', '/orderItem/1/store');
        $this->assertEquals(200, $response->status());
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
