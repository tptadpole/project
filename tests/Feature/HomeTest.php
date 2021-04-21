<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * 測試所有人都會被導向home
     *
     * @return void
     */
    public function testSuccess()
    {
        $response = $this->get('/home');
        $response->assertStatus(302);
    }
}
