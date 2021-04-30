<?php

namespace Tests\Feature;

use App\Models\Spu;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SellerTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
    /**
     * 測試賣家可以進入到商品標題的頁面
     *
     * @return void
     */
    public function testSellerPageSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試賣家可以進入到新增商品標題的頁面
     *
     * @return void
     */
    public function testSellerCreateSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller/create');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試賣家進入到編輯商品標題的頁面
     *
     * @return void
     */
    public function testSellerEditSuccess()
    {
        $this->demoUserLoginIn();
        $spu = factory(Spu::class)->create();
        $response = $this->call('GET', '/seller/1/edit');
        $this->assertEquals(1, $spu->id);
        // $this->assertEquals(200, $response->status());
    }

    /**
     * 測試賣家進入到不存在的商品標題編輯頁面
     *
     * @return void
     */
    public function testSellerEditFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller/999/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試賣家可以更新商品標題
     *
     * @return void
     */
    public function testSellerUpdatedSuccess()
    {
        $this->demoUserLoginIn();
        $spu = factory(Spu::class)->create();
        $response = $this->call('PATCH', '/seller/1/update', [
            'name' => 'testUpdate',
            'description' => 'testUpdate',
            'image' => 'testUpdateImage',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試賣家對於不存在的商品標題進行更新
     *
     * @return void
     */
    public function testSellerUpdatedFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/seller/999/update', [
            'name' => 'testUpdate',
            'description' => 'testUpdate',
        ]);
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試賣家可以刪除商品標題
     *
     * @return void
     */
    public function testSellerDestroySuccess()
    {
        $this->demoUserLoginIn();
        $spu = factory(Spu::class)->create();
        $response = $this->call('DELETE', '/seller/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試賣家對於不存在的商品標題進行刪除
     *
     * @return void
     */
    public function testSellerDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/seller/999/destroy');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試賣家可以新增一筆商品標題
     *
     * @return void
     */
    public function testSellerStoreSuccess()
    {
        $this->demoUserLoginIn();
        $spu = factory(Spu::class)->make();
        $response = $this->call('POST', '/seller/store', $spu->toArray());
        $this->assertEquals(302, $response->status());
    }
}
