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
     * 測試使用者可以進入到購物車頁面
     *
     * @return void
     */
    public function testCartPageSuccess()
    {
        $cart = factory(CartItem::class)->create();
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }
    /**
     * 測試使用者對於商品進行更改購買數量
     *
     * @return void
     */
    public function testCartUpdateSuccess()
    {
        $this->demoUserLoginIn();
        $cart = factory(CartItem::class)->create();
        $response = $this->call('PATCH', '/cart/1/update', [
            'users_id' => '10',
            'sku_id' => '10',
            'amount' => '10',
            'image' => 'testUpdateImage',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試使用者對於不存在的商品進行更改購買數量
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
     * 測試使用者可以對於購物車內的商品進行刪除
     *
     * @return void
     */
    public function testCartDestroySuccess()
    {
        $this->demoUserLoginIn();
        $cart = factory(CartItem::class)->create();
        $response = $this->call('DELETE', '/cart/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試使用者對於購物車內不存在的商品進行刪除
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
     * 測試使用者可以對購物車內的商品進入更改購買數量的頁面
     *
     * @return void
     */
    public function testCartEditSuccess()
    {
        $cart = factory(CartItem::class)->create();
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/cart/1/edit');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試使用者對於不存在的購物車進入更改購買數量的頁面
     *
     * @return void
     */
    public function testCartEditWithoutCartFailed()
    {
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/cart/1/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試使用者在購物車內對不存在的商品進入更改購買數量的頁面
     *
     * @return void
     */
    public function testCartEditWithoutSkuFailed()
    {
        $cart = factory(CartItem::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/cart/1/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試使用者重複購入商品時,購物車內該商品的購買數量會增加
     *
     * @return void
     */
    public function testCartStoreRepeatSuccess()
    {
        $cart = factory(CartItem::class)->create();
        $sku = factory(Sku::class)->create([
            'users_id' => '2',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/cart/1/store', [
            "amount" => '1',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試使用者購入物品時,會放入購物車
     *
     * @return void
     */
    public function testCartStoreSuccess()
    {
        $sku = factory(Sku::class)->create([
            'users_id' => '2',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/cart/1/store', [
            "amount" => '1',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試使用者在購物車內放入不存在的商品(sku)
     *
     * @return void
     */
    public function testCartStoreFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/cart/999/store', [
            "amount" => '1',
        ]);
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試使用者在購物車內放入自己的商品(sku)
     *
     * @return void
     */
    public function testCartStoreSameUserFailed()
    {
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/cart/1/store', [
            "amount" => '1',
        ]);
        $this->assertEquals(403, $response->status());
    }

    /**
     * 測試使用者在購物車內放入超過1000個商品(sku)
     *
     * @return void
     */
    public function testCartStoreOverSuccess()
    {
        $cart = factory(CartItem::class)->create();
        $sku = factory(Sku::class)->create([
            'users_id' => '2',
            'stock' => '10000',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/cart/1/store', [
            "amount" => '1001',
        ]);
        $this->assertEquals(302, $response->status());
    }
}
