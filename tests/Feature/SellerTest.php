<?php

namespace Tests\Feature;

use App\Models\Spu;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SellerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * test get into seller page
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
     * test get into edit spu page
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
     * test get into an exist spu edit page
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
        $response = $this->call('GET', '/seller/3/edit');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test get into a non exist spu edit page
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
     * test seller update his commodity(spu)
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
        ]);
        $response = $this->call('PATCH', '/seller/4/update', [
            'name' => 'testUpdate',
            'description' => 'testUpdate',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test seller update a non exist commodity(spu)
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
        $response = $this->call('DELETE', '/seller/5/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test seller delete a non exist commodity(spu)
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
