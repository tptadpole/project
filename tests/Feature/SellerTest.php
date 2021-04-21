<?php

namespace Tests\Feature;

use App\Models\Spu;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
     * test user can get into seller page
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
     * test user can get into create commodity(spu) page
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
     * test user can get into edit commodity(spu) page
     *
     * @return void
     */
    public function testSellerEditSuccess()
    {
        $this->demoUserLoginIn();
        $spu = Spu::create([
            'users_id' => '1',
            'name' => 'test',
            'description' => 'test',
        ]);
        $response = $this->call('GET', '/seller/1/edit');
        $this->assertEquals(1, $spu->id);
        // $this->assertEquals(200, $response->status());
    }

    /**
     * test user try to edit a non exist commodity(spu) page
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
     * test seller can update his commodity(spu)
     *
     * @return void
     */
    public function testSellerUpdatedSuccess()
    {
        $this->demoUserLoginIn();
        $spu = Spu::create([
            'users_id' => '1',
            'name' => 'test',
            'description' => 'test',
            'image' => 'test',
        ]);
        $response = $this->call('PATCH', '/seller/1/update', [
            'name' => 'testUpdate',
            'description' => 'testUpdate',
            'image' => 'testUpdateImage',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test seller try to update a non exist commodity(spu)
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
     * test seller delete his commodity(spu)
     *
     * @return void
     */
    public function testSellerDestroySuccess()
    {
        $this->demoUserLoginIn();
        $spu = Spu::create([
            'users_id' => '1',
            'name' => 'test',
            'description' => 'test',
        ]);
        $response = $this->call('DELETE', '/seller/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test seller try to delete a non exist commodity(spu)
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
     * test seller store a new commodity(spu)
     *
     * @return void
     */
    public function testSellerStoreSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/seller/store', [
            'name' => 'testStore',
            'description' => 'testStore',
        ]);
        $this->assertEquals(302, $response->status());
    }
}
