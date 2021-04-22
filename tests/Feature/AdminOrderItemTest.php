<?php

namespace Tests\Feature;

use App\Models\OrderItem;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderItemTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * 測試admin可以進入到admin的訂單商品頁面
     *
     * @return void
     */
    public function testAdminOrderItemPage()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/orderItem/index');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試admin可以進入到查看所有運輸中的訂單商品頁面
     *
     * @return void
     */
    public function testAdminTransportOrderItemPage()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/orderItem/show');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試admin可以進入到訂單的查看更多頁面
     *
     * @return void
     */
    public function testAdminOrderItemDisplayPage()
    {
        $orderItem = factory(OrderItem::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/orderItem/1/display');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試admin可以對訂單商品進行刪除
     *
     * @return void
     */
    public function testAdminDestroyOrderItemSuccess()
    {
        $orderItem = factory(OrderItem::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/orderItem/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試admin對不存在的訂單商品進行刪除
     *
     * @return void
     */
    public function testAdminDestroyOrderItemFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/orderItem/999/destroy');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試admin對運送中的訂單商品進行狀態更新(運送中->取貨)
     *
     * @return void
     */
    public function testAdminUpdateOrderItemSuccess()
    {
        $orderItem = factory(OrderItem::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/orderItem/1/update');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試admin對不存在的訂單商品進行狀態更新(運送中->取貨)
     *
     * @return void
     */
    public function testAdminUpdateOrderItemFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/orderItem/999/update');
        $this->assertEquals(404, $response->status());
    }
}
