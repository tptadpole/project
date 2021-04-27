<?php

namespace Tests\Feature;

use App\Models\Spu;
use App\Models\Sku;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SellerSkuTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * 測試賣家可以進入到商品物品的頁面
     *
     * @return void
     */
    public function testSellerSkuPage()
    {
        $sku = factory(Sku::class)->create();
        $spu = factory(Spu::class)->create();

        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller/commodity/1');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試賣家進入到不存在商品物品的頁面
     *
     * @return void
     */
    public function testSellerSkuPageFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller/commodity/999');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試賣家可以進入到新增商品物品的頁面
     *
     * @return void
     */
    public function testSellerSkuCreateSuccess()
    {
        $this->demoUserLoginIn();

        $spu = factory(Spu::class)->create();
        $response = $this->call('GET', '/seller/commodity/1/create');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試賣家可以進入到編輯商品物品的頁面
     *
     * @return void
     */
    public function testSellerSkuEditSuccess()
    {
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller/commodity/1/edit');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試賣家進入到不存在的商品物品的頁面
     *
     * @return void
     */
    public function testSellerSkuEditFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller/commodity/999/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試賣家可以新增一筆商品物品
     *
     * @return void
     */
    public function testSellerSkuStoreSuccess()
    {
        $this->demoUserLoginIn();
        $spu = factory(Spu::class)->create();
        $response = $this->call('POST', '/seller/commodity/1/store', [
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
            'image' => '',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試賣家新增一筆商品物品但商品標題卻不存在
     *
     * @return void
     */
    public function testSellerSkuStoreFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/seller/commodity/999/store');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試賣家可以更新商品物品
     *
     * @return void
     */
    public function testSellerSkuUpdateSuccess()
    {
        $this->demoUserLoginIn();
        $sku = factory(Sku::class)->create();
        $response = $this->call('PATCH', '/seller/commodity/1/update', [
            'name' => 'testUpdate',
            'specification' => 'testUpdate',
            'price' => 100,
            'stock' => 100,
            'image' => 'testUpdateImage',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試賣家對於不存在的商品物品進行更新
     *
     * @return void
     */
    public function testSellerSkuUpdateFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/seller/commodity/999/update', [
            'name' => 'testUpdate',
            'specification' => 'testUpdate',
            'price' => '100',
            'stock' => '100',
        ]);
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試賣家可以刪除商品物品
     *
     * @return void
     */
    public function testSellerSkuDestroySuccess()
    {
        $this->demoUserLoginIn();
        $sku = factory(Sku::class)->create();
        $response = $this->call('DELETE', '/seller/commodity/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試賣家刪除不存在的商品物品
     *
     * @return void
     */
    public function testSellerSkuDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/seller/commodity/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
