<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
    /**
     * test admin can get into adminUser page
     *
     * @return void
     */
    public function testAdminIndexPageSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/users');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test admin can get into admin create user page
     *
     * @return void
     */
    public function testAdminCreatePageSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/users/create');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test admin store a new user
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

    /**
     * test admin can get into admin edit user page
     *
     * @return void
     */
    public function testAdminEditUserPageSuccess()
    {
        $this->demoUserLoginIn();
        $user = User::create([
            'name' => 'test',
            'email' => 'test1@test1.com',
            'password' => 'testtest',
            'role' => 'user',
        ]);
        $response = $this->call('GET', '/admin/users/1/edit');
        $this->assertEquals(200, $response->status());
    }

    /**
     * test admin try to edit a non exist user
     *
     * @return void
     */
    public function testAdminEditUserPageFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/users/999/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * test Admin can update user
     *
     * @return void
     */
    public function testAdminUpdateUserSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/users/1/update', [
            'name' => 'testAdminUpdate',
            'email' => 'testAdminUpdate@adminUpdate.com',
            'password' => 'testAdminUpdatePassword',
            'role' => 'user',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test admin try to update a nom exist user
     *
     * @return void
     */
    public function testAdminUpdateUserFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/admin/users/999/update', [
            'name' => 'testAdminUpdate',
            'email' => 'testAdminUpdate@adminUpdate.com',
            'password' => 'testAdminUpdatePassword',
            'role' => 'user',
        ]);
        $this->assertEquals(404, $response->status());
    }

    /**
     * test admin can destroy a user
     *
     * @return void
     */
    public function testAdminDestroyUserSuccess()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/users/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * test admin try to destroy a non exist user
     *
     * @return void
     */
    public function testAdminDestroyUserFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/users/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
