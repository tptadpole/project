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
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * test user can get into cart page
     *
     * @return void
     */
    public function testCartPageSuccess()
    {
        $cart = CartItem::create([
            'users_id' => '1',
            'sku_id' => '1',
            'amount' => '1',
        ]);
        $sku = Sku::create([
            'users_id' => '1',
            'spu_id' => '2',
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
            'image' => 'test',
        ]);
        $this->demoUserLoginIn();
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }
    /**
     * test user can update cart
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
            'image' => 'test',
        ]);
        $response = $this->call('PATCH', '/cart/1/update', [
            'users_id' => '10',
            'sku_id' => '10',
            'amount' => '10',
            'image' => 'testUpdateImage',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test user try to update to a non exist cart
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
     * test user can destroy cart
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
        $response = $this->call('DELETE', '/cart/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test user try to destroy a non exist cart
     *
     * @return void
     */
    public function testCartDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/cart/999/destroy');
        $this->assertEquals(404, $response->status());
    }

    /**
     * test user can edit cart
     *
     * @return void
     */
    public function testCartEditSuccess()
    {
        $cart = CartItem::create([
            'users_id' => '1',
            'sku_id' => '1',
            'amount' => '1',
        ]);

        $sku = Sku::create([
            'users_id' => '1',
            'spu_id' => '2',
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/cart/1/edit');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test user try to edit a non exist cart
     *
     * @return void
     */
    public function testCartEditWithoutCartFailed()
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
        $response = $this->call('GET', '/cart/1/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * test user try to edit a cart with a non exist sku
     *
     * @return void
     */
    public function testCartEditWithoutSkuFailed()
    {
        $cart = CartItem::create([
            'users_id' => '1',
            'sku_id' => '1',
            'amount' => '1',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/cart/1/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * test user can store a sku to cart
     *
     * @return void
     */
    public function testCartStoreSuccess()
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
        $response = $this->call('POST', '/cart/1/store', [
            "amount" => '1',
        ]);
        $this->assertEquals(302, $response->status());
    }
}
