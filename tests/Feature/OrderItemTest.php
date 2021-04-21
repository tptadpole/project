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
     * test seller can see his orderItem page
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
     * test user can see his orderItem page
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
     * test user can update orderitem
     *
     * @return void
     */
    // public function testOrderItemUpdateSuccess()
    // {
    //     $this->demoUserLoginIn();
    //     $orderItem = OrderItem::create([
    //         'users_id' => '1',
    //         'order_id' => '1',
    //         'sku_id' => '1',
    //         'amount' => '1',
    //         'price' => '1',
    //         'status' => '出貨',
    //     ]);
    //     $response = $this->call('PATCH', '/orderItem/1/update');
    //     $this->assertEquals(302, $response->status());
    // }

    public function testSellerOrderItemUpdateSuccess()
    {
        $this->demoUserLoginIn();
        $sku = Sku::create([
            'users_id' => '1',
            'spu_id' => '2',
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
        ]);
        $orderItem = OrderItem::create([
            'users_id' => '1',
            'order_id' => '1',
            'sku_id' => '1',
            'amount' => '1',
            'price' => '1',
            'status' => '出貨',
        ]);
        $response = $this->call('PATCH', '/orderItem/1/update');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test user try to update a non exist orderitem
     *
     * @return void
     */
    // public function testOrderItemUpdateFailed()
    // {
    //     $this->demoUserLoginIn();
    //     $response = $this->call('PATCH', '/orderItem/999/update');
    //     $this->assertEquals(404, $response->status());
    // }

    /**
     * test user can store a new orderitem
     *
     * @return void
     */
    public function testOrderItemStoreSuccess()
    {
        $sku = Sku::create([
            'users_id' => '1',
            'spu_id' => '2',
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
        ]);
        $cart = CartItem::create([
            'users_id' => '1',
            'sku_id' => '1',
            'amount' => '1',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/orderItem/1/store');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test user try to store a non exist Orderitem
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
