<?php

namespace Tests\Feature;

use App\Models\Sku;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSkuTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * 測試admin可以進入到admin的商品物品頁面
     *
     * @return void
     */
    public function testAdminSkuPageSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/sku');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試admin可以進入到admin的編輯商品物品頁面
     *
     * @return void
     */
    public function testAdminSkuEditSuccess()
    {
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/sku/1/edit');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試admin進入到不存在的商品物品編輯頁面
     *
     * @return void
     */
    public function testAdminSkuEditFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/sku/999/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試admin可以對商品物品進行更新
     *
     * @return void
     */
    public function testAdminSkuUpdateSuccess()
    {
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/sku/1/update', [
            'name' => 'adminTestUpdate',
            'price' => '10',
            'specification' => 'adminTestUpdate',
            'image' => 'testImageUpdate',
            'stock' => '10',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試admin對不存在的商品物品進行更新
     *
     * @return void
     */
    public function testAdminSkuUpdateFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/sku/999/update', [
            'name' => 'adminTestUpdate',
            'price' => '10',
            'specification' => 'adminTestUpdate',
            'stock' => '10',
        ]);
        $this->assertEquals(404, $response->status());
    }
    
    /**
     * 測試admin可以對商品物品進行刪除
     *
     * @return void
     */
    public function testAdminSkuDestroySuccess()
    {
        $sku = factory(Sku::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/sku/1/destroy');
        $this->assertEquals(302, $response->status());
    }
    
    /**
     * 測試admin對不存在的商品物品進行刪除
     *
     * @return void
     */
    public function testAdminSkuDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/sku/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
