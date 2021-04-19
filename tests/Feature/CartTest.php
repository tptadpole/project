<?php

namespace Tests\Feature;

use App\Models\Sku;
use App\Models\CartItem;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CartTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * test user can see his cart page
     *
     * @return void
     */
    public function testCartPageSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }
    /**
     * test user can update a exist cart
     *
     * @return void
     */
    public function testCartUpdateSuccess()
    {
        $this->demoUserLoginIn();
        $cart = CartItem::create([
            'users_id' => '2',
            'sku_id' => '1',
            'amount' => '1',
        ]);
        $response = $this->call('PATCH', '/cart/1/update', [
            'users_id' => '10',
            'sku_id' => '10',
            'amount' => '10',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test user update to a non exist cart
     *
     * @return void
     */
    public function testCartUpdateFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/cart/999/update', [
            'users_id' => '10',
            'sku_id' => '10',
            'amount' => '10',
        ]);
        $this->assertEquals(404, $response->status());
    }

    /**
     * test user can destroy exist cart
     *
     * @return void
     */
    public function testCartDestroySuccess()
    {
        $this->demoUserLoginIn();
        $cart = CartItem::create([
            'users_id' => '2',
            'sku_id' => '1',
            'amount' => '1',
        ]);
        $response = $this->call('DELETE', '/cart/2/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test user destroy a non exist cart
     *
     * @return void
     */
    public function testCartDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/cart/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
