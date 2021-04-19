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

    /**
     * test get into seller sku(商品物品) create page
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
        $response = $this->call('GET', '/seller/commodity/3/create/');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test get into seller sku(商品物品) edit page
     *
     * @return void
     */
    public function testSellerSkuEditSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller/commodity/1/create/');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test get into non exist seller sku(商品物品) edit page
     *
     * @return void
     */
    public function testSellerSkuEditFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/seller/commodity/999/create/');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test seller store a new conmmodity(sku)
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
     * test seller update exist sku
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
        ]);
        $response = $this->call('PATCH', '/seller/commodity/1/update', [
            'name' => 'testUpdate',
            'specification' => 'testUpdate',
            'price' => '100',
            'stock' => '100',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test seller update non exist sku
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
     * test seller delete exist sku
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
        $response = $this->call('DELETE', '/seller/commodity/2/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test seller delete non exist sku
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
