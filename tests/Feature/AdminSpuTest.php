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
     * 測試admin可以進入到admin的商品標題的頁面
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
     * 測試admin可以進入到admin的編輯商品標題的頁面
     *
     * @return void
     */
    public function testAdminSpuEditSuccess()
    {
        $spu = factory(Spu::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/spu/1/edit');
        $this->assertEquals(200, $response->status());
    }
    
    /**
     * 測試admin進入到admin的不存在商品標題編輯頁面
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
     * 測試admin可以對商品標題進行更新
     *
     * @return void
     */
    public function testAdminSpuUpdateSuccess()
    {
        $spu = factory(Spu::class)->create();
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
     * 測試admin可以對不存在的商品標題進行更新
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
     * 測試admin可以對商品標題進行刪除
     *
     * @return void
     */
    public function testAdminSpuDestroySuccess()
    {
        $spu = factory(Spu::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/spu/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試admin對不存在的商品標題進行刪除
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
