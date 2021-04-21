<?php

namespace Tests\Feature;

use App\Models\Spu;
use App\Models\Sku;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
     * test seller can get into sku page
     *
     * @return void
     */
    public function testSellerSkuPage()
    {
        $sku = Sku::create([
            'users_id' => '1',
            'spu_id' => '1',
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
            'image' => 'test',
        ]);

        $spu = Spu::create([
            'users_id' => '1',
            'name' => 'test',
            'description' => 'test',
            'image' => 'test',
        ]);

        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller/commodity/1');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test seller try to get in non exist sku page
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
     * test seller can get into create sku(商品物品) page
     *
     * @return void
     */
    public function testSellerSkuCreateSuccess()
    {
        $this->demoUserLoginIn();

        $spu = Spu::create([
            'users_id' => '1',
            'name' => 'test',
            'description' => 'test',
        ]);
        $response = $this->call('GET', '/seller/commodity/1/create');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test seller can get into edit sku(商品物品)
     *
     * @return void
     */
    public function testSellerSkuEditSuccess()
    {
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
        $response = $this->call('GET', '/seller/commodity/1/edit');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test seller try to edit a non exist sku(商品物品)
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
     * test seller can store a new sku(商品物品)
     *
     * @return void
     */
    public function testSellerSkuStoreSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/seller/commodity/1/store', [
            'users_id' => '1',
            'spu_id' => '2',
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test seller can update an exist sku(商品物品)
     *
     * @return void
     */
    public function testSellerSkuUpdateSuccess()
    {
        $this->demoUserLoginIn();
        $sku = Sku::create([
            'users_id' => '1',
            'spu_id' => '2',
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
            'image' => 'test',
        ]);
        $response = $this->call('PATCH', '/seller/commodity/1/update', [
            'name' => 'testUpdate',
            'specification' => 'testUpdate',
            'price' => '100',
            'stock' => '100',
            'image' => 'testUpdateImage',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test seller try to update a non exist sku(商品物品)
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
     * test seller can delete exist sku(商品物品)
     *
     * @return void
     */
    public function testSellerSkuDestroySuccess()
    {
        $this->demoUserLoginIn();
        $sku = Sku::create([
            'users_id' => '1',
            'spu_id' => '2',
            'name' => 'test',
            'price' => '1',
            'specification' => 'test',
            'stock' => '1',
        ]);
        $response = $this->call('DELETE', '/seller/commodity/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test seller try to delete a non exist sku(商品物品)
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
