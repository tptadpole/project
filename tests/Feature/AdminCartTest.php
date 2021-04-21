<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Sku;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCartTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * test admin can get into admin cart page
     *
     * @return void
     */
    public function testAdminCartPageSuccess()
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
        $response = $this->call('GET', '/admin/cart');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test admin can destroy cart
     *
     * @return void
     */
    public function testAdminCartDestroySuccess()
    {
        $this->demoUserLoginIn();
        $cart = CartItem::create([
            'users_id' => '1',
            'sku_id' => '1',
            'amount' => '1',
        ]);
        $response = $this->call('DELETE', '/admin/cart/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test admin try to destroy a non exist cart
     *
     * @return void
     */
    public function testAdminCartDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/cart/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
