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
     * test user can get into order page
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
        $sku = Sku::create([
            'users_id' => '1',
            'spu_id' => '2',
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/order/create');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test user can store his order
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
     * test user can destroy exist order
     *
     * @return void
     */
    public function testOrderDestroySuccess()
    {
        $this->demoUserLoginIn();

        Order::create([
            'users_id' => '1',
            'name' => 'test',
            'address' => 'test',
            'phone' => '0912345678',
            'total_amount' => '1',
            'status' => '出貨',
        ]);
        $response = $this->call('DELETE', '/order/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test user destroy a non exist order
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
