<?php

namespace Tests\Feature;

use App\Models\OrderItem;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    use DatabaseTransactions;

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

    public function testOrderItemUpdateSuccess()
    {
        $this->demoUserLoginIn();
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
}
