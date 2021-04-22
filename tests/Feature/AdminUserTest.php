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
     * 測試admin可以進入到admin內的user頁面
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
     * 測試admin可以進入到admin的user新增頁面
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
     * 測試admin可以新增一個user
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
     * 測試admin可以到admin的編輯user的頁面
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
     * 測試admin對於不存在的user進入到編輯頁面
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
     * 測試admin對於user進行更新
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
     * 測試admin對於不存在的user進行更新
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
     * 測試admin可以刪除user
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
     * 測試admin對於不存在的user進行刪除
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
