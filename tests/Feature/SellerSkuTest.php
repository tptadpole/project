<?php

namespace Tests\Feature;

use App\User;
use App\Models\Spu;
use App\Models\Sku;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class SellerSkuTest extends TestCase
{
    //use RefreshDatabase;
    
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
}
