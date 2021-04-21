<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminIndexPageSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/users');
        $this->assertEquals(200, $response->status());
    }

    public function testAdminCreatePageSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/users/create');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test seller store a new conmmodity(sku)
     *
     * @return void
     */
    public function testAdminStoreUserSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/admin/users/store', [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'testtest',
            'role' => 'user',
        ]);
        $this->assertEquals(302, $response->status());
    }

    // public function testAdminEditUserPageSuccess()
    // {
    //     $this->demoUserLoginIn();
    //     $user = User::create([
    //         'name' => 'test',
    //         'email' => 'test1@test1.com',
    //         'password' => 'testtest',
    //         'role' => 'user',
    //     ]);
    //     $response = $this->call('GET', '/admin/users/1/edit');
    //     $this->assertEquals(200, $response->status());
    // }
}
