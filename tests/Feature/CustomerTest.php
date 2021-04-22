<?php

namespace Tests\Feature;

use App\Models\Spu;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
    
    /**
     * 測試所有人可以進入到"我要去購物"的頁面
     *
     * @return void
     */
    public function testCustomerTotalSuccess()
    {
        $response = $this->get('/customer');

        $response->assertStatus(200);
    }

    /**
     * 測試所有人進入單項商品標題的頁面
     *
     * @return void
     */
    public function testCustomerPickSuccess()
    {
        $spu = factory(Spu::class)->create();
        $response = $this->get('/customer/1');
        $response->assertStatus(200);
    }

    /**
     * 測試所有人進入不存在的單項商品標題的頁面
     *
     * @return void
     */
    public function testCustomerPickFailed()
    {
        $response = $this->get('/customer/999');
        $response->assertStatus(404);
    }
}
