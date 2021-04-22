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
     * 測試admin可以進入到admin的購物車頁面
     *
     * @return void
     */
    public function testAdminCartPageSuccess()
    {
        $cart = factory(CartItem::class)->create();
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/cart');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試admin可以對購物車進行刪除
     *
     * @return void
     */
    public function testAdminCartDestroySuccess()
    {
        $this->demoUserLoginIn();
        $cart = factory(CartItem::class)->create();
        $response = $this->call('DELETE', '/admin/cart/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試admin對不存在的購物車進行刪除
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
