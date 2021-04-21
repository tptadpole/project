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

    public function testAdminOrderItemPage()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/orderItem/index');
        $this->assertEquals(200, $response->status());
    }

    public function testAdminTransportOrderItemPage()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/orderItem/show');
        $this->assertEquals(200, $response->status());
    }

    public function testAdminOrderItemDisplayPage()
    {
        $orderItem = OrderItem::create([
            'users_id' => '1',
            'order_id' => '1',
            'sku_id' => '1',
            'amount' => '1',
            'price' => '1',
            'status' => '出貨',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/orderItem/1/display');
        $this->assertEquals(200, $response->status());
    }

    public function testAdminDestroyOrderItemSuccess()
    {
        $orderItem = OrderItem::create([
            'users_id' => '1',
            'order_id' => '1',
            'sku_id' => '1',
            'amount' => '1',
            'price' => '1',
            'status' => '出貨',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/orderItem/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    public function testAdminDestroyOrderItemFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/orderItem/999/destroy');
        $this->assertEquals(404, $response->status());
    }

    public function testAdminUpdateOrderItemSuccess()
    {
        $orderItem = OrderItem::create([
            'users_id' => '1',
            'order_id' => '1',
            'sku_id' => '1',
            'amount' => '1',
            'price' => '1',
            'status' => '出貨',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/orderItem/1/update');
        $this->assertEquals(302, $response->status());
    }

    public function testAdminUpdateOrderItemFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/orderItem/999/update');
        $this->assertEquals(404, $response->status());
    }
}
