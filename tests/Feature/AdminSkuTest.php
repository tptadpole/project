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
     * test admin can get into admin sku page
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
     * test admin can edit sku
     *
     * @return void
     */
    public function testAdminSkuEditSuccess()
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
        $response = $this->call('GET', '/admin/sku/1/edit');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test admin try to edit a non exist sku
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
     * test admin can update sku
     *
     * @return void
     */
    public function testAdminSkuUpdateSuccess()
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
     * test admin try to update a non exist sku
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
     * test admin can destroy to a sku
     *
     * @return void
     */
    public function testAdminSkuDestroySuccess()
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
        $response = $this->call('DELETE', '/admin/sku/1/destroy');
        $this->assertEquals(302, $response->status());
    }
    
    /**
     * test admin try to destroy a non exist sku
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
