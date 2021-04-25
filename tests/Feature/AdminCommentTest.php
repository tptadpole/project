<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;

class AdminCommentTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * 測試能否到admin的評論頁面
     *
     * @return void
     */
    public function testAdminCommentPage()
    {
        $comment = factory(Comment::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/admin/comment');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試在admin刪除評論
     *
     * @return void
     */
    public function testAdminCommentDestroySuccess()
    {
        $comment = factory(Comment::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/comment/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試在admin刪除不存在的評論
     *
     * @return void
     */
    public function testAdminCommentDestroyFailed()
    {
        $comment = factory(Comment::class)->create();
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/admin/comment/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
