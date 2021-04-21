<?php

namespace Tests\Feature;

use App\Models\Spu;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSpuTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * test Admin can get into Admin Spu page
     *
     * @return void
     */
    public function testAdminSpuIndexPage()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/spu');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test admin can edit spu
     *
     * @return void
     */
    public function testAdminSpuEditSuccess()
    {
        $spu = Spu::create([
            'users_id' => '1',
            'name' => 'test',
            'description' => 'test',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/spu/1/edit');
        $this->assertEquals(200, $response->status());
    }
    
    /**
     * test admin try to edit a non exist spu
     *
     * @return void
     */
    public function testAdminSpuEditFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/spu/999/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * test admin can update spu
     *
     * @return void
     */
    public function testAdminSpuUpdateSuccess()
    {
        $spu = Spu::create([
            'users_id' => '1',
            'name' => 'test',
            'description' => 'test',
            'image' => 'test'
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/spu/1/update', [
            'users_id' => '2',
            'name' => 'adminTestSpuUpdate',
            'description' => 'adminTestSpuUpdate',
            'image' => 'testImageUpdate',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test admin try to update a non exist spu
     *
     * @return void
     */
    public function testAdminSpuUpdateFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/spu/999/update', [
            'users_id' => '2',
            'name' => 'adminTestSpuUpdate',
            'description' => 'adminTestSpuUpdate',
        ]);
        $this->assertEquals(404, $response->status());
    }

    /**
     * test admin can destroy spu
     *
     * @return void
     */
    public function testAdminSpuDestroySuccess()
    {
        $spu = Spu::create([
            'users_id' => '1',
            'name' => 'test',
            'description' => 'test',
        ]);
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/spu/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test admin try to destroy a non exist spu
     *
     * @return void
     */
    public function testAdminSpuDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/spu/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
