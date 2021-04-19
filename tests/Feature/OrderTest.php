<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * test user can see his order page
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
     * test user can store his order
     *
     * @return void
     */
    public function testOrderStoreSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/order/store', [
            'users_id' => '1',
            'name' => 'test',
            'address' => 'test',
            'phone' => '0912345678',
            'total_amount' => '1',
            'status' => '出貨',
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
